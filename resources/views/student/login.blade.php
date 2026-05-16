<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Siswa - Portal Berita</title>
    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-xl">
            <div class="mb-8 text-center">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Portal Berita Siswa</p>
                <h1 class="mt-3 text-2xl font-extrabold text-slate-900">Masuk Sebagai Siswa</h1>
                <p class="mt-2 text-sm text-slate-500">Gunakan akun siswa yang sudah diizinkan untuk mengirim berita.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('siswa.authenticate') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                </div>
                <div>
                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Password</label>
                    <input type="password" name="password" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                </div>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-700">Masuk ke Portal Berita</button>
            </form>

            <div class="mt-6 text-center text-sm text-slate-500">
                <a href="{{ route('landing') }}" class="font-semibold text-brand-600 hover:text-brand-700">Kembali ke beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
