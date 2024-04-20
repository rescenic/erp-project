@extends('layouts.be')

@section('title', 'Produk Bundling')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Produk Bundling</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Tambah Produk Bundling</div>
                </div>
            </div>

            <div class="section-body">

                <a href="{{ route('produk_bundling') }}" class="btn btn-sm btn-primary my-3">
                    <i class="fas fa-sm fa-arrow-left"></i> Kembali
                </a>

                <div class="card card-primary">

                    <div class="card-body">
                        <form action="#" id="form_simpan" method="POST">
                            @csrf


                            <div class="form-group">
                                <label for="">Bundling</label>
                                <select name="bundling" id="bundling" class="form-control"></select>
                                <span class="text-danger error-text bundling_error" style="font-size: 12px;"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Produk Satuan:</label>
                                <select name="produk_satuan" id="produk_satuan" class="form-control"></select>
                                <span class="text-danger error-text produk_satuan_error" style="font-size: 12px;"></span>
                            </div>


                            <div class="form-group">
                                <label for="">Qty Satuan:</label>
                                <input type="number" name="qty_satuan" class="form-control"
                                    placeholder="Masukan qty satuan">
                                <span class="text-danger error-text qty_satuan_error" style="font-size: 12px;"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Jenis:</label>
                                <select name="jenis" class="form-control">
                                    <option value="bukan free">Bukan Free</option>
                                    <option value="free">Free</option>
                                </select>
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
            $('#bundling').select2({
                multiple: true,
                placeholder: '--Pilih bundling',
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

            $('#produk_satuan').select2({
                multiple: true,
                placeholder: '--Pilih produk_satuan',
                allowClear: true,
                ajax: {
                    url: "{{ route('produk_bundling.list_produk_satuan') }}",
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
                    url: '{{ route('produk_bundling.simpanProdukByByBundling') }}',
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
                                window.top.location = "{{ route('produk_bundling') }}";
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
