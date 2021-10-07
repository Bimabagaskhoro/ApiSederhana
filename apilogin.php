<?php
require_once "koneksi.php";
    if(function_exists($_GET['function'])){
        $_GET['function']();
    }

    function get_user(){
        global $connect;
        $query = $connect -> query("SELECT * FROM user");
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

    function insert_user(){
        global $connect;   
        $check = array(
           'id' => '', 
           'nama' => '', 
           'email' => '',
           'passwd' => '',
           'avatar' => '');
           $check_match = count(array_intersect_key($_POST, $check));
           if($check_match == count($check)){
           
                 $result = mysqli_query($connect, "INSERT INTO user SET
                 id = '$_POST[id]',
                 nama = '$_POST[nama]',
                 email = '$_POST[email]',
                 passwd = '$_POST[passwd]',
                 avatar = '$_POST[avatar]'
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
        
        function update_user(){
            global $connect;
            if (!empty($_GET["id"])) {
            $id = $_GET["id"];      
            }   
            $check = array(
               'nama' => '',
               'email' => '', 
               'passwd' => '',
               'avatar' => '' );
           
            $check_match = count(array_intersect_key($_POST, $check));         
            if($check_match == count($check)){
              $result = mysqli_query($connect, "UPDATE user SET   
                       nama = '$_POST[nama]',           
                       email = '$_POST[email]',
                       passwd = '$_POST[passwd]',
                       avatar = '$_POST[avatar]'
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

           function login_user()
           {
            global $connect;
            if (!empty($_GET["email"]) && !empty($_GET["passwd"])) {
                $email = $_GET["email"];  
                $passwd = $_GET["passwd"];  
            }

            $query = "SELECT * FROM user WHERE 
            email = '$email' AND 
            passwd = '$passwd'";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_object($result)) {
                    $data[] = $row;
                }
                $response = array(
                    'status' => 1,
                    'message' => 'get data succeed',
                    'data' => $data);
                }else{
                $response = array(
                    'status' => 0,
                    'message' => 'no data found'
                );
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            }

           function upload_avatar(){
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