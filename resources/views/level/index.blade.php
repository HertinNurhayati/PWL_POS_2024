@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/level/import') }}')" class="btn btn-info">Import level</button>
                <a href="{{ url('/level/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export level</a>
                <a href="{{ url('/level/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export level</a>
                <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <table class="table table-bordered table-striped table-hover table-sm" id="table-level">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Level</th>
                        <th>Nama Level</th>
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
        function modalAction(url = ''){ 
            $('#myModal').load(url,function(){ 
                $('#myModal').modal('show'); 

                // Setelah modal muncul, tangani form import
                $('#form-import').on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataLevel.ajax.reload(); // Reload DataTable
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal mengunggah file. Silakan coba lagi.'
                            });
                        }
                    });
                });
            }); 
        }

        var dataLevel;
        $(document).ready(function() { 
            dataLevel = $('#table-level').DataTable({
                serverSide: true,      
                ajax: { 
                    "url": "{{ url('level/list') }}", 
                    "type": "POST", 
                    "dataType": "json"
                }, 
                columns: [ 
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "level_kode", className: "", orderable: true, searchable: true },
                    { data: "level_nama", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "", orderable: false, searchable: false }
                ] 
            }); 
        }); 
    </script> 
@endpush
