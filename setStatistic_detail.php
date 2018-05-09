<?php 
    include_once("./connect.php");
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO search_statistic_detail(ssd_word, ssd_time, ssd_found) VALUES (?,?,?)");
    $stmt->bind_param("sss",  $request->searchWord, $request->takeTime, $request->foundObject);
    $stmt->execute();
    $stmt->close();
?>