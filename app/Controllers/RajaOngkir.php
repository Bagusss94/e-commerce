<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class RajaOngkir extends BaseController
{
    // private function option($url)
    // {
    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://api.rajaongkir.com/starter/" . $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => array(
    //             "key: ae7e283da200ac4d7abae2ef9cbf566f"
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         return "cURL Error #:" . $err;
    //     } else {
    //         return $response;
    //     }
    // }

    public function getProvinsi($id_provinsi = null)
    {
        // if (!$this->request->isAJAX()) {
        //     exit("Maaf tidak dapat diproses!");
        // }

        if ($id_provinsi != null) {
            $url = "https://api.rajaongkir.com/starter/province?id=" . $id_provinsi;
        } else {
            $url = "https://api.rajaongkir.com/starter/province";
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: ae7e283da200ac4d7abae2ef9cbf566f"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
    public function getKota($id_kota = null)
    {
        if ($this->request->isAJAX()) {

            $id_provinsi = $this->request->getPost('id_provinsi');
            if ($id_kota !== null) {
                $url = "https://api.rajaongkir.com/starter/city?id=" . $id_kota . "&province=" . $id_provinsi;
            } else {
                $url = "https://api.rajaongkir.com/starter/city?province=" . $id_provinsi;
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "key: ae7e283da200ac4d7abae2ef9cbf566f"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        } else {
            exit("Maaf tidak dapat diproses!");
        }
    }

    public function getEkspedisi()
    {
        if ($this->request->isAJAX()) {
            echo json_encode([
                'ekspedisi' => ['jne', 'pos', 'tiki']
            ]);
        } else {
            exit("Maaf tidak dapat diproses!");
        }
    }

    public function getBiayaOngkir()
    {
        if ($this->request->isAJAX()) {
            $SettingModel = new SettingModel();
            $setting = $SettingModel->first();
            $id_kota_asal = $setting['distrik'];
            $id_kota_tujuan = $this->request->getPost('id_distrik');
            $berat = $this->request->getPost('berat');
            $kurir = $this->request->getPost('kurir');

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=" . $id_kota_asal . "&destination=" . $id_kota_tujuan . "&weight=" . $berat . "&courier=" . $kurir,
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: ae7e283da200ac4d7abae2ef9cbf566f"
                ),
            ));


            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        } else {
            exit("Maaf tidak dapat diproses!");
        }
    }
}
