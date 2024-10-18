<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokController;


use Monolog\Level;

// //JOBSHEET 2 : MEMBUAT ROUTE

// //Controller Class Home
// Route::get('/', [HomeController::class, 'home'])->name('home');

// //Controller Class Category Daftar Produk
// Route::prefix('category')->group(function () {
//     Route::get('baby-kid', [ProductController::class, 'babyKid'])->name('category.baby-kid');
//     Route::get('beauty-health', [ProductController::class, 'beautyHealth'])->name('category.beauty-health');
//     Route::get('food-beverage', [ProductController::class, 'foodBeverage'])->name('category.food-beverage');
//     Route::get('home-care', [ProductC ontroller::class, 'homeCare'])->name('category.home-care');
// });

// //Controller Class User/Profil
// // Route::get('user/{id}/name/{name}', [UserController::class, 'profile'])->name('user.profile');

// //Controller Class Saless/Penjualan
// Route::get('sales', [SalesController::class, 'index'])->name('sales.index');

// //================================================================================

//Jobsheet 3 : Implementasi DB FACADE
Route::get('/level', [LevelController::class, 'index']);

//Query Builder
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WelcomeController;
use Monolog\Handler\RotatingFileHandler;

Route::get('/kategori', [KategoriController::class, 'index']);


//Eloquent ORM
Route::get('/user', [UserController::class, 'index']);

//Jobsheet 4 : ORM CRUD
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

//Jobsheet 5
// Route::get('/', [WelcomeController::class, 'index']);

// Route::group(['prefix' => 'user'], function(){
//     Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
//     Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [UserController::class, 'create']);   //Menampilkan halaman form tambah user
//     Route::post('/', [UserController::class, 'store']);         //Menyimpan data user baru
//     Route::get('/create_ajax', [UserController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
//     Route::post('/ajax', [UserController::class, 'store_ajax']);      //Menyimpan data user baru ajax   
//     Route::get('/{id}', [UserController::class, 'show']);       //menampilkan detail user
//     Route::get('/{id}/edit', [UserController::class, 'edit']);  //menampilkan halaman form edit user
//     Route::put('/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);  //Menyimpan perubahan data user
//     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  //tampilan form confirm ddelete user Ajax
//     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //untuk hapus data user ajax
//     Route::delete('/{id}', [UserController::class, 'destroy']); //mengahapus data user
// });

// Route::group(['prefix' => 'level'], function(){
//     Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal user
//     Route::post('/list', [LevelController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [LevelController::class, 'create']);   //Menampilkan halaman form tambah user
//     Route::post('/', [LevelController::class, 'store']);         //Menyimpan data user baru
//     Route::get('/create_ajax', [LevelController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
//     Route::post('/ajax', [LevelController::class, 'store_ajax']);      //Menyimpan data user baru ajax   
//     Route::get('/{id}', [LevelController::class, 'show']);       //menampilkan detail user
//     Route::get('/{id}/edit', [LevelController::class, 'edit']);  //menampilkan halaman form edit user
//     Route::put('/{id}', [LevelController::class, 'update']);     //menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);  //Menyimpan perubahan data user
//     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);  //tampilan form confirm ddelete user Ajax
//     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); //untuk hapus data user ajax
//     Route::delete('/{id}', [LevelController::class, 'destroy']); //mengahapus data user
// });

// Route::group(['prefix' => 'kategori'], function(){
//     Route::get('/', [KategoriController::class, 'index']);          //menampilkan halaman awal user
//     Route::post('/list', [KategoriController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [KategoriController::class, 'create']);   //Menampilkan halaman form tambah user
//     Route::post('/', [KategoriController::class, 'store']);         //Menyimpan data user baru
//     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
//     Route::post('/ajax', [KategoriController::class, 'store_ajax']);      //Menyimpan data user baru ajax  
//     Route::get('/{id}', [KategoriController::class, 'show']);       //menampilkan detail user
//     Route::get('/{id}/edit', [KategoriController::class, 'edit']);  //menampilkan halaman form edit user
//     Route::put('/{id}', [KategoriController::class, 'update']);     //menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);  //Menyimpan perubahan data user
//     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);  //tampilan form confirm ddelete user Ajax
//     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); //untuk hapus data user ajax
//     Route::delete('/{id}', [KategoriController::class, 'destroy']); //mengahapus data user
// });

// Route::group(['prefix' => 'supplier'], function(){
//     Route::get('/', [SupplierController::class, 'index']);          //menampilkan halaman awal user
//     Route::post('/list', [SupplierController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [SupplierController::class, 'create']);   //Menampilkan halaman form tambah user
//     Route::post('/', [SupplierController::class, 'store']);         //Menyimpan data user baru
//     Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
//     Route::post('/ajax', [SupplierController::class, 'store_ajax']);      //Menyimpan data user baru ajax  
//     Route::get('/{id}', [SupplierController::class, 'show']);       //menampilkan detail user
//     Route::get('/{id}/edit', [SupplierController::class, 'edit']);  //menampilkan halaman form edit user
//     Route::put('/{id}', [SupplierController::class, 'update']);     //menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);  //Menyimpan perubahan data user
//     Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);  //tampilan form confirm ddelete user Ajax
//     Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); //untuk hapus data user ajax
//     Route::delete('/{id}', [SupplierController::class, 'destroy']); //mengahapus data user
// });

// Route::group(['prefix' => 'barang'], function(){
//     Route::get('/', [BarangController::class, 'index']);          //menampilkan halaman awal user
//     Route::post('/list', [BarangController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [BarangController::class, 'create']);   //Menampilkan halaman form tambah user
//     Route::post('/', [BarangController::class, 'store']);         //Menyimpan data user baru
//     Route::get('/create_ajax', [BarangController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
//     Route::post('/ajax', [BarangController::class, 'store_ajax']);      //Menyimpan data user baru ajax  
//     Route::get('/{id}', [BarangController::class, 'show']);       //menampilkan detail user
//     Route::get('/{id}/edit', [BarangController::class, 'edit']);  //menampilkan halaman form edit user
//     Route::put('/{id}', [BarangController::class, 'update']);     //menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);  //Menyimpan perubahan data user
//     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);  //tampilan form confirm ddelete user Ajax
//     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); //untuk hapus data user ajax
//     Route::delete('/{id}', [BarangController::class, 'destroy']); //mengahapus data user
// });


//Jobsheet 7

Route::pattern('id', '[0-9]+'); //artinya ketika ada parameter{id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::middleware(['auth'])->group(function(){
    Route::get('/', [WelcomeController::class, 'index']);

    Route::group(['prefix'=> 'user','middleware'=> 'authorize:ADM,MNG'], function(){
        Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create']);   //menammpilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']);         //menyimpan data user baru
    
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);  //menampilkan halaman form tambah user Ajax
        Route::post('/ajax', [UserController::class, 'store_ajax']);         //menyimpan data user baru Ajax
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  //menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);  //Menyimpan halaman form edit user Ajax
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  //tampilan form confirm delete user Ajax
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //menghapus data user Ajax
        
        Route::get('/{id}', [UserController::class, 'show']);       //menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']);  //menampilkan halaman form detail user
        Route::put('/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
        Route::delete('/{id}', [UserController::class, 'destroy']); //menghapus data user
    });

    Route::middleware(['authorize:ADM'])->group(function(){
        Route::group(['prefix'=> 'level'], function(){
            Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal Level
            Route::post('/list', [LevelController::class, 'list']);      //menampilkan data Level dalam bentuk json untuk datatables
            Route::get('/create', [LevelController::class, 'create']);   //menammpilkan halaman form tambah Level
            Route::post('/', [LevelController::class, 'store']);         //menyimpan data Level baru
        
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']);  //menampilkan halaman form tambah Level Ajax
            Route::post('/ajax', [LevelController::class, 'store_ajax']);         //menyimpan data Level baru Ajax
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);  //menampilkan halaman form edit Level Ajax
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);  //Menyimpan halaman form edit Level Ajax
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);  //tampilan form confirm delete Level Ajax
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); //menghapus data Level Ajax
            
            Route::get('/{id}', [LevelController::class, 'show']);       //menampilkan detail Level
            Route::get('/{id}/edit', [LevelController::class, 'edit']);  //menampilkan halaman form detail Level
            Route::put('/{id}', [LevelController::class, 'update']);     //menyimpan perubahan data Level
            Route::delete('/{id}', [LevelController::class, 'destroy']); //menghapus data level
            
        });
    });

        Route::group(['prefix'=> 'kategori','middleware'=> 'authorize:ADM,MNG'], function(){
        Route::get('/', [KategoriController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/list', [KategoriController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [KategoriController::class, 'create']);   //Menampilkan halaman form tambah user
        Route::post('/', [KategoriController::class, 'store']);         //Menyimpan data user baru
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
        Route::post('/ajax', [KategoriController::class, 'store_ajax']);      //Menyimpan data user baru ajax  
        Route::get('/{id}', [KategoriController::class, 'show']);       //menampilkan detail user
        Route::get('/{id}/edit', [KategoriController::class, 'edit']);  //menampilkan halaman form edit user
        Route::put('/{id}', [KategoriController::class, 'update']);     //menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);  //Menyimpan perubahan data user
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);  //tampilan form confirm ddelete user Ajax
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); //untuk hapus data user ajax
        Route::delete('/{id}', [KategoriController::class, 'destroy']); //mengahapus data user
    });

    Route::group(['prefix'=> 'supplier', 'middleware'=> 'authorize:ADM,MNG'], function(){
        Route::get('/', [SupplierController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/list', [SupplierController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [SupplierController::class, 'create']);   //Menampilkan halaman form tambah user
        Route::post('/', [SupplierController::class, 'store']);         //Menyimpan data user baru
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
        Route::post('/ajax', [SupplierController::class, 'store_ajax']);      //Menyimpan data user baru ajax  
        Route::get('/{id}', [SupplierController::class, 'show']);       //menampilkan detail user
        Route::get('/{id}/edit', [SupplierController::class, 'edit']);  //menampilkan halaman form edit user
        Route::put('/{id}', [SupplierController::class, 'update']);     //menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);  //Menyimpan perubahan data user
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);  //tampilan form confirm ddelete user Ajax
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); //untuk hapus data user ajax
        Route::delete('/{id}', [SupplierController::class, 'destroy']); //mengahapus data user
    });

    Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::group(['prefix' => 'barang'], function(){
        Route::get('/', [BarangController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/list', [BarangController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [BarangController::class, 'create']);   //Menampilkan halaman form tambah user
        Route::post('/', [BarangController::class, 'store']);         //Menyimpan data user baru
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
        Route::post('/ajax', [BarangController::class, 'store_ajax']);      //Menyimpan data user baru ajax  
        Route::get('/{id}', [BarangController::class, 'show']);       //menampilkan detail user
        Route::get('/{id}/edit', [BarangController::class, 'edit']);  //menampilkan halaman form edit user
        Route::put('/{id}', [BarangController::class, 'update']);     //menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);  //Menyimpan perubahan data user
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // menampilkan form confirm delete supplier ajax
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // menghapus data supplier ajax
        Route::delete('/{id}', [BarangController::class, 'destroy']);// Menghapus data Barang
        Route::get('/import', [BarangController::class, 'import']);  //ajax form upload excel
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']);  //ajax import excel
        Route::get('/export_excel', [BarangController::class, 'export_excel']);  //export excel
        Route::get('/export_pdf', [BarangController::class, 'export_pdf']);  //export pdf

    });

    Route::group(['prefix'=> 'stok','middleware'=> 'authorize:ADM,MNG,STF'], function(){
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
        Route::get('/{id}', [StokController::class, 'show']);       //menampilkan detail Stok
        Route::get('/{id}/edit', [StokController::class, 'edit']);  //menampilkan halaman form detail Stok
        Route::put('/{id}', [StokController::class, 'update']);     //menyimpan perubahan data Stok
        Route::delete('/{id}', [StokController::class, 'destroy']); //menghapus data Stok

    });
    Route::group(['prefix'=> 'penjualan','middleware'=> 'authorize:ADM,MNG,STF'], function(){
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


        Route::get('/{id}', [PenjualanController::class, 'show']);       //menampilkan detail Penjualan
        Route::get('/{id}/edit', [PenjualanController::class, 'edit']);  //menampilkan halaman form detail Penjualan
        Route::put('/{id}', [PenjualanController::class, 'update']);     //menyimpan perubahan data Penjualan
        Route::delete('/{id}', [PenjualanController::class, 'destroy']); //menghapus data Penjualan

});
});
});
