@extends('layouts.be')

@section('title', 'Produk Paket')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Produk Paket</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Edit Produk Paket</div>
                </div>
            </div>

            <div class="section-body">

                <a href="{{ route('produk_paket') }}" class="btn btn-sm btn-primary my-3">
                    <i class="fas fa-sm fa-arrow-left"></i> Kembali
                </a>

                <div class="card card-primary">

                    <div class="card-body">
                        <form action="#" id="form_simpan" method="POST">
                            @csrf

                            <input type="hidden" name="id" class="form-control" value="{{ $produk_paket->id }}"
                                id="produk_paket_id">


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
                                <input type="number" name="qty_satuan" class="form-control"
                                    placeholder="Masukan qty produk satuan" value="{{ $produk_paket->qty_satuan }}">
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

            var produk_satuan = $('#produk_paket_id').val();
            $.ajax({
                type: 'GET',
                url: "{{ route('produk-paket.paketByProdukPaket') }}",
                data: {
                    produk_satuan: produk_satuan,
                    _token: '{{ csrf_token() }}'
                }
            }).then(function(data) {
                for (i = 0; i < data.length; i++) {

                    var newOption = new Option(data[i].sku, data[i].id, true,
                        true);

                    $('#paket').append(newOption).trigger('change');
                }
            });

            $.ajax({
                type: 'GET',
                url: "{{ route('produk-paket.produkByPaket') }}",
                data: {
                    produk_satuan: produk_satuan,
                    _token: '{{ csrf_token() }}'
                }
            }).then(function(data) {
                for (i = 0; i < data.length; i++) {

                    var newOption = new Option(data[i].sku, data[i].id, true,
                        true);

                    $('#produk_satuan').append(newOption).trigger('change');
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
                    url: '{{ route('produk_paket.update_paket_produk') }}',
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
