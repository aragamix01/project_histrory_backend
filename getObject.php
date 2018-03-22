<?php
    include_once("./connect.php");
    $conn = getConnection();
    $sql = "SELECT obj_id, obj_title FROM muse_object";
    $rs = $conn->query($sql);

    $listOfObject = array();
    while ($obj = $rs->fetch_object()) {
       array_push($listOfObject, array('id' => $obj->obj_id, 'name' => $obj->obj_title));
    }

    $conn->close();
    echo json_encode($listOfObject);
?>