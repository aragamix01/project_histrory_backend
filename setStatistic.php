<?php 
    include_once("./connect.php");
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

    $setLike = "UPDATE search_statistic SET likeCount = likeCount + 1";
    $setSearch = "UPDATE search_statistic SET searchCount = searchCount + 1";

    $conn = getConnection();
    if ($request == 0) {
        $conn->query($setLike);
    }else {
        $conn->query($setSearch);
    }
    $conn->close();
    echo $request->type;
?>