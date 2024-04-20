<?php

namespace App\Http\Controllers;

use App\Models\Paket;
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
            $produk_paket = Paket::all();

            return datatables()->of($produk_paket)
                ->addColumn('aksi', function ($produk_paket) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('kategori.edit', $produk_paket->id) . '">
                             Edit</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $produk_paket->id . '">
                             Hapus</a>
                    </div></div>';

                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi'])
                ->toJson();
        }
    }

    public function data_produk_by_paket(Request $request)
    {
        if ($request->ajax()) {
            $produk_paket = ProdukPaket::with(['produk_satuan', 'paket'])->get();

            return datatables()->of($produk_paket)
                ->addColumn('paket', function ($produk_paket) {
                    return $produk_paket->paket->sku;
                })
                ->addColumn('produk_satuan', function ($produk_paket) {
                    return $produk_paket->produk_satuan->sku;
                })
                ->addColumn('aksi', function ($produk_paket) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('produk_paket.edit_produk_paket', $produk_paket->id) . '">
                             Edit</a>
                        <a class="dropdown-item hapus_produk_paket" href="javascript:void(0)" data-id="' . $produk_paket->id . '">
                             Hapus</a>
                    </div></div>';

                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi', 'paket', 'produk_satuan'])
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
            'nama' => 'required|unique:paket,kode',
            'sku' => 'required|unique:paket,kode',
            'jenis' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $paket = new Paket();
        $paket->kode = $request->kode;
        $paket->sku = $request->sku;
        $paket->nama = $request->nama;
        $paket->jenis = $request->jenis;
        $paket->save();


        if ($paket) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
            ], 200);
        }

        DB::beginTransaction();
    }

    public function edit($id)
    {
        $produk_paket = Paket::find($id);

        return view('pages.produk-paket.edit', [
            'produk_paket' => $produk_paket
        ]);
    }

    public function listProdukSatuan(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;
            $result = [];

            $data = DB::table('produk_satuan')
                ->select('*')
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
                ->select('*')
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

    public function listPaket(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];

            $data = DB::table('paket')
                ->select('*')
                ->where('sku', 'LIKE', '%' . $search . '%')
                ->get();

            foreach ($data as $d) {
                $result = [
                    'id' => $d->id,
                    'text' => $d->sku
                ];
            }

            return response()->json($result);
        } else {

            $result = [];
            $data = DB::table('paket')
                ->select('*')
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->sku
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

    public function tambahProdukByPaket()
    {
        return view('pages.produk-paket.tambah-produk-by-paket');
    }

    public function simpanProdukByPaket(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'produk_satuan' => 'required',
            'produk_paket' => 'required',
            'qty_satuan' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $produk_paket = new ProdukPaket();
        $produk_paket->produk_satuan_id = $request->produk_satuan;
        $produk_paket->paket_id = $request->produk_paket;
        $produk_paket->qty_satuan = $request->qty_satuan;
        $produk_paket->save();


        if ($produk_paket) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
            ]);
        }
    }


    public function editProdukByPaket($id_produk_paket)
    {
        $produk_paket = ProdukPaket::find($id_produk_paket);

        return view('pages.produk-paket.edit-produk-by-paket', [
            'produk_paket' => $produk_paket
        ]);
    }


    public function hapus_produk_paket(Request $request)
    {
        $produk_paket = ProdukPaket::find($request->id);

        $produk_paket->delete();

        if ($produk_paket) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus',
            ]);
        }
    }

    public function paketByProdukPaket(Request $request)
    {
        $data = DB::table('paket')
            ->select('paket.*')
            ->join('produk_paket', 'produk_paket.paket_id', '=', 'paket.id')
            ->get();

        return response()->json($data);
    }


    public function produkSatuanByPaket(Request $request)
    {
        $data = DB::table('produk_satuan')
            ->select('produk_satuan.*')
            ->join('produk_paket', 'produk_paket.produk_satuan_id', '=', 'produk_satuan.id')
            ->get();

        return response()->json($data);
    }

    public function updateProdukByPaket(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'produk_paket' => 'required',
            'produk_satuan' => 'required',
            'qty_satuan' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $produk_paket = ProdukPaket::find($request->id);
        $produk_paket->produk_satuan_id = $request->produk_satuan;
        $produk_paket->paket_id = $request->produk_paket;
        $produk_paket->qty_satuan = $request->qty_satuan;
        $produk_paket->save();


        if ($produk_paket) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah',
            ]);
        }
    }
}
