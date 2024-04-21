<?php

namespace App\Http\Controllers;

use App\Models\Packaging;
use App\Models\ProdukPackaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PackagingController extends Controller
{
    public function index()
    {
        return view('pages.packaging.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $packaging = Packaging::with(['kategori_packaging', 'produk_satuan'])->get();

            return datatables()->of($packaging)
                ->addColumn('kategori', function ($packaging) {
                    return $packaging->kategori_packaging->kategori;
                })
                ->addColumn('produk_satuan', function ($packaging) {
                    $produk_satuan = '';
                    foreach ($packaging->produk_satuan as $ps) {
                        $produk_satuan .= '<button class="btn btn-sm btn-success mb-1 mt-1 mr-1">' . $ps->sku . '</button>';
                    }
                    return $produk_satuan;
                })
                ->addColumn('aksi', function ($packaging) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('kategori_packaging.edit', $packaging->id) . '">
                             Edit</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $packaging->id . '">
                             Hapus</a>
                    </div></div>';

                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['aksi', 'kategori', 'produk_satuan'])
                ->toJson();
        }
    }

    public function tambah()
    {
        return view('pages.packaging.tambah');
    }

    public function listKategoriPackaging(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];

            $data = DB::table('kategori_packaging')
                ->select('kategori_packaging.*')
                ->where('kategori_packaging.kategori', 'LIKE', '%' . $search . '%')
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kategori
                ];
            }

            return response()->json($result);
        } else {
            $result = [];

            $data = DB::table('kategori_packaging')
                ->select('kategori_packaging.*')
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kategori
                ];
            }

            return response()->json($result);
        }
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_packaging' => 'required',
            'kode' => 'required|unique:packaging,kode',
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->toArray()
            ]);
        }

        DB::beginTransaction();

        try {
            $packaging = new Packaging();
            $packaging->kode = $request->kode;
            $packaging->nama = $request->nama;
            $packaging->kategori_packaging_id = $request->kategori_packaging;
            $packaging->save();

            $packaging->produk_satuan()->attach($request->produk_satuan);

            DB::commit();

            if ($packaging) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data disimpan'
                ]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error db transaction',
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $packaging = Packaging::find($id);

        return view('pages.packaging.edit', [
            'packaging' => $packaging
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_packaging' => 'required',
            'kode' => 'required|unique:packaging,kode,' . $request->id,
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $packaging = Packaging::find($request->id);
        $packaging->kode = $request->kode;
        $packaging->nama = $request->nama;
        $packaging->kategori_packaging_id = $request->kategori_packaging;
        $packaging->save();

        if ($packaging) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah'
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $packaging = Packaging::find($request->id);

        $packaging->delete();

        if ($packaging) {
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
                ->select('produk_satuan.*')
                ->where('produk_satuan.*', 'LIKE', '%' . $search . '%')
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
}
