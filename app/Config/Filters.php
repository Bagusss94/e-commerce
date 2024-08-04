<?php

namespace Config;

use App\Filters\FilterAdmin;
use App\Filters\FilterKonsumen;
use App\Filters\FilterOwner;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filterAdmin' => FilterAdmin::class,
        'filterKonsumen' => FilterKonsumen::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            'filterAdmin' => [
                'except' => [
                    "/",
                    "home", "home/*",
                    'auth/login', 'auth/register', 'auth/lupa_password', "auth/ubah-password/*", "/",
                    "RajaOngkir", "RajaOngkir/*",
                    "daftar-produk", "detail-produk/*", 'about-us', "faqs",
                ]
            ],
            'filterKonsumen' => [
                'except' => [
                    "/",
                    "home", "home/*",
                    'auth/login', 'auth/register', 'auth/lupa_password', "auth/ubah-password/*", "/",
                    "RajaOngkir", "RajaOngkir/*",
                    "daftar-produk", "detail-produk/*", 'about-us', "faqs",

                ]
            ],
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
            'filterAdmin' => [
                'except' => [
                    '/',
                    'auth/logout',
                    "RajaOngkir", "RajaOngkir/*",
                    "daftar-produk", "detail-produk/*", 'about-us', "faqs",
                    "faqs/*",
                    'dashboard', 'dashboard/*',
                    'users', 'users/*',
                    'transaksi', 'transaksi/*',
                    // 'transaksi',
                    // 'transaksi/cetak-laporan', 'transaksi/index', 'transaksi/detail/*', 'transaksi/cetak-invoice/*', 'transaksi/cetak-laporan/*',
                    'produk', 'produk/*',
                    'satuan', 'satuan/*',
                    'kategori', 'kategori/*',
                    'setting', 'setting/*',
                ]
            ],
            'filterKonsumen' => [
                'except' => [
                    "/",
                    "/faqs",
                    'auth/logout',
                    "RajaOngkir", "RajaOngkir/*",
                    "daftar-produk", "detail-produk/*", 'about-us', "faqs",
                    'transaksiuser/*',
                    'tambah-keranjang/*', 'keranjang', 'checkout', 'history', 'history/*', "cetak-history/*",
                    'profil', 'profil/*',
                ]
            ],
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
