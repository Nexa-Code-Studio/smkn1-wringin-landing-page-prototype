@extends('layouts.app')

@section('title', 'SMKN 1 Wringin - Siap Kerja, Santun, Mandiri')

@section('content')
    @include('partials.navbar')
    @include('partials.hero')
    @include('partials.jurusan')
    @include('partials.profil')
    @include('partials.berita')
    @include('partials.ppdb')
    @include('partials.footer')
@endsection
