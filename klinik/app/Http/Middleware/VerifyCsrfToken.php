<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/ajax/purchase-order-edittable',
        '/ajax/permintaan-barang-detail-editable',
        '/ajax/indikator-editable',
        '/ajax/hasil-pemeriksaan-lab-editable',
    ];
}
