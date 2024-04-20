<?php

namespace App\Http\Controllers;

use App\Models\Bundling;
use App\Models\ProdukBundling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProdukBundlingController extends Controller
{
    public function index()
    {
        return view('pages.produk-bundling.index');
    }


    public function tambah()
    {
        return view('pages.produk-bundling.tambah');
    }


    public function data(Request $request)
    {
        if ($request->ajax()) {
            $bundling = Bundling::all();

            return datatables()->of($bundling)
                ->addColumn('aksi', function ($bundling) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('produk_bundling.edit', $bundling->id) . '">
                             Edit</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $bundling->id . '">
                             Hapus</a>
                    </div></div>';

                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi'])
                ->toJson();
        }
    }



    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'nama' => 'required',
            'sku' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $bundling = new Bundling();
        $bundling->kode = $request->kode;
        $bundling->sku = $request->sku;
        $bundling->nama = $request->nama;
        $bundling->save();

        if ($bundling) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan'
            ]);
        }
    }

    public function edit($id)
    {
        $bundling = Bundling::find($id);

        return view('pages.produk-bundling.edit', [
            'bundling' => $bundling
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:bundling,kode,' . $request->id,
            'sku' => 'required|unique:bundling,kode,' . $request->id,
            'nama' => 'required|unique:bundling,kode,' . $request->id,

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $bundling = Bundling::find($request->id);
        $bundling->kode = $request->kode;
        $bundling->sku = $request->sku;
        $bundling->nama = $request->nama;

        $bundling->save();


        if ($bundling) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah'
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $bundling = Bundling::find($request->id);

        $bundling->delete();

        if ($bundling) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ]);
        }
    }


    public function dataProdukByBundling(Request $request)
    {
        if ($request->ajax()) {



            if (empty($request->sku_bundling)) {
                $bundling = ProdukBundling::with(['bundling', 'produk_satuan'])->get();
                return datatables()->of($bundling)
                    ->addColumn('bundling', function ($bundling) {
                        return $bundling->bundling->sku;
                    })
                    ->addColumn('produk_satuan', function ($bundling) {
                        return $bundling->produk_satuan->sku;
                    })
                    ->addColumn('aksi', function ($bundling) {
                        $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                        $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('produk_bundling.edit', $bundling->id) . '">
                             Edit</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $bundling->id . '">
                             Hapus</a>
                    </div></div>';

                        return $button;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'bundling'])
                    ->toJson();
            } else {

                $sku_bundling = $request->sku_bundling;

                $bundling = ProdukBundling::whereHas('bundling', function ($q) use ($sku_bundling) {
                    $q->where('bundling.id', $sku_bundling);
                })->with(['produk_satuan'])->get();

                return datatables()->of($bundling)
                    ->addColumn('bundling', function ($bundling) {
                        return $bundling->bundling->sku;
                    })
                    ->addColumn('produk_satuan', function ($bundling) {
                        return $bundling->produk_satuan->sku;
                    })
                    ->addColumn('aksi', function ($bundling) {
                        $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                        $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('produk_bundling.edit', $bundling->id) . '">
                             Edit</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $bundling->id . '">
                             Hapus</a>
                    </div></div>';

                        return $button;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'bundling'])
                    ->toJson();
            }
        }
    }


    public function tambahProdukByBundling()
    {
        return view('pages.produk-bundling.tambah-produk-bundling');
    }

    public function simpanProdukByByBundling(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bundling' => 'required',
            'produk_satuan' => 'required',
            'jenis' => 'required',
            'qty_satuan' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->toArray()
            ]);;
        }

        $produk_bundling = new ProdukBundling();
        $produk_bundling->bundling_id = $request->bundling;
        $produk_bundling->produk_satuan_id = $request->produk_satuan;
        $produk_bundling->jenis = $request->jenis;
        $produk_bundling->qty_satuan = $request->qty_satuan;
        $produk_bundling->save();

        if ($produk_bundling) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan'
            ]);
        }
    }



    public function editProdukBundling($id_produk_bundling)
    {
        $produk_bundling = ProdukBundling::find($id_produk_bundling);

        return view('pages.produk-bundling.edit', [
            'produk_bundling' => $produk_bundling
        ]);
    }


    public function updateProdukBundling(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bundling' => 'required',
            'produk_satuan' => 'required',
            'jenis' => 'required',
            'qty_satuan' => 'required'
        ]);

        $produk_bundling = ProdukBundling::find($request->id);
        $produk_bundling->bundling_id = $request->bundling;
        $produk_bundling->produk_satuan_id = $request->produk_satuan;
        $produk_bundling->jenis = $request->jenis;
        $produk_bundling->qty_satuan = $request->qty_satuan;
        $produk_bundling->save();


        if ($validator->fails()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah'
            ]);
        }
    }


    public function hapusProdukBundling(Request $request)
    {
        $produk_bundling = ProdukBundling::find($request->id);

        $produk_bundling->delete();

        if ($produk_bundling) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ]);
        }
    }

    public function listProdukSatuan(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];

            $data = DB::table('produk_satuan')
                ->select('*')
                ->where('sku', 'LIKE', '%' . $search . '%')
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->sku
                ];
            }

            return response()->json($result);
        } else {
            $result = [];

            $data = DB::table('produk_satuan')
                ->select('produk_satuan.*')
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


    public function listBundling(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];

            $data = DB::table('bundling')
                ->select('bundling.*')
                ->where('bundling.sku', 'LIKE', '%' . $search . '%')
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->sku
                ];
            }

            return response()->json($result);
        } else {
            $result = [];

            $data = DB::table('bundling')
                ->select('bundling.*')
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


    public function produkSatuanByProdukBundling(Request $request)
    {
        $data = DB::table('produk_satuan')
            ->select('produk_satuan.*')
            ->join('produk_bundling', 'produk_bundling.produk_satuan_id', '=', 'produk_satuan.id')
            ->get();

        return response()->json($data);
    }

    public function bundlingByProdukBundling(Request $request)
    {
        $data = DB::table('bundling')
            ->select('bundling.*')
            ->join('produk_bundling', 'produk_bundling.bundling_id', '=', 'bundling.id')
            ->get();

        return response()->json($data);
    }
}
