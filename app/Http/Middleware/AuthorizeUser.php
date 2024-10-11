<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role= ''): Response
    {
        $user = $request->user(); // Mengambil pengguna yang sedang autentikasi
                                 // fungsi user() diambil dari UserModel.php
        if (!$user || !$user->hasRole($role)) {
            abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini');
        }
// jika tidak punya role, maka tampilkan error 403
        return $next($request); // Melanjutkan ke request berikutnya
    }
}
