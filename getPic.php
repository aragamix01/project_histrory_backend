<?php
    include_once("./connect.php");
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
    $conn = getConnection();
    
    $rs = $conn->query("SELECT pic_name FROM `muse_pic` WHERE obj_refcode = ?");
    $listOfPics = array();
    $stmt = $conn->prepare("SELECT pic_name FROM `muse_pic` WHERE obj_refcode = ?");
    $stmt->bind_param("s",  $request->folder);
    $stmt->execute();
    $listOfPics = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $conn->close();
    echo json_encode($listOfPics);
?>