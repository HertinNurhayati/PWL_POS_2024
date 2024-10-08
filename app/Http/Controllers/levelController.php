<?php

namespace App\Http\Controllers;

use App\Models\levelmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class levelController extends Controller{
    
    //Menampilkan halaman awal level
    public function index() 
    {
        $breadcrumb = (object)[
            'title' => 'Daftar level',
            'list' => ['Home', 'level']
        ];
        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level';
        $level = levelmodel::all();
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $level = levelmodel::select('level_id', 'level_kode', 'level_nama',);

        if ($request->level_id){
            $level->where('level_id',$request->level_id);
        }
        return DataTables::of($level)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                // $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btnsm">Detail</a> ';
                // $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn  = '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //Menampilkan halaman form tambah level
    public function create()
    {
        $breadcrummb = (object)[
            'title' => 'Tambah level',
            'list' => ['Home', 'level', 'tambah']
        ];

        $page = (object)[
            'title' => 'Tambah level baru'
        ];
        $activeMenu = 'level';
        $level = levelmodel::all();
        return view('level.create', ['breadcrumb' => $breadcrummb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
    }

    //Menyimpan data level baru
    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ]);
        levelmodel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    //Menampilkan detail level
    public function show(string $level_id)
    {
        $level = levelmodel::find($level_id);

        $breadcrumb = (object)[
            'title' => 'Detail Level',
            'list' => ['Home', 'level', 'detail']
        ];
        $page = (object)[
            'title' => 'Detail Level'
        ];
        $activeMenu = 'level';
        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit level
    public function edit(string $level_id)
    {
        $level = levelmodel::find($level_id);

        $breadcrumb = (object)[
            'title' => 'Edit Level',
            'list' => ['Home', 'level', 'edit']
        ];
        $page = (object)[
            'title' => 'Edit level'
        ];
        $activeMenu = 'level';
        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
    }

    //Menyimpan perubahan data level
    public function update(Request $request, string $level_id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:5|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ]);

        $level = levelmodel::find($level_id);
        $level->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);
        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    //Menghapus data level
    public function destroy(string $level_id)
    {
        $check = levelmodel::find($level_id);
        if (!$check) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }
        try {
            levelmodel::destroy($level_id);
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dhapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax() 
    {
        return view('level.create_ajax');
    }

    // Menyimpan data level baru melalui Ajax
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_nama' => 'required|string|min:3|unique:m_level,level_nama',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            LevelModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    // Menampilkan halaman form edit level Ajax
    public function edit_ajax(string $id) 
    {
        $level = LevelModel::find($id);

        return view('level.edit_ajax', ['level' => $level]);
    }

    // Menyimpan perubahan data level melalui Ajax
    public function update_ajax(Request $request, $id) 
    {
        // cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_nama' => 'required|string|max:100|unique:m_level,level_nama,'.$id.',level_id',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $check = LevelModel::find($id);
            if($check) {
                $check->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil diupdate'
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

    // Konfirmasi penghapusan level Ajax
    public function confirm_ajax(string $id) 
    {
        $level = LevelModel::find($id);

        return view('level.confirm_ajax', ['level' => $level]);
    }

    // Menghapus data level melalui Ajax
    public function delete_ajax(Request $request, $id) 
    {
        // cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);

            if($level) {
                $level->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil dihapus'
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

}
   