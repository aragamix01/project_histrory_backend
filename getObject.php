<?php
    include_once("./connect.php");
    $conn = getConnection();
    // $sql = "SELECT obj_id, obj_title FROM muse_object";
    $sql = "SELECT mo.obj_id, mo.obj_title, mp.pic_name ,mo.obj_refcode 
            FROM muse_object AS mo
            LEFT JOIN muse_pic AS mp
            ON mp.obj_refcode LIKE mo.obj_refcode
            WHERE mp.obj_cover = 1";
    $rs = $conn->query($sql);

    $listOfObject = array();
    while ($obj = $rs->fetch_object()) {
    //    array_push($listOfObject, array('id' => $obj->obj_id, 'name' => $obj->obj_title));
        array_push($listOfObject, array(
            'id' => $obj->obj_id,
            'name' => $obj->obj_title,
            'pic' => $obj->pic_name,
            'folder' => $obj->obj_refcode
        ));
    }

    $conn->close();
    echo json_encode($listOfObject);
?>