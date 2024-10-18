@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
            <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-info">Import Barang</button>
            <a href="{{ url('/barang/export_excel') }}" class="btn btn-primary"><i class="fa fa-file
            excel"></i> Export Barang</a>
            <a href="{{ url('/barang/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i>Export Barang</a>
            <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>                                
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>                                
            @endif

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-4 control-label col-form-label">Filter:</label>
                        <div class="col-8">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -</option>
                                @foreach($level as $l)
                                    <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-hover table-sm" id="table_user">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 5%;" class="text-center">No</th>
                        <th style="width: 10%;" class="text-center">ID</th>
                        <th style="width: 20%;">Username</th>
                        <th style="width: 30%;">Nama</th>
                        <th style="width: 15%;">Level Pengguna</th>
                        <th style="width: 20%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('css')
<style>
    /* Style khusus untuk tombol agar lebih rapi */
    .btn-group .btn {
        margin-right: 5px;
    }
    .table-sm th, .table-sm td {
        padding: 0.5rem;
    }
    .thead-light th {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataUser;
    $(document).ready(function() {
        dataUser = $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('user/list') }}",
                type: "POST",
                data: function (d) {
                    d.level_id = $('#level_id').val();
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false, width: "5%" },
                { data: "user_id", className: "text-center", orderable: true, searchable: true, width: "10%" },
                { data: "username", orderable: true, searchable: true, width: "20%" },
                { data: "nama", orderable: true, searchable: true, width: "30%" },
                { data: "level.level_nama", orderable: true, searchable: false, width: "15%" },
                {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    width: "20%",
                    render: function (data, type, row) {
                        return `
                            <div class="btn-group" role="group">
                                <a href="/user/${row.user_id}" class="btn btn-info btn-sm">Detail</a>
                                <button onclick="modalAction('/user/${row.user_id}/edit_ajax')" class="btn btn-warning btn-sm">Edit</button>
                                <button onclick="modalAction('/user/${row.user_id}/delete_ajax')" class="btn btn-danger btn-sm">Hapus</button>
                            </div>
                        `;
                    }
                }
            ]
        });

        // Apply filter saat dropdown level berubah
        $('#level_id').change(function() {
            dataUser.draw();
        });
    });
</script>
@endpush
