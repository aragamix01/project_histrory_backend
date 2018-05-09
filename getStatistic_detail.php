<?php
    include_once("./connect.php");
    $conn = getConnection();
    $sql1 = "SELECT ssd_word FROM search_statistic_detail";
    $sql2 = "SELECT ssd_time FROM search_statistic_detail";
    $sql3 = "SELECT ssd_found FROM search_statistic_detail";

    $rs = $conn->query($sql1);
    $listOfWord = array();
    while ($obj = $rs->fetch_object()) {
       array_push($listOfWord, $obj->ssd_word);
    }

    $rs = $conn->query($sql2);
    $listOfTime = array();
    while ($obj = $rs->fetch_object()) {
       array_push($listOfTime, $obj->ssd_time);
    }

    $rs = $conn->query($sql3);
    $listOfFound = array();
    while ($obj = $rs->fetch_object()) {
       array_push($listOfFound, $obj->ssd_found);
    }

    $data = array('searchWord' => $listOfWord, 'timeTaken' => $listOfTime, 'foundObject' => $listOfFound);
    $conn->close();
    echo json_encode($data);
?>