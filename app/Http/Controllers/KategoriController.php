<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        return view('pages.kategori.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $kategori_produk = KategoriProduk::all();

            return datatables()->of($kategori_produk)
                ->addColumn('aksi', function ($kategori_produk) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('kategori.edit', $kategori_produk->id) . '">
                             Edit</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $kategori_produk->id . '">
                             Hapus</a>
                    </div></div>';

                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi'])
                ->toJson();
        }
    }

    public function tambah()
    {
        return view('pages.kategori.tambah');
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'kategori' => 'required'
        ]);

        $kategori = new KategoriProduk();
        $kategori->kategori = $request->kategori;
        $kategori->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Data disimpan',
            'data' => $kategori
        ]);
    }


    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        return view('pages.kategori.edit', [
            'kategori' => $kategori
        ]);
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $kategori = KategoriProduk::find($request->id);

        $kategori->kategori = $request->kategori;
        $kategori->save();

        if ($kategori) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah',
                'data' => $kategori
            ]);
        }
    }


    public function hapus(Request $request)
    {
        $kategori = KategoriProduk::find($request->id);

        $kategori->delete();

        if ($kategori) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus',
            ]);
        }
    }
}
