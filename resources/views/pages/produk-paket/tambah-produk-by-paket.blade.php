@extends('layouts.be')

@section('title', 'Produk By Paket')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Produk By Paket</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Produk By Paket</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card card-primary">

                    <div class="card-body">
                        <form action="#" id="form_simpan" method="POST">
                            @csrf


                            <div class="form-group">
                                <label for="">Produk Paket:</label>
                                <select name="produk_paket" id="paket" class="form-control"></select>
                            </div>

                            <div class="form-group">
                                <label for="">Produk Satuan:</label>
                                <select name="produk_satuan" id="produk_satuan" class="form-control"></select>
                            </div>


                            <div class="form-group">
                                <label for="">Qty Produk Satuan:</label>
                                <input type="number" name="qty_satuan" class="form-control" placeholder="Masukan qty produk satuan">
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
            $('#paket').select2({
                placeholder: '--Pilih paket',
                allowClear: true,
                ajax: {
                    url: "{{ route('produk-paket.listPaket') }}",
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
                placeholder: '--Pilih produk satuan',
                allowClear: true,
                ajax: {
                    url: "{{ route('produk-paket.listProdukSatuan') }}",
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
                    url: '{{ route('produk_paket.simpan_produk_by_paket') }}',
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
                                window.top.location = "{{ route('produk_paket') }}";
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
