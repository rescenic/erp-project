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
                                <label for="">Sku:</label>
                                <input type="text" name="sku" class="form-control" placeholder="Masukan sku">
                                <span class="text-danger error-text sku_error" style="font-size: 12px;"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Nama:</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukan nama">
                                <span class="text-danger error-text nama_error" style="font-size: 12px;"></span>
                            </div>

                            {{-- <div class="form-group">
                                <label for="">Jenis:</label>
                                <select name="jenis" class="form-control">
                                    <option value="bukan free">Free</option>
                                    <option value="free">Bukan Free</option>
                                </select>
                                <span class="text-danger error-text jenis_error" style="font-size: 12px;"></span>
                            </div> --}}

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
                    url: '{{ route('produk_bundling.simpan') }}',
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
