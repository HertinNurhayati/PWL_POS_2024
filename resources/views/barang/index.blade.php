@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Barang</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-info">Import Barang</button>
            <a href="{{ url('/barang/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>Export Barang</a>
            <a href="{{ url('/barang/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i>Export Barang</a>
            <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>

    <div class="card-body">
        <!-- untuk Filter data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="filter_kategori" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                <option value="">- Semua -</option>
                                @foreach($kategori as $item)
                                    <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-sm table-striped table-hover" id="table-barang">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
function modalAction(url = '') {
    $('#myModal').load(url, function(){
        $('#myModal').modal('show');
        
        // Saat modal ditutup, reload data secara otomatis
        $('#myModal').on('hidden.bs.modal', function () {
            tableBarang.ajax.reload();  // Reload tabel setelah modal ditutup
        });
    });
}

// Inisialisasi DataTable
var tableBarang;
$(document).ready(function(){
    tableBarang = $('#table-barang').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ url('barang/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function (d) {
                d.filter_kategori = $('.filter_kategori').val();
            }
        },
        columns: [
            {
                data: "DT_RowIndex", // Change this if 'No_Urut' does not exist
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "barang_kode",
                orderable: true,
                searchable: true
            },
            {
                data: "barang_nama",
                orderable: true,
                searchable: true
            },
            {
                data: "harga_beli",
                orderable: true,
                searchable: false,
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
                data: "harga_jual",
                orderable: true,
                searchable: false,
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
                data: "kategori.kategori_nama",
                orderable: true,
                searchable: false
            },
            {
                data: "aksi",
                className: "text-center",
                orderable: false,
                searchable: false
            }
        ]
    });

    // Filter kategori untuk reload data sesuai pilihan filter
    $('.filter_kategori').change(function() {
        tableBarang.draw();
    });
});

// AJAX form submit untuk operasi tambah/edit
$('#form-barang').submit(function(e) {
    e.preventDefault();
    let form = $(this);
    let actionUrl = form.attr('action');

    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response.status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                }).then(function() {
                    $('#myModal').modal('hide'); // Tutup modal
                    tableBarang.ajax.reload(); // Reload data di tabel
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: response.message,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat memproses data.',
            });
        }
    });
});
</script>
@endpush
