<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(){

        $kategori = KategoriProduk::orderBy('kategori', 'ASC')->paginate(10);

        return view('pages.kategori.index', compact('kategori'));
    }

    public function tambah(){
        return view('pages.kategori.tambah');
    }

    public function simpan(Request $request){
        $this->validate($request, [
            'kategori' => 'required'
        ]);

        $kategori = new KategoriProduk();
        $kategori->kategori = $request->kategori;
        $kategori->save();

    }
}
