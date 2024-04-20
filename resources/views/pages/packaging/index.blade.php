@extends('layouts.be')

@section('title', 'Packaging')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Packaging</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Packaging</div>
                </div>
            </div>

            <a href="javascript:void(0)" class="btn btn-sm btn-primary my-3 master_packaging">
                Master packaging
            </a>

            <a href="javascript:void(0)" class="btn btn-sm btn-primary my-3 produk_by_packaging">
                Produk By Packaging
            </a>


            <div class="section-body">
                <div id="master_packaging">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <a href="{{ route('packaging.tambah') }}" class="btn btn-primary">
                                    <i class="fas fa-sm fa-plus-circle"></i> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width: 100%" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="produk_by_packaging">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-sm fa-plus-circle"></i> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width: 100%" id="dataTableProdukByPackaging">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        function data_packaging() {
            $('#dataTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 25, -1],
                    [10, 20, 25, "50"]
                ],

                order: [],
                ajax: {
                    url: "{{ route('packaging.data') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },

                    {
                        data: 'nama',
                        name: 'nama'
                    },

                    {
                        data: 'kategori',
                        name: 'kategori'
                    },

                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            });
        }

        function data_produk_by_packaging() {
            $('#dataTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 25, -1],
                    [10, 20, 25, "50"]
                ],

                order: [],
                ajax: {
                    url: "{{ route('packaging.data') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },

                    {
                        data: 'nama',
                        name: 'nama'
                    },

                    {
                        data: 'kategori',
                        name: 'kategori'
                    },

                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            });
        }

        $(document).ready(function() {
            $('#master_packaging').show();
            data_packaging();
            $('#produk_by_packaging').hide();
        });

        $(document).on('click', '.produk_by_packaging', function() {
            $('#master_packaging').hide();

            $('#produk_by_packaging').show();
        });

        $(document).on('click', '.master_packaging', function() {
            $('#master_packaging').show();

            $('#produk_by_packaging').hide();
        });

        $(document).on('click', '.hapus', function() {
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
                        url: "{{ route('kategori.hapus') }}",
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
                                $('#dataTable').DataTable().ajax.reload();
                            }
                        },
                    })
                }
            });
        });
    </script>
@endpush
