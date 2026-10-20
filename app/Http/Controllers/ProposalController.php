<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProposalController extends Controller
{
    //mencatat usulan baru saat kumpulan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'meeting_id' => 'required|exists:meetings,id',
            'member_id' => 'required|exists:members,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Proposal::create($validated);
        
        return redirect()->back()->with('succes', 'Usulan anggota berhasil dicatat!');
    }

    public function updateStatus(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,discussed,approved,postponed,rejected,done',
            'pic_id' => 'nullable|exists:users,id',
            'target_date' => 'nullable|date',
        ]);

        $proposal->update($validated);

        return redirect()->back()->with('success', 'Status usulan berhasil diperbarui!');
    }
}
