<?php
require_once "koneksi.php";
    if(function_exists($_GET['function'])){
        $_GET['function']();
    }
    function get_person(){
      global $connect;
      $query = $connect -> query("SELECT * FROM persons");
      while($row=mysqli_fetch_object($query))
      {
          $data[] =$row;
      }
      $response=array(
          'status' => 1,
          'message' =>'Success',
          'data' => $data
       );
      header('Content-Type: application/json');
      echo json_encode($response);
  }
  
  function get_person_byid(){
   global $connect;
   if (!empty($_GET["id"])) {
      $id = $_GET["id"];      
   }    
  
   $query ="SELECT * FROM persons WHERE id= $id";      
   $result = $connect->query($query);
   while($row = mysqli_fetch_object($result))
   {
      $data[] = $row;
   }            
   if($data)
   {
       $response = array(
           'status' => 1,
           'message' =>'Success',
           'data' => $data
        );               
   }else {
       $response=array(
           'status' => 0,
           'message' =>'No Data Found'
        );
   }
   header('Content-Type: application/json');
   echo json_encode($response);
   }
  
  function insert_person(){
     global $connect;   
     $check = array(
        'id' => '', 
        'email' => '', 
        'nama' => '',
        'tittle' => '',
        'gambar' => '');
        $check_match = count(array_intersect_key($_POST, $check));
        if($check_match == count($check)){
        
              $result = mysqli_query($connect, "INSERT INTO persons SET
              id = '$_POST[id]',
              email = '$_POST[email]',
              nama = '$_POST[nama]',
              tittle = '$_POST[tittle]',
              gambar = '$_POST[gambar]'
              ");
              
              if($result)
              {
                 $response=array(
                    'status' => 1,
                    'message' =>'Insert Success'
                 );
              }
              else
              {
                 $response=array(
                    'status' => 0,
                    'message' =>'Insert Failed.'
                 );
              }
        }else{
           $response=array(
                    'status' => 0,
                    'message' =>'Wrong Parameter'
                 );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
  }
  
  function update_person(){
   global $connect;
   if (!empty($_GET["id"])) {
   $id = $_GET["id"];      
   }   
   $check = array(
      'email' => '', 
      'nama' => '',
      'tittle' => '',
      'gambar' => '' );
  
   $check_match = count(array_intersect_key($_POST, $check));         
   if($check_match == count($check)){
     $result = mysqli_query($connect, "UPDATE persons SET              
              email = '$_POST[email]',
              nama = '$_POST[nama]',
              tittle = '$_POST[tittle]',
              gambar = '$_POST[gambar]'
     WHERE id = $id");
   
      if($result){
         $response=array(
            'status' => 1,
            'message' =>'Update Success');
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'Update Failed');
      }
   }else{
      $response=array(
               'status' => 0,
               'message' =>'Wrong Parameter',
               'data'=> $id);
   }
   header('Content-Type: application/json');
   echo json_encode($response);
  }
  
  function delete_person(){
   global $connect;
   $id = $_GET['id'];
   $query = "DELETE FROM persons WHERE id=".$id;
   if(mysqli_query($connect, $query))
   {
      $response=array(
         'status' => 1,
         'message' =>'Delete Success'
      );
   }
   else
   {
      $response=array(
         'status' => 0,
         'message' =>'Delete Failed.'
      );
   }
   header('Content-Type: application/json');
   echo json_encode($response);
  }

  function upload_gambar(){
   $image = $_FILES['file']['tmp_name'];
   $imagename = $_FILES['file']['name'];
   $file_path = "uploadgambar";
   
   $response = array();
   
   if (!file_exists($file_path)) {
       mkdir($file_path, 0777, true);
   }
   
   if(!$image){
       $response=array(
           'status' => 0,
           'message' =>'Gambar Tidak Ditemukan'
       );;
   }
   else{
       if(move_uploaded_file($image, $file_path.'/'.$imagename)){
           $response=array(
               'status' => 1,
               'message' =>'Insert Success'
           );
       }else {
         $response = array(
             'status' => 0,
             'message' => 'Success Gagal'
         );
   }
   header('Content-Type: application/json');
   echo json_encode($response);
   }
   }

?>