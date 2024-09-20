<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        /*$data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 2',
            'password' => Hash::make('12345')
        ];
        
        UserModel::create($data);
        */

        // Ambil user pertama dengan level_id = 1
        /*$user = UserModel::firstWhere('level_id', 1);*/

        /*    $user = UserModel::findOr (20, ['username', 'nama'], function (){
            abort (404);
        });*/

        /*$user = UserModel::findOrFail(1);*/

        /*$user = UserModel::where('username', 'manager9')->firstOrFail();*/

         // Hitung jumlah pengguna dengan level_id = 2
        /*$userCount = UserModel::where('level_id', 2)->count();
        // Kirim jumlah pengguna ke view
        return view('user', ['userCount' => $userCount]);*/

        /*$user = UserModel::firstOrCreate(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );
        return view('user', ['data' => $user]);*/



        $user = UserModel::create([
        'username' => 'manager11',
        'nama' => 'Manager11',
        'password' => Hash::make('12345'),
        'level_id' => 2,
        ]);

        $user->username = 'manager12';

        /*$user->isDirty(); // true
        $user->isDirty('username'); // true
        $user->isDirty('nama'); // false
        $user->isDirty (['nama', 'username']); // true

        $user->isClean(); // false
        $user->isClean('username'); // false
        $user->isClean ('nama'); // true
        $user->isClean (['nama', 'username']); // false*/

        $user->save();

        /*$user->isDirty(); // false
        $user->isClean(); // true
        dd($user->isDirty());*/

        $user->wasChanged(); // true
        $user->wasChanged('username'); // true
        $user->wasChanged (['username', 'level_id']); // true
        $user->wasChanged('nama'); // false
        dd($user->wasChanged(['nama', 'username'])); // true
    }
}
