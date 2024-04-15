<?php

namespace App\Http\Controllers;

use App\Models\ProdukSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProdukSatuanController extends Controller
{
    public function index()
    {
        return view('pages.produk-satuan.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $produk_satuan = ProdukSatuan::with(['kategori_produk'])->get();

            return datatables()->of($produk_satuan)
                ->addColumn('kategori_produk', function ($produk_satuan) {

                    $kategori_produk = $produk_satuan->kategori_produk->kategori;

                    return $kategori_produk;;
                })
                ->addColumn('aksi', function ($produk_satuan) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('produk_satuan.edit', $produk_satuan->id) . '">
                             Edit</a>
                             <a class="dropdown-item" href="' . route('produk_satuan.edit', $produk_satuan->id) . '">
                             Detail</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $produk_satuan->id . '">
                             Hapus</a>
                    </div></div>';

                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi', 'kategori_produk'])
                ->toJson();
        }
    }

    public function tambah()
    {
        return view('pages.produk-satuan.tambah');
    }

    public function listKategori(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];

            $kategori_produk = DB::table('kategori')
                ->select('*')
                ->where('kategori', 'LIKE', '%', $search, '%')
                ->get();

            foreach ($kategori_produk as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kategori
                ];
            }

            return response()->json($result);
        } else {
            $result = [];

            $kategori_produk = DB::table('kategori')
                ->select('*')
                ->get();

            foreach ($kategori_produk as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kategori
                ];
            }

            return response()->json($result);
        }
    }


    public function kategoriByProdukSatuan(Request $request)
    {
        $kategori_produk = DB::table('kategori')
            ->select('kategori.*')
            ->join('produk_satuan', 'produk_satuan.kategori_id', '=', 'kategori.id')
            ->where('produk_satuan.id', $request->produk_satuan_id)
            ->get();

        return response()->json($kategori_produk);
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:produk_satuan,kode',
            'nama' => 'required',
            'kategori' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $produk_satuan = new ProdukSatuan();
        $produk_satuan->kode = $request->kode;
        $produk_satuan->nama = $request->nama;
        $produk_satuan->sku = $request->sku;
        $produk_satuan->no_bpom = $request->no_bpom;
        $produk_satuan->kategori_id = $request->kategori;
        $produk_satuan->save();

        if ($produk_satuan) {
            return response()
                ->json([
                    'status' => 'success',
                    'message' => 'Data disimpan',
                    'data' => $produk_satuan
                ]);
        }
    }


    public function edit($id)
    {
        $produk_satuan = ProdukSatuan::findOrFail($id);

        return view('pages.produk-satuan.edit', [
            'produk_satuan' => $produk_satuan
        ]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:produk_satuan,kode,' . $request->id,
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $produk_satuan = ProdukSatuan::find($request->id);
        $produk_satuan->kode = $request->kode;
        $produk_satuan->nama = $request->nama;
        $produk_satuan->sku = $request->sku;
        $produk_satuan->no_bpom = $request->no_bpom;
        $produk_satuan->kategori_id = $request->kategori;
        $produk_satuan->save();

        if ($produk_satuan) {
            return response()
                ->json([
                    'status' => 'success',
                    'message' => 'Data diubah',
                    'data' => $produk_satuan
                ]);
        }
    }

    public function hapus($id)
    {
        $produk_satuan = ProdukSatuan::find($id);

        $produk_satuan->delete();

        if ($produk_satuan) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ]);
        }
    }
}
