<?php

namespace App\Http\Controllers;

use App\Models\ProdukPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProdukPaketController extends Controller
{
    public function index()
    {
        return view('pages.produk-paket.index');
    }


    public function data(Request $request)
    {
        if ($request->ajax()) {
            $kategori_produk = ProdukPaket::all();

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
        return view('pages.produk-paket.tambah');
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:paket,kode',
            'nama' => 'required|unique:paket,nama',
            'sku' => 'required|unique:paket,sku',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()->toArray()
            ]);
        }

        DB::beginTransaction();

        try {
            $paket = new ProdukPaket();
            $paket->kode = $request->kode;
            $paket->sku = $request->sku;
            $paket->nama = $request->nama;
            $paket->save();


            $produk_paket = $paket->produk_satuan()->attach($request->produk_satuan);

            DB::commit();

            if ($produk_paket) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data disimpan',
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'Something erorr',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $produk_paket = ProdukPaket::find($id);

        return view('pages.produk-paket.edit', [
            'produk_paket' => $produk_paket
        ]);
    }

    public function produk_satuan(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;
            $result = [];

            $data = DB::table('produk_satuan')
                ->select('produk_satuan.sku')
                ->where('produk_satuan.sku', 'LIKE', '%' . $search . '%')
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->sku,
                ];
            }

            return response()->json($result);
        } else {
            $search = $request->q;
            $result = [];

            $data = DB::table('produk_satuan')
                ->select('produk_satuan.sku')
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->sku,
                ];
            }

            return response()->json($result);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:paket,kodem,' . $request->id,
            'nama' => 'required|unique:paket,nama,' . $request->id,
            'sku' => 'required|unique:paket,sku,' . $request->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()->toArray()
            ]);
        }

        DB::beginTransaction();

        try {
            $paket = ProdukPaket::find($request->id);
            $paket->kode = $request->kode;
            $paket->sku = $request->sku;
            $paket->nama = $request->nama;
            $paket->save();


            $produk_paket = $paket->produk_satuan()->sync($request->produk_satuan);

            DB::commit();

            if ($produk_paket) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data diubah',
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'Something erorr',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $paket = ProdukPaket::find($request->id);

        $paket->delete();

        if ($paket) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ]);
        }
    }
}
