@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('penjualan/import') }}')" class="btn btn-info">Import penjualan</button>
                <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>Export penjualan</a>
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i>Export Penjualan</a>
                <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table-penjualan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pembeli</th>
                        <th>Kode Penjualan</th>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
function modalAction(url = '') {
    $('#myModal').load(url, function(){
        $('#myModal').modal('show');

        // Saat modal ditutup, reload data secara otomatis
        $('#myModal').on('hidden.bs.modal', function () {
            tablePenjualan.ajax.reload(null, false);  // Reload tabel setelah modal ditutup
        });
    });
}

var tablePenjualan;
$(document).ready(function(){
    tablePenjualan = $('#table-penjualan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ url('penjualan/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function (d) {
                d.user_id = $('#user_id').val(); // Pastikan ini menggunakan ID filter yang benar
                d._token = "{{ csrf_token() }}"; // Sertakan CSRF token
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "pembeli",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "penjualan_kode",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "penjualan_tanggal",
                className: "",
                orderable: true,
                searchable: false
            },
            {
                data: "user.nama",
                className: "",
                orderable: false,
                searchable: false
            },
            {
                data: "aksi",
                className: "",
                orderable: false,
                searchable: false
            }
        ]
    });

    // Filter data berdasarkan user
    $('#user_id').on('change', function(){
        tablePenjualan.ajax.reload(); // Menggunakan objek tablePenjualan yang tepat
    });
});
</script>
@endpush
