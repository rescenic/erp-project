@extends('layouts.be')

@section('title', 'Permission')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Permission</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Permission</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4></h4>
                        <div class="card-header-action">
                            <a href="{{ route('role.tambah') }}" class="btn btn-primary">
                                <i class="fas fa-sm fa-plus-circle"></i> Tambah
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('role') }}" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    @can('roles.create')
                                        <div class="input-group-prepend">
                                            <a href="{{ route('admin.role.create') }}" class="btn btn-primary"
                                                style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                        </div>
                                    @endcan
                                    <input type="text" class="form-control" name="q"
                                        placeholder="cari berdasarkan nama role">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Role</th>
                                        <th>Permission</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($role as $key => $item)
                                        <tr>
                                            <td>{{ $role->firstItem() + $key }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @foreach ($role->getPermissionNames() as $permission)
                                                    <button
                                                        class="btn btn-sm btn-success mb-1 mt-1 mr-1">{{ $permission }}</button>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('permission.edit', $item->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-sm fa-edit"></i> Edit
                                                </a>

                                                <a href="#" class="btn btn-sm btn-primary" id="hapus"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fas fa-sm fa-trash-alt"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $role->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('click', '#hapus', function() {
            let id = $(this).attr('data-id');
            Swal.fire({
                title: 'Hapus data?',
                text: "Data akan terhapus!",
                icon: 'warning',
                confirmButton: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('permission.hapus') }}",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res, status) {
                            if (status = '200') {
                                Swal.fire({
                                    icon: 'success',
                                    text: 'Data telah dihapus',
                                    title: 'Berhasil',
                                    toast: true,
                                    position: 'top-end',
                                    timer: 1500,
                                    showConfirmButton: false,
                                });
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1500);
                            }
                        },
                    })
                }
            });
        });
    </script>
@endpush
