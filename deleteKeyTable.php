<?php
        include_once("./connect.php");
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

        $conn = getConnection();
        $conn->query("DELETE FROM keyword_table WHERE key_id = '$request'");
        $conn->query("DELETE FROM keyword_table WHERE key_ref = '$request'");  
        $conn->close();
        echo $request;
?>