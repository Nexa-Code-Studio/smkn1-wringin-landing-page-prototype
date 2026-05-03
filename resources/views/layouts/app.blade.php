<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'SMKN 1 Wringin - Sekolah Menengah Kejuruan Negeri yang mencetak generasi cerdas, terampil, dan berkarakter. Siap Kerja, Santun, Mandiri.')">
    <meta name="keywords" content="@yield('meta_keywords', 'SMKN 1 Wringin, SMK, sekolah kejuruan, pendidikan vokasi, TAV, DKV, TKJ, TKRO')">
    <meta name="author" content="SMKN 1 Wringin">
    @stack('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SMKN 1 Wringin - Siap Kerja, Santun, Mandiri')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-600 antialiased">
    @yield('content')

    @stack('scripts')
</body>
</html>
