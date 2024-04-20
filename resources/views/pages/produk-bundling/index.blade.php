@extends('layouts.be')

@section('title', 'Produk Bundling')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Bundling</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Bundling</div>
                </div>
            </div>

            <div class="section-body">

                <a href="javascript:void(0)" class="btn btn-sm btn-primary my-3 master_bunlding">
                    Master Bundling
                </a>

                <a href="javascript:void(0)" class="btn btn-sm btn-primary my-3 produk_by_bundling">
                    Produk By Bundling
                </a>


                <div id="master_bundling">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <a href="{{ route('produk_bundling.tambah') }}" class="btn btn-primary">
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
                                            <th>Sku</th>

                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="produk_by_bundling">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <a href="{{ route('produk_bundling.tambahProdukByBundling') }}" class="btn btn-primary">
                                    <i class="fas fa-sm fa-plus-circle"></i> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Sku Bundling:</label>
                                <select name="bundling" id="sku_bundling" class="form-control"></select>
                            </div>

                            <a class="btn btn-sm btn-primary text-white">
                                <i class="fas fa-sm fa-search"></i> Cari
                            </a>

                            <a class="btn btn-sm btn-primary text-white reset_produk_bundling">
                                <i class="fas fa-sm fa-trash"></i> Reset
                            </a>

                            <div class="table-responsive my-3">
                                <table class="table table-bordered" style="width: 100%" id="dataTableProdukBundling">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bundling</th>
                                            <th>Produk Satuan</th>
                                            <th>Qty Satuan</th>
                                            <th>Jenis</th>
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
        function data_master_bundling() {
            $('#dataTable').DataTable({
                searching: false,
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
                    url: "{{ route('produk_bundling.data') }}",
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
                        data: 'sku',
                        name: 'sku'
                    },

                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            });
        }

        $(document).ready(function() {
            $('#sku_bundling').select2({
                minimumInputLength: 3,
                multiple: false,
                placeholder: '--Pilih sku bundling',
                allowClear: true,
                ajax: {
                    url: "{{ route('produk_bundling.listBundling') }}",
                    dataType: 'json',
                    delay: 500,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            $('#sku_bundling').on('change', function() {
                var sku_bundling = $(this).val();

                data_produk_bundling(sku_bundling);
            });
        });

        $(document).on('click', '.reset_produk_bundling', function() {
            $('#sku_bundling').val('').trigger('change');
            data_produk_bundling();
        });

        function data_produk_bundling(sku_bundling = '') {
            $('#dataTableProdukBundling').DataTable({
                searching: false,
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
                    url: "{{ route('produk_bundling.dataProdukByBundling') }}",
                    data: {
                        sku_bundling: sku_bundling,
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        data: 'bundling',
                        name: 'bundling'
                    },
                    {
                        data: 'produk_satuan',
                        name: 'produk_satuan'
                    },
                    {
                        data: 'qty_satuan',
                        name: 'qty_satuan'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },

                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            });
        }


        $(document).on('click', '.produk_by_bundling', function() {
            $('#master_bundling').hide();

            $('#produk_by_bundling').show();

            data_produk_bundling();
        });

        $(document).on('click', '.master_bunlding', function() {
            $('#master_bundling').show();
            data_master_bundling();
            $('#produk_by_bundling').hide();
        });

        $(document).ready(function() {
            data_master_bundling();
            $('#master_bunlding').show();
            $('#produk_by_bundling').hide();
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
                        url: "{{ route('produk_bundling.hapus') }}",
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

        $(document).on('click', '.hapus_produk_paket', function() {
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
                        url: "{{ route('produk_paket.hapus_produk_paket') }}",
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
                                data_master_paket().DataTable().ajax.reload();
                            }
                        },
                    })
                }
            });
        });
    </script>
@endpush
