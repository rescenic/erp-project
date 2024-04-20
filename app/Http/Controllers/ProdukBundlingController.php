<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProdukBundlingController extends Controller
{
    public function index()
    {
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
        }
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bundling' => 'required',
            'produk_satuan' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error validation',
                'error' => $validator->errors()->toArray()
            ]);
        }
    }

    public function edit($id)
    {
    }

    public function update(Request $request)
    {
    }

    public function hapus(Request $request)
    {
    }
}
