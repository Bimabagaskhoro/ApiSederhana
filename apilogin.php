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


     //notif

    class Data {

        private $title;
        private $message;
    
        public function setTitle($title) 
        {
            $this->title = $title; 
        }
    
        public function setMessage($message) 
        {
            $this->message = $message;
        }
    
        public function getData() {
            $data = array();
            $data['data']['title'] = $this->title;
            $data['data']['message'] = $this->message;
            return $data;
        }
    
    }
    
    class Notification {

        // Sending message to a topic by topic name
        public function sendToTopic($to, $message)
        {
            $fields = array(
                'to' => '/topics/' . $to,
                'data' => $message
            );
            return $this->sendPushNotification($fields);
        }
    
        private function sendPushNotification($fields) {
     
            // Set POST variables
            $url = 'https://fcm.googleapis.com/fcm/send';
     
            $headers = array(
                'Authorization: key=' . FIREBASE_API_KEY,
                'Content-Type: application/json'
            );
            
            // Open connection
            $ch = curl_init();
     
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
    
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
     
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
     
            // Close connection
            curl_close($ch);
     
            return $result;
        }
    }
    
    function send_notifikasi() {

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
                $response["message"] = "Notification berhasil terkirim";
            } else {
                $response["status"] = 0;
                $response["message"] = $sendNotif;
            }
     
        } else {
            $response["status"] = 2;
            $response["message"] = "Parameter tidak sesuai";
        }
    
        echo json_encode($response);
    
    }

?>