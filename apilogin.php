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
           'avatar' => '',
           'id_device' => '');
           $check_match = count(array_intersect_key($_POST, $check));
           if($check_match == count($check)){
           
                 $result = mysqli_query($connect, "INSERT INTO user SET
                 id = '$_POST[id]',
                 nama = '$_POST[nama]',
                 email = '$_POST[email]',
                 passwd = '$_POST[passwd]',
                 avatar = '$_POST[avatar]',
                 id_device = '$_POST[id_device]'
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
               'avatar' => '',
               'id_device' => ''
            );
           
            $check_match = count(array_intersect_key($_POST, $check));         
            if($check_match == count($check)){
              $result = mysqli_query($connect, "UPDATE user SET   
                       nama = '$_POST[nama]',           
                       email = '$_POST[email]',
                       passwd = '$_POST[passwd]',
                       avatar = '$_POST[avatar]',
                       id_device = '$_POST[id_device]'
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

            function login_auth_id_device() 
            {
                global $connect;

                $id_device = $_POST['id_device'];
                $query = mysqli_query($connect, "SELECT * FROM user WHERE 
                id_device= '$id_device'");
                $result = array();

                while ($row = $query->fetch_assoc()) {
                    array_push($result, array(
                        'id' => $row['id'],
                        'nama' => $row['nama'],
                        'email' => $row['email'],
                        'passwd' => $row['passwd'],
                        'avatar' => $row['avatar'],
                        'id_device' => $row['id_device']
                    ));
                };

                if ($result) {
                    $response = array(
                        'status' => 1,
                        'message' => 'Success',
                        'data' => $result
                    );
                } else {
                    $response = array(
                        'status' => 0,
                        'message' => 'No data found'
                    );
                }
                header('Content-Type: application/json');
                echo json_encode($response);
            }
            
            function update_id_device() {
                global $connect;

                $check = array(
                    'id' => '',
                    'id_device' => ''
                );

                $check_match = count(array_intersect_key($_POST, $check));
                $id = $_POST["id"];
                $id_device = $_POST["id_device"];

                if($check_match == count($check)) {
                    $result = mysqli_query($connect, "UPDATE user SET 
                    id_device = '$id_device'
                    WHERE id = '$id'");
                    if($result) {
                        $response=array(
                            'status' => 1,
                            'message' =>'Update user hardware success!'
                        );
                    }
                    else {
                        $response=array(
                            'status' => 0,
                            'message' =>'Update user hardware fail!'
                        );
                    }
                }
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        
            
        
?>