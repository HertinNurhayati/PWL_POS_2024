<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class suppliercontroller extends Controller
{
    // Menampilkan halaman awal supplier
    public function index(){
        $breadcrumb = (object)[
            'title'=>'Daftar supplier',
            'list'=>['Home','supplier']
        ];

        $page =(object)[
            'title'=>'Daftar supplier yang terdaftar dalam sistem'
        ];

        $activeMenu ='supplier';

        $supplier = suppliermodel::all();

        return view('supplier.index',['breadcrumb'=>$breadcrumb,'page'=>$page,'supplier'=>$supplier, 'activeMenu' =>$activeMenu]);
    }

    // Ambil data supplier dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $supplier = suppliermodel::select('supplier_id','supplier_kode','supplier_nama','supplier_alamat');
        
        // if($request->supplier_id){
        //     $supplier->where('supplier_id',$request->supplier_id);
        // }

        return DataTables::of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                // $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btnsm">Detail</a> ';
                // $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) 
            ->make(true);
    }

    //Menampilkan halaman form tambah supllier
    public function create(){
        $breadcrumb = (object)[
            'title'=>'Tambah supplier',
            'list'=>['Home','supplier','tambah']
        ];
        
        $page = (object)[
            'title'=>'Tambah supplier baru'
        ];

        $activeMenu = 'supplier';
        $supplier = suppliermodel::all();

        return view('supplier.create',['breadcrumb'=>$breadcrumb,'page'=>$page,'activeMenu'=>$activeMenu,'supplier'=>$supplier]);
    }

    //Menyimpan data supplier baru
    public function store(Request $request){
        $request->validate([
            'supplier_kode'=>'required|string|min:3|max:5|unique:m_supplier,supplier_kode',
            'supplier_nama'=>'required|string|max:100',
            'supplier_alamat'=>'required|string|max:100'
        ]);

        suppliermodel::create([
            'supplier_kode'=>$request->supplier_kode,
            'supplier_nama'=>$request->supplier_nama,
            'supplier_alamat'=>$request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success','Data kategori berhasil disimpan');
    }

    //Menampilkan detail supplier
    public function show(string $supplier_id){
        $supplier = suppliermodel::find($supplier_id);

        $breadcrumb = (object)[
            'title'=>'Detail supplier',
            'list'=>['Home','supplier','detail']
        ];

        $page = (object)[
            'title'=>'Detail supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.show',['breadcrumb'=>$breadcrumb,'page'=>$page,'activeMenu'=>$activeMenu,'supplier'=>$supplier]);
    }

    // Menampilkan halaman form edit supplier
    public function edit(string $supplier_id){
        $supplier = suppliermodel::find($supplier_id);

        $breadcrumb = (object)[
            'title'=>'Edit supplier',
            'list'=>['Home','supplier','edit']
        ];

        $page = (object)[
            'title' => 'Edit supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit',['breadcrumb'=>$breadcrumb,'page'=>$page,'supplier'=>$supplier,'activeMenu'=>$activeMenu]);
    }

    //Menyimpan perubahan data supplier
    public function update(Request $request, string $supplier_id){
        $request->validate([
            'supplier_kode'=>'required|string|min:3|max:5|unique:m_supplier,supplier_kode',
            'supplier_nama'=>'required|string|max:100',
            'supplier_alamat'=>'required|string|max:100'
        ]);

        $supplier = suppliermodel::find($supplier_id);
        $supplier->update([
            'supplier_kode'=>$request->supplier_kode,
            'supplier_nama'=>$request->supplier_nama,
            'supplier_alamat'=>$request->supplier_alamat
        ]);
        
        return redirect('/supplier')->with('success','Data supplier berhasil diperbarui');
    }

    // Menghapus data user
    public function destroy(string $supplier_id){
        $check = suppliermodel::find($supplier_id);
        if (!$check) {
            return redirect('/supplier')->with('error', 'Data level tidak ditemukan');
        }
        
        try {
            suppliermodel::destroy($supplier_id);
           
            return redirect('/supplier')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data level gagal dhapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax() {
        return view('supplier.create_ajax');
    }

    // Storing new Supplier via AJAX
    public function store_ajax(Request $request) {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_nama' => 'required|string|min:3|unique:m_supplier,supplier_nama',
                'supplier_kode' => 'required|string|min:2|unique:m_supplier,supplier_kode',
                'supplier_alamat' => 'nullable|string|max:255'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            SupplierModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    // Displaying edit form for Supplier via AJAX
    public function edit_ajax(string $id) {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    // Updating Supplier via AJAX
    public function update_ajax(Request $request, $id)
     {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_nama' => 'required|string|max:100|unique:m_supplier,supplier_nama,'.$id.',supplier_id',
                'supplier_kode' => 'required|string|max:10|unique:m_supplier,supplier_kode,'.$id.',supplier_id',
                'supplier_alamat' => 'nullable|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $supplier = SupplierModel::find($id);
            if($supplier) {
                $supplier->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    // Confirming Supplier deletion via AJAX
    public function confirm_ajax(string $id) 
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    // Deleting Supplier via AJAX
    public function delete_ajax(Request $request, $id) 
    {
        if($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);

            if($supplier) {
                $supplier->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function import()
    {
        return view('supplier.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_supplier'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'supplier_kode' => $value['A'],
                            'supplier_nama' => $value['B'],
                            'supplier_alamat' => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    SupplierModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        // ambil data supplier yang akan di export
        $supplier = SupplierModel::select('supplier_kode', 'supplier_nama', 'supplier_alamat')
            ->orderBy('supplier_kode')
            ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode supplier');
        $sheet->setCellValue('C1', 'Nama supplier');
        $sheet->setCellValue('D1', 'Alamat supplier');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true); // bold header

        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($supplier as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->supplier_kode);
            $sheet->setCellValue('C' . $baris, $value->supplier_nama);
            $sheet->setCellValue('D' . $baris, $value->supplier_alamat);
            $baris++;
            $no++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        $sheet->setTitle('Data supplier'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data supplier ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    } // end function export_excel

    public function export_pdf()
    {
        $supplier = SupplierModel::select('supplier_kode', 'supplier_nama','supplier_alamat')
            ->orderBy('supplier_kode')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('supplier.export_pdf', ['supplier' => $supplier]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data supplier' . date('Y-m-d H:i:s') . '.pdf');
    }
}