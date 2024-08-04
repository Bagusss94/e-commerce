<?php

namespace App\Controllers;

use App\Models\CarouselModel;
use App\Models\GambarProdukModel;
use App\Models\ProdukModel;
use App\Models\SettingModel;
use App\Models\FaqsModel;

class Home extends BaseController
{
    protected $SettingModel;
    protected $CarouselModel;
    protected $ProdukModel;
    protected $GambarProdukModel;
    protected $FaqsModel;

    public function __construct()
    {
        $this->SettingModel = new SettingModel();
        $this->CarouselModel = new CarouselModel();
        $this->ProdukModel = new ProdukModel();
        $this->GambarProdukModel = new GambarProdukModel();
        $this->FaqsModel = new FaqsModel();
    }

    public function index()
    {
        return view('v_index', [
            'title' => 'Beranda',
            'carousel' => $this->CarouselModel->findAll(),
            'produk' => $this->ProdukModel->limit(3)->orderBy('id_produk', 'DESC')->get()->getResultArray(),
        ]);
    }

    public function daftar_produk()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;

        $perPage = 9;
        $offset = (1 + (($page - 1) * $perPage)) - 1;
        $limit = $perPage;

        $cari = $this->request->getGet('cari');
        if ($cari) {
            $total = $this->ProdukModel->getTotalRecord($cari);
            $produk = $this->ProdukModel->getProdukPagination($limit, $offset, $cari)->getResultArray();
        } else {
            $total = $this->ProdukModel->getTotalRecord();
            $produk = $this->ProdukModel->getProdukPagination($limit, $offset)->getResultArray();
        }


        $pager_links = $pager->makeLinks($page, $perPage, $total, 'paging_produk');
        $page_count = $pager->getPageCount();

        return view("v_daftar_produk", [
            'title' => "Daftar Produk",
            'produk' => $produk,
            'page_count' => $page_count,
            'pager_links' => $pager_links,
            'cari' => $cari
        ]);
    }

    public function detail_produk($id_produk)
    {
        $produk = $this->ProdukModel
            ->join('satuan', 'satuan.id_satuan=produk.id_satuan', 'left')
            ->join('kategori', 'kategori.id_kategori=produk.id_kategori', 'left')
            ->where('id_produk', $id_produk)->first();
        if (!$produk) {
            session()->setFlashdata('msg', "error#Produk tidak ditemukan!");
            return redirect()->to(base_url("/"));
        }

        return view('v_detail_produk', [
            'title' => "Detail Produk",
            'produk' => $produk,
            'gambar_produk' => $this->GambarProdukModel
                ->where('id_produk', $id_produk)->get()->getResultArray(),
            'produk_terkait' => $this->ProdukModel->where('id_kategori', $produk['id_kategori'])
                ->orderBy('id_produk', 'DESC')->limit(3)->get()->getResultArray()
        ]);
    }

    public function about_us()
    {
        return view('v_about_us', [
            'title' => 'About Us',
            'setting' => $this->SettingModel->first()
        ]);
    }

    public function fa()
    {
        // $faqs = [
        //     [
        //         'question' => 'Bagaimana cara melakukan pemesanan?',
        //         'answer' => 'Untuk melakukan pemesanan, pilih produk yang Anda inginkan, masukkan ke dalam keranjang belanja, dan ikuti petunjuk checkout.'
        //     ],
        //     [
        //         'question' => 'Metode pembayaran apa saja yang diterima?',
        //         'answer' => 'Kami menerima pembayaran melalui transfer bank, kartu kredit, dan pembayaran digital seperti e-wallet.'
        //     ],
        //     [
        //         'question' => 'Berapa lama waktu pengiriman?',
        //         'answer' => 'Waktu pengiriman tergantung pada lokasi Anda. Rata-rata pengiriman memakan waktu 3-5 hari kerja.'
        //     ],
        //     [
        //         'question' => 'Bagaimana cara melacak pesanan saya?',
        //         'answer' => 'Setelah pesanan dikirim, Anda akan menerima email konfirmasi yang berisi nomor resi. Gunakan nomor resi tersebut untuk melacak pesanan Anda melalui situs web jasa pengiriman.'
        //     ],
        //     [
        //         'question' => 'Apakah saya bisa mengembalikan produk?',
        //         'answer' => 'Ya, Anda bisa mengembalikan produk dalam waktu 7 hari setelah menerima pesanan. Pastikan produk dalam kondisi asli dan tidak rusak.'
        //     ],
        //     [
        //         'question' => 'Bagaimana cara menghubungi layanan pelanggan?',
        //         'answer' => 'Anda bisa menghubungi layanan pelanggan kami melalui email di support@tokoonline.com atau melalui telepon di nomor 123-456-789.'
        //     ]
        // ];

        $faqsModel = new FaqsModel();
        $faqs = $faqsModel->findAll();


        return view('v_faq', [
            'title' => 'FAQs',
            'faqs' => $faqs,
        ]);
    }
}
