<?php
    function getConnection(){
        
        $url = array(
            "host" => "localhost",
            "user" => "root",
            "pass" => "",
            "db" => "muse_test"
        );

        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = $url["db"];
        
        
        if($conn = new mysqli($server, $username, $password, $db)){
            // echo true;
        }else{
            echo false;
        }
        return $conn;
    }
?>