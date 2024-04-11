<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return view('pages.permission.index');
    }

    public function dataPermission(Request $request)
    {
        if ($request->ajax()) {
            $permission = Permission::orderBy('name', 'ASC')
                ->get();

            return datatables()->of($permission)
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="dropdown d-inline mr-2"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sm fa-edit"></i> Aksi
                    </button>';

                    $button .= ' <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="kategoriEdit(this, ' . $data->id . ')">
                             Edit</a>
                        <a class="dropdown-item hapus" href="javascript:void(0)" data-id="' . $data->id . '">
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
        return view('pages.permission.tambah');
    }

    public function simpan(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->permission;
        $permission->save();

        if ($permission) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
                'data' => $permission
            ]);
        }
    }


    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('pages.permission.edit', [
            'permission' => $permission
        ]);
    }


    public function update(Request $request)
    {
        $permission = Permission::find($request->id);

        $permission->name = $request->permission;
        $permission->save();

        if ($permission) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah',
                'data' => $permission
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $permission = Permission::find($request->id);

        $permission->delete();

        if ($permission) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus',
            ]);
        }
    }
}
