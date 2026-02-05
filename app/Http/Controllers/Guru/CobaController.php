<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Auth;

class CobaController extends Controller
{
   public function index()
{
    $coba = DB::table('pengumpulan_tugas')
        ->where('status', 'dikirim')
        ->get();
 
    return view('guru.coba.index', compact('coba'));
}

}



