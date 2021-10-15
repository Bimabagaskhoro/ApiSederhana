<?php

require_once('koneksi.php');
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

function insertImage() {
    global $connect;

    $image = $_FILES['file']['tmp_name'];
    $imageName = $_FILES['file']['name'];

    $filePath = $_SERVER['DOCUMENT_ROOT']."/tugasGitsApi/uploadgambar";

    if (!file_exists($filePath)) {
        mkdir($filePath, 0777, true);
    }

    if (!$image) {
        $response["status"] = 400;
        $response["message"] = "Gambar tidak ditemukan";
    } else {
        if (move_uploaded_file($image, $filePath.'/'.$imageName)) {
            $response["status"] = 200;
            $response["message"] = "Sukses upload gambar";
        }
    }

    echo json_encode($response);
}

function upload_gambar(){
    $gambar = $_FILES['file']['tmp_name'];
    $namaGambar = $_FILES['file']['name'];

    // Path untuk menyimpan gambar
    // Gambar akan disimpan dalam folder user_img yang terdapat pada direktori root bukuRestApi
    $file_path = 'uploadgambar';
    $response = array();
    if (!file_exists($file_path)) {
        mkdir($file_path, 0777, true);
    }
    if(!$gambar){
        $response = array(
            'status' => 0,
            'message' => "Gagal menemukan gambar!"
        );
    }
    else{
        if(move_uploaded_file($gambar, $file_path.'/'.$namaGambar)){
            $response = array(
                'status' => 1,
                'message' => "Sukses upload gambar!"
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => "Gagal upload gambar!"
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>