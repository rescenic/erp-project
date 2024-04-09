@extends('layouts.be')

@section('title', 'Permission')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Permission</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Permission</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card card-primary">

                    <div class="card-body">
                        <form action="#" id="form_update" method="POST">
                            @csrf

                            <input type="hidden" name="id" class="form-control" value="{{ $permission->id }}">


                            <div class="form-group">
                                <label for="">Permission:</label>
                                <input type="text" name="permission" class="form-control"
                                    placeholder="Masukan permission" value="{{ $permission->name }}">
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
            $("#form_update").submit(function(e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: '{{ route('permission.update') }}',
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
                                window.top.location = "{{ route('permission') }}";
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
