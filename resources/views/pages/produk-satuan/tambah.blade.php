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

                    <div class="card-body">
                        <form action="#" id="form_simpan" method="POST">
                            @csrf


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kode:</label>
                                        <input type="text" name="kode" class="form-control"
                                            placeholder="Masukan kode">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama:</label>
                                        <input type="text" name="nama" class="form-control"
                                            placeholder="Masukan nama">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Sku:</label>
                                        <input type="text" name="sku" class="form-control" placeholder="Masukan sku">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">No BPOM:</label>
                                        <input type="text" name="no_bpom" class="form-control"
                                            placeholder="Masukan no bpom">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kategori:</label>
                                        <select name="kategori" id="kategori" class="form-control"></select>
                                    </div>
                                </div>
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

            $('#kategori').select2({
                multiple: true,
                placeholder: '--Pilih kategori',
                allowClear: true,
                ajax: {
                    url: "{{ route('produk_satuan.listKategori') }}",
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
                    url: '{{ route('produk_satuan.simpan') }}',
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
                                window.top.location = "{{ route('produk_satuan') }}";
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
