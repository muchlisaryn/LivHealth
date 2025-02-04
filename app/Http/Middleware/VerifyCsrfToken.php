<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCsrfToken
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Tambahkan route yang tidak ingin dikenakan CSRF protection
        '*', // Menonaktifkan CSRF di seluruh aplikasi (gunakan ini hanya jika yakin)
    ];

   
}
