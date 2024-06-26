@extends('layouts.be')

@section('title', 'Produk Paket')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Produk Paket</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Produk Paket</div>
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


                            <div class="form-group">
                                <label for="">Kode:</label>
                                <input type="text" name="kode" class="form-control" placeholder="Masukan kode">
                            </div>

                            <div class="form-group">
                                <label for="">Nama:</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukan nama">
                            </div>


                            <div class="form-group">
                                <label for="">Sku:</label>
                                <input type="text" name="sku" class="form-control" placeholder="Masukan sku">
                            </div>

                            <div class="form-group">
                                <label for="">Jenis:</label>
                                <input type="text" name="jenis" class="form-control" placeholder="Masukan jenis">
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
            $("#form_simpan").submit(function(e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: '{{ route('produk_paket.simpan') }}',
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
