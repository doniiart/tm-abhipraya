<?php

namespace App\Http\Controllers;

use App\Models\LaporanSekretaris;
use App\Models\SettingWeb;
use App\Models\Iuran;
use App\Models\RekapPertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SekretarisController extends Controller
{
    // 1. Fungsi untuk Ruang Kerja Sekretaris (Mode Edit / Input)
    public function index()
    {
        $settingAgenda = SettingWeb::first();
        
        $agenda = (object) [
            'location' => $settingAgenda->agenda_lokasi ?? 'Belum ada lokasi', 
            'title'    => $settingAgenda->agenda_nama ?? 'Belum ada agenda',
            'date'     => ($settingAgenda->agenda_tanggal ?? '') . ' ' . ($settingAgenda->agenda_bulan ?? ''),
        ];

        // Hitung data yang belum direkap
        $humasCandi = Iuran::join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')
            ->where('anggotas.rt', '=', '23')
            ->where('iurans.is_rekap', false)
            ->sum(DB::raw('arisan + tabungan + dansos'));

        $humasGunung = Iuran::join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')
            ->where('anggotas.rt', '!=', '23')
            ->where('iurans.is_rekap', false)
            ->sum(DB::raw('arisan + tabungan + dansos'));

        $totalArisanMasuk = Iuran::where('is_rekap', false)->sum('arisan');
        $potonganDansos = ($totalArisanMasuk > 0) ? 25000 : 0;

        $totalKasMuda = \App\Models\KasMuda::sum('nominal');
        $totalKasTua = \App\Models\KasTua::sum('nominal');

        $laporanSekretaris = LaporanSekretaris::latest()->first();

        return view('sekretaris.index', compact(
            'agenda', 'humasCandi', 'humasGunung', 'totalArisanMasuk', 'potonganDansos', 'totalKasMuda', 'totalKasTua', 'laporanSekretaris'
        ));
    }

    // 2. Fungsi untuk Tontonan Publik (Read-Only bagi Anggota)
    public function laporanPublik()
    {
        // Jika yang login adalah Sekretaris, arahkan ke ruang kerja utamanya
        if (Auth::check()) {
            $isSekretaris = Auth::user()->roles()->where('slug', 'sekretaris')->exists();
            if ($isSekretaris) {
                return redirect('/laporan/sekretaris');
            }
        }

        $settingAgenda = SettingWeb::first();
        
        $agenda = (object) [
            'location' => $settingAgenda->agenda_lokasi ?? 'Belum ada lokasi', 
            'title'    => $settingAgenda->agenda_nama ?? 'Belum ada agenda',
            'date'     => ($settingAgenda->agenda_tanggal ?? '') . ' ' . ($settingAgenda->agenda_bulan ?? ''),
        ];

        $humasCandi = Iuran::join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')
            ->where('anggotas.rt', '=', '23')
            ->where('iurans.is_rekap', false)
            ->sum(DB::raw('arisan + tabungan + dansos'));

        $humasGunung = Iuran::join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')
            ->where('anggotas.rt', '!=', '23')
            ->where('iurans.is_rekap', false)
            ->sum(DB::raw('arisan + tabungan + dansos'));

        $totalArisanMasuk = Iuran::where('is_rekap', false)->sum('arisan');
        $potonganDansos = ($totalArisanMasuk > 0) ? 25000 : 0;

        $totalKasMuda = \App\Models\KasMuda::sum('nominal');
        $totalKasTua = \App\Models\KasTua::sum('nominal');

        $laporanSekretaris = LaporanSekretaris::latest()->first();

        return view('sekretaris.publik', compact(
            'agenda', 'humasCandi', 'humasGunung', 'totalArisanMasuk', 'potonganDansos', 'totalKasMuda', 'totalKasTua', 'laporanSekretaris'
        ));
    }

    // 3. Fungsi untuk Simpan Catatan / Tutup Buku
    public function simpanCatatan(Request $request)
    {
        $request->validate(['usulan_saran' => 'required|string']);
        $action = $request->input('action');

        if ($action == 'draft') {
            $laporan = LaporanSekretaris::latest()->first();
            if ($laporan) {
                $laporan->update(['usulan_saran' => $request->usulan_saran]);
            } else {
                LaporanSekretaris::create(['usulan_saran' => $request->usulan_saran]);
            }
            return redirect()->back()->with('success', 'Draft Notulensi berhasil disimpan sementara!');
        }

        if ($action == 'final') {
            $settingAgenda = SettingWeb::first();
            
            $humasCandi = Iuran::join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')->where('anggotas.rt', '=', '23')->where('iurans.is_rekap', false)->sum(DB::raw('arisan + tabungan + dansos'));
            $humasGunung = Iuran::join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')->where('anggotas.rt', '!=', '23')->where('iurans.is_rekap', false)->sum(DB::raw('arisan + tabungan + dansos'));
            $totalArisanMasuk = Iuran::where('is_rekap', false)->sum('arisan');
            $potonganDansos = ($totalArisanMasuk > 0) ? 25000 : 0;

            RekapPertemuan::create([
                'agenda_lokasi' => $settingAgenda->agenda_lokasi ?? 'Belum ada lokasi',
                'agenda_nama' => $settingAgenda->agenda_nama ?? 'Belum ada agenda',
                'agenda_tanggal' => ($settingAgenda->agenda_tanggal ?? '') . ' ' . ($settingAgenda->agenda_bulan ?? ''),
                'total_candi' => $humasCandi,
                'total_gunung' => $humasGunung,
                'total_arisan' => $totalArisanMasuk,
                'potongan_dansos' => $potonganDansos,
                'notulensi' => $request->usulan_saran,
            ]);

            Iuran::where('is_rekap', false)->update(['is_rekap' => true]);
            LaporanSekretaris::truncate(); 

            return redirect()->back()->with('success', 'Tutup Buku Berhasil!');
        }
    }

    // 4. Fungsi untuk Menampilkan Riwayat Kesimpulan Keseluruhan
    public function kesimpulanKeseluruhan()
    {
        $rekapData = RekapPertemuan::orderBy('created_at', 'desc')->get();
        return view('sekretaris.kesimpulan', compact('rekapData'));
    }
}