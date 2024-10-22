<?php

use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\AuthController;

use Monolog\Level;
// Tugas Register
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'postRegister']);

//Jobsheet 7 
Route::pattern('id', '[0-9]+'); //artinya ketika ada parameter{id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){ //artinya semua route di dalam group ini harus login dulu
    //masukkan semua route yang perlu autentikasi disnii

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});

Route::get('/level',[LevelController::class, 'index']);
Route::get('/kategori',[KategoriController::class, 'index']);
Route::get('/user',[UserController::class, 'index']);
Route::get('/user/tambah',[UserController::class, 'tambah']);
Route::post('/user/tambah_simpan',[UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}',[UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}',[UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}',[UserController::class, 'hapus']);
*/

//Jobsheet 5
Route::get('/', [WelcomeController::class,'index']);
// Route::get('/barang', [UserController::class, 'index']);
// Route::get('/level',[LevelController::class, 'index']);
// Route::get('/kategori',[KategoriController::class, 'index']);

Route::middleware(['authorize:ADM'])->group(function(){
Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   //Menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);         //Menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);      //Menyimpan data user baru ajax 
    Route::get('/{id}', [UserController::class, 'show']);       //menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  //menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);  //Menyimpan perubahan data user
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  //tampilan form confirm ddelete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //untuk hapus data user ajax
    Route::delete('/{id}', [UserController::class, 'destroy']); //mengahapus data user
    Route::get('/import', [UserController::class, 'import']);
    Route::post('/import_ajax', [UserController::class, 'import_ajax']);
    Route::get('/export_excel', [UserController::class, 'export_excel']); // export excel
    Route::get('/export_pdf', [UserController::class, 'export_pdf']);
});
});

Route::middleware(['authorize:ADM'])->group(function(){
    Route::group(['prefix' => 'level'], function(){
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/list', [LevelController::class, 'list']);
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/', [LevelController::class, 'store']);
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']); 
    Route::post('/ajax', [LevelController::class, 'store_ajax']);   
    Route::get('/{id}', [LevelController::class, 'show']);
    Route::get('/{id}/edit', [LevelController::class, 'edit']);
    Route::put('/{id}', [LevelController::class, 'update']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); 
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);  
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);  
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); 
    Route::delete('/{id}', [LevelController::class, 'destroy']);
    Route::get('/import', [LevelController::class, 'import']);
    Route::post('/import_ajax', [LevelController::class, 'import_ajax']);
    Route::get('/export_excel', [LevelController::class, 'export_excel']); // export excel
    Route::get('/export_pdf', [LevelController::class, 'export_pdf']); // export pdf
});
});

Route::middleware(['authorize:ADM,MNG' ])->group(function(){
Route::group(['prefix' => 'barang'], function(){
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']); 
    Route::post('/ajax', [BarangController::class, 'store_ajax']);   
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);  
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);  
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); 
    Route::delete('/{id}', [BarangController::class, 'destroy']);
    Route::get('/import',[BarangController::class,'import']);
    Route::post('/import_ajax',[BarangController::class,'import_ajax']);
    Route::get('/export_excel',[BarangController::class,'export_excel']);
    Route::get('/export_pdf',[BarangController::class,'export_pdf']);

});
});

Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::group(['prefix' => 'kategori'], function(){
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index'); // Menampilkan daftar kategori
        Route::post('/list', [KategoriController::class, 'list'])->name('kategori.list'); // Data kategori untuk datatables
        Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create'); // Menampilkan form tambah kategori
        Route::post('/', [KategoriController::class, 'store'])->name('kategori.store'); // Menyimpan kategori baru
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax'])->name('kategori.create.ajax'); // Form tambah kategori Ajax
        Route::post('/ajax', [KategoriController::class, 'store_ajax'])->name('kategori.store.ajax'); // Simpan kategori baru Ajax
        Route::get('/{id}', [KategoriController::class, 'show'])->name('kategori.show'); // Menampilkan detail kategori
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit'); // Menampilkan form edit kategori
        Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update'); // Menyimpan perubahan kategori
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax'])->name('kategori.edit.ajax'); // Form edit kategori Ajax
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax'])->name('kategori.update.ajax'); // Simpan perubahan kategori Ajax
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax'])->name('kategori.confirm.delete.ajax'); // Konfirmasi hapus kategori Ajax
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax'])->name('kategori.delete.ajax'); // Hapus kategori Ajax
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy'); // Hapus kategori
        Route::get('/import', [KategoriController::class, 'import'])->name('kategori.import'); // Halaman import kategori
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax'])->name('kategori.import.ajax'); // Proses import kategori Ajax
        Route::get('/export_excel', [KategoriController::class, 'export_excel'])->name('kategori.export.excel'); // Export ke Excel
        Route::get('/export_pdf', [KategoriController::class, 'export_pdf'])->name('kategori.export.pdf'); // Export ke PDF
    });
});
});

Route::middleware(['authorize:ADM,MNG' ])->group(function(){
Route::group(['prefix' => 'supplier'], function(){
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); 
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);   
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);  
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);  
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); 
    Route::delete('/{id}', [SupplierController::class, 'destroy']);
    Route::get('/import', [SupplierController::class, 'import']);
    Route::post('/import_ajax', [SupplierController::class, 'import_ajax']);
    Route::get('/export_excel', [SupplierController::class, 'export_excel']); 
    Route::get('/export_pdf', [SupplierController::class, 'export_pdf']); 
});

Route::group(['prefix' => 'stok', 'middleware' => 'authorize:ADM,MNG,STF'], function () {
    Route::get('/', [StokController::class, 'index']);          //menampilkan halaman awal Stok
    Route::post('/list', [StokController::class, 'list']);      //menampilkan data Stok dalam bentuk json untuk datatables
    Route::get('/create', [StokController::class, 'create']);   //menammpilkan halaman form tambah Stok
    Route::post('/', [StokController::class, 'store']);         //menyimpan data Stok baru
    Route::get('/create_ajax', [StokController::class, 'create_ajax']);  //menampilkan halaman form tambah Stok Ajax
    Route::post('/ajax', [StokController::class, 'store_ajax']);         //menyimpan data Stok baru Ajax
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);  //menampilkan halaman form edit Stok Ajax
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);  //Menyimpan halaman form edit Stok Ajax
    Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);  //tampilan form confirm delete Stok Ajax
    Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); //menghapus data Stok Ajax
    Route::get('/export_pdf', [StokController::class, 'export_pdf']);  //export pdf
    Route::get('/{id}', [StokController::class, 'show']);       //menampilkan detail Stok
    Route::get('/{id}/edit', [StokController::class, 'edit']);  //menampilkan halaman form detail Stok
    Route::put('/{id}', [StokController::class, 'update']);     //menyimpan perubahan data Stok
    Route::delete('/{id}', [StokController::class, 'destroy']); //menghapus data Stok
});

Route::group(['prefix' => 'penjualan', 'middleware' => 'authorize:ADM,MNG,STF'], function () {
    Route::get('/', [PenjualanController::class, 'index']);          //menampilkan halaman awal Penjualan
    Route::post('/list', [PenjualanController::class, 'list']);      //menampilkan data Penjualan dalam bentuk json untuk datatables
    Route::get('/create', [PenjualanController::class, 'create']);   //menammpilkan halaman form tambah Penjualan
    Route::post('/', [PenjualanController::class, 'store']);         //menyimpan data Penjualan baru
    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);  //menampilkan halaman form tambah Penjualan Ajax
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']);         //menyimpan data Penjualan baru Ajax
    Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);  //menampilkan halaman form edit Penjualan Ajax
    Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);  //Menyimpan halaman form edit Penjualan Ajax
    Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);  //tampilan form confirm delete Penjualan Ajax
    Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); //menghapus data Penjualan Ajax
    Route::get('/export_pdf', [PenjualanController::class, 'export_pdf']);  //export pdf
    Route::get('/{id}', [PenjualanController::class, 'show']);       //menampilkan detail Penjualan
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']);  //menampilkan halaman form detail Penjualan
    Route::put('/{id}', [PenjualanController::class, 'update']);     //menyimpan perubahan data Penjualan
    Route::delete('/{id}', [PenjualanController::class, 'destroy']); //menghapus data Penjualan

});

    Route::get('/profil', [ProfilController::class, 'index']);
    Route::post('/profil/update', [ProfilController::class, 'update']);

});
