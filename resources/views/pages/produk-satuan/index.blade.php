@extends('layouts.be')

@section('title', 'Produk Satuan')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Produk Satuan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Produk Satuan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4></h4>
                        <div class="card-header-action">
                            <a href="{{ route('produk_satuan.tambah') }}" class="btn btn-primary">
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
                                        <th>No Bpom</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                destroy: true,
                processing: true,
                searching: false,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 25, -1],
                    [10, 20, 25, "50"]
                ],

                order: [],
                ajax: {
                    url: "{{ route('produk_satuan.data') }}",
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
                        data: 'no_bpom',
                        name: 'no_bpom'
                    },
                    {
                        data: 'kategori_produk',
                        name: 'kategori_produk'
                    },

                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            });
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
