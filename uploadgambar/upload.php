<?php
require_once "koneksi.php";
if(function_exists($_GET['function'])){
    $_GET['function']();
}
function insert_gambar(){
    global $connect;
    
    $gambar = $_FILES['file']['tmp_file'];
    $gambarName = $_FILES['file']['name'];
    
    $filePath = $_SERVER['DOCUMENT_ROOT'].'/uploadgambar';

    $data = "";

    if (!file_exists($filePath)) {
        mkdir($filePath, 0777, true);
    }
    
    if (!$gambar) {
        $data["status"] = 0;
        $data["message"] = "Upload Failed";
    } else {
        if (move_uploaded_file($gambar, $filePath.'/'.$gambarName)) {
            $data["statue"] = 1;
            $data["message"] = "Upload Successr";
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    }
  
?>