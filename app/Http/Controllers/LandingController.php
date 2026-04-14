<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(): View
    {
        return view('landing');
    }

    /**
     * Display the jurusan detail page.
     */
    public function jurusanDetail(): View
    {
        return view('pages.jurusan-detail');
    }

    /**
     * Display the kurikulum detail page.
     */
    public function kurikulumDetail(): View
    {
        return view('pages.kurikulum-detail');
    }

    /**
     * Display the budaya positif page.
     */
    public function budayaPositif(): View
    {
        return view('pages.budaya-positif');
    }

    /**
     * Display the ekstrakurikuler page.
     */
    public function ekstrakurikuler(): View
    {
        return view('pages.ekstrakurikuler');
    }
}
