<?php
        include_once("./connect.php");
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO keyword_table (word) VALUES (?)");
        $stmt->bind_param("s",  $request->key);
        $stmt->execute();
        $stmt->close();

        $sqlLastrow = "SELECT key_id FROM keyword_table ORDER BY key_id DESC LIMIT 1";
        $lastRow = $conn->query($sqlLastrow)->fetch_object()->key_id;

        foreach ($request->refs as $index => $obj) {
                $stmt = $conn->prepare("INSERT INTO keyword_table (key_ref, word) VALUES (?,?)");
                $stmt->bind_param("ss",$lastRow, $obj);
                $stmt->execute();
                $stmt->close();
        }
        $conn->close();
        echo "success";
?>