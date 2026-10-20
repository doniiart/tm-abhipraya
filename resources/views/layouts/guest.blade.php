<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tunas Muda Abhipraya') }}</title>
        <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased selection:bg-red-500 selection:text-white h-full relative overflow-x-hidden bg-slate-50">
        
        <!-- Ornamen Background Sangat Halus -->
        <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50">
            <!-- Cahaya sudut yang sangat lembut -->
            <div class="absolute top-[-15%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-red-100/40 blur-[100px]"></div>
            <div class="absolute bottom-[-15%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-amber-100/40 blur-[100px]"></div>
            <!-- Grid / titik sangat tipis untuk tekstur -->
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
        </div>

        <!-- Container Utama -->
        <div class="min-h-full flex flex-col justify-center items-center py-12 px-4 sm:px-6 relative z-10">
            
            <!-- Slot Header (Logo) -->
            <div class="w-full sm:max-w-md mb-6">
                @if (isset($header))
                    {{ $header }}
                @endif
            </div>

            <!-- Kotak Form Putih Bersih (Clean & Soft Shadow) -->
            <div class="w-full sm:max-w-md px-8 py-10 bg-white border border-slate-100 shadow-2xl shadow-slate-200/50 rounded-[2rem]">
                {{ $slot }}
            </div>
            
            <!-- Footer Simple -->
            <div class="mt-8 text-center text-[11px] font-bold text-slate-400 tracking-widest uppercase">
                &copy; {{ date('Y') }} Karang Taruna Tunas Muda Abhipraya
            </div>

        </div>
    </body>
</html>