<?php

namespace App\Http\Controllers;

use App\Models\KategoriPackaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriPackagingController extends Controller
{
    public function index()
    {
        return view('pages.kategori-packaging.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $kategori_packaging = KategoriPackaging::all();

            return datatables()->of($kategori_packaging)
                ->addColumn('aksi', function ($kategori_packaging) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('kategori_packaging.edit', $kategori_packaging->id) . '">
                             Edit</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $kategori_packaging->id . '">
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
        return view('pages.kategori-packaging.tambah');
    }

    public function simpan(Request $request)
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

        $kategori_packaging = new KategoriPackaging();
        $kategori_packaging->kategori = $request->kategori;
        $kategori_packaging->save();


        if ($kategori_packaging) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan'
            ]);
        }
    }

    public function edit($id)
    {
        $kategori_packaging = KategoriPackaging::find($id);

        return view('pages.kategori-packaging.edit', [
            'kategori_packaging' => $kategori_packaging
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

        $kategori_packaging = KategoriPackaging::find($request->id);
        $kategori_packaging->kategori = $request->kategori;
        $kategori_packaging->save();


        if ($kategori_packaging) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah'
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $kategori_packaging = KategoriPackaging::find($request->id);

        $kategori_packaging->delete();

        if ($kategori_packaging) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ]);
        }
    }
}
