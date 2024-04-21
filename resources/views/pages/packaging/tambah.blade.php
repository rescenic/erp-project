@extends('layouts.be')

@section('title', 'Packaging')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Packaging</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Tambah Packaging</div>
                </div>
            </div>


            <div class="section-body">

                <a href="{{ route('packaging') }}" class="btn btn-sm btn-primary my-3">
                    <i class="fas fa-sm fa-arrow-left"></i> Kembali
                </a>


                <div class="card card-primary">

                    <div class="card-body">
                        <form action="#" id="form_simpan" method="POST">
                            @csrf


                            <div class="form-group">
                                <label for="">Kode:</label>
                                <input type="text" name="kode" class="form-control" placeholder="Masukan kode">
                                <span class="text-danger error-text kode_error" style="font-size: 12px;"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Nama:</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukan nama">
                                <span class="text-danger error-text nama_error" style="font-size: 12px;"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Kategori Packaging:</label>
                                <select name="kategori_packaging" id="kategori_packaging" class="form-control"></select>
                                <span class="text-danger error-text kategori_packaging_error"
                                    style="font-size: 12px;"></span>
                            </div>


                            <div class="form-group">
                                <label for="">Produk Satuan:</label>
                                <select name="produk_satuan[]" id="produk_satuan" class="form-control"></select>
                            </div>

                            <button class="btn btn-sm btn-primary" type="submit">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {


            $('#kategori_packaging').select2({
                multiple: false,
                placeholder: '--Pilih kategori packaging',
                allowClear: true,
                ajax: {
                    url: "{{ route('packaging.listKategoriPackaging') }}",
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

            $('#produk_satuan').select2({
                multiple: true,
                placeholder: '--Pilih produk satuan',
                allowClear: true,
                ajax: {
                    url: "{{ route('packaging.listProdukSatuan') }}",
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

            $("#form_simpan").submit(function(e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: '{{ route('packaging.simpan') }}',
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: data.status,
                                text: data.message,
                                title: 'Berhasil',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                            });

                            setTimeout(function() {
                                window.top.location = "{{ route('packaging') }}";
                            }, 1500);
                        } else {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        }
                    }
                });
            });

        })
    </script>
@endpush
