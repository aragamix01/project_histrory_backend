<?php
        include_once("./connect.php");
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

        $conn = getConnection();
        $id = $request->id;
        $conn->query("DELETE FROM `muse_object_keyword` WHERE `obj_id` = '$id'");
        foreach ($request->keyword as $obj) {
            $stmt = $conn->prepare("INSERT INTO muse_object_keyword (obj_id, keyword) VALUES (?,?)");
            $stmt->bind_param("ss",$id, $obj);
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
        echo "success";
?>