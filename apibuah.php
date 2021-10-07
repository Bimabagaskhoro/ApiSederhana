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

     // send notif
     function send_notification() {

      $check      = array('title' => '', 'message' => '');
      $checkMatch = count(array_intersect_key($_POST, $check));
  
      if ($checkMatch == count($check)) {
  
          $title   = $_POST['title'];
          $message = $_POST['message'];
          
          $dataEntity = new Data();
          $firebase   = new Notification();
  
          $dataEntity->setTitle($title);
          $dataEntity->setMessage($message);
  
          $sendNotif = $firebase->sendToTopic('formulir-app-commonly', $dataEntity->getData());
  
          if ($sendNotif == TRUE) {
              $response["status"] = 1;
              $response["message"] = "Notification berhasil";
          } 
      } else {
          $response["status"] = 0;
          $response["message"] = "Parameter tidak sesuai";
      }
  
      echo json_encode($response);
      
    
?>