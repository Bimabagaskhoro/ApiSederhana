<?php
require_once "koneksi.php";
    if(function_exists($_GET['function'])){
        $_GET['function']();
    }

    function insert_buah()
    {
       global $connect;   
       $check = array(
          'id' => '', 
          'nama' => '', 
          'harga' => '');
       $check_match = count(array_intersect_key($_POST, $check));
       if($check_match == count($check)){
       
             $result = mysqli_query($connect, "INSERT INTO buah SET
             id = '$_POST[id]',
             nama = '$_POST[nama]',
             harga = '$_POST[harga]'");
             
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

    function update_buah(){
       global $connect;
       if (!empty($_GET["id"])) {
       $id = $_GET["id"];      
    }   
       $check = array(
          'nama' => '', 
          'harga' => '');

       $check_match = count(array_intersect_key($_POST, $check));         
       if($check_match == count($check)){
         $result = mysqli_query($connect, "UPDATE buah SET               
         nama = '$_POST[nama]',
         harga = '$_POST[harga]' WHERE id = $id");
       
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

    function get_buah(){
        global $connect;
        $query = $connect -> query("SELECT * FROM buah");
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

    function get_buah_byid(){
        global $connect;
        if (!empty($_GET["id"])) {
           $id = $_GET["id"];      
        }    

        $query ="SELECT * FROM buah WHERE id= $id";      
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

    function delete_buah(){
        global $connect;
        $id = $_GET['id'];
        $query = "DELETE FROM buah WHERE id=".$id;
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
              'message' =>'Delete Fail.'
           );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    //person


    function get_person(){
      global $connect;
      $query = $connect -> query("SELECT * FROM person");
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

   $query ="SELECT * FROM person WHERE id= $id";      
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
        'passwd' => '', 
        'gambar' => '' );
        $check_match = count(array_intersect_key($_POST, $check));
        if($check_match == count($check)){
        
              $result = mysqli_query($connect, "INSERT INTO person SET
              id = '$_POST[id]',
              email = '$_POST[email]',
              nama = '$_POST[nama]',
              passwd = '$_POST[passwd]',
              gambar = '$_POST[gambar]'");
              
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
      'passwd' => '', 
      'gambar' => '' );

   $check_match = count(array_intersect_key($_POST, $check));         
   if($check_match == count($check)){
     $result = mysqli_query($connect, "UPDATE person SET              
      email = '$_POST[email]',
      nama = '$_POST[nama]',
      passwd = '$_POST[passwd]',
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
   $query = "DELETE FROM person WHERE id=".$id;
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

  function insert_gambar(){
  global $connect;

  $gambar = $_FILES['file']['tmp_file'];
  $gambarName = $_FILES['file']['name'];

  $filePath = $_SERVER['DOCUMENT_ROOT'].'/uploadgambar';

  if (!file_exists($filePath)) {
      mkdir($filePath, 0777, true);
  }

  if (!$gambar) {
      $response["status"] = 0;
      $response["message"] = "Upload Failed";
  } else {
      if (move_uploaded_file($gambar, $filePath.'/'.$gambarName)) {
          $response["statue"] = 1;
          $response["message"] = "Upload Successr";
      }
  }

  header('Content-Type: application/json');
  echo json_encode($response);
  }
?>