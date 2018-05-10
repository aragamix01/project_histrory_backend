<?php
    include_once("./connect.php");
    $conn = getConnection();

    // $sql = "SELECT mo.obj_id AS obj_id, mo.obj_title, mo.obj_physicals, mok.keyword_obj_id AS keyword_id, mok.keyword FROM muse_object_keyword AS mok
    //         INNER JOIN muse_object AS mo ON mok.obj_id = mo.obj_id
    //         ORDER BY mo.obj_title";
    $sql = "SELECT mo.obj_id AS obj_id, mo.obj_title, mo.obj_physicals, mok.keyword_obj_id AS keyword_id, mok.keyword ,mp.pic_name, mp.obj_refcode
            FROM muse_object_keyword AS mok
            INNER JOIN muse_object AS mo 
            ON mok.obj_id = mo.obj_id
            LEFT JOIN muse_pic AS mp
            ON mp.obj_refcode = mo.obj_refcode
            WHERE mp.obj_cover = 1
            ORDER BY mo.obj_title";
    $sql2 = "SELECT COUNT(mo.obj_id) AS num_row FROM muse_object_keyword AS mok
            INNER JOIN muse_object AS mo ON mok.obj_id = mo.obj_id
            ORDER BY mo.obj_title";

        $dataTable = array();
        $ref = array();
        $check = -1;
        $i = 0;
        if ($result = $conn->query($sql)) {
                $dataLength = $conn->query($sql2);
                $dataLength = $dataLength->fetch_object()->num_row;
                // echo $dataLength;
                while ($obj = $result->fetch_object()) {
                    if ($check == -1) {
                        $check = $obj->obj_id;
                    }
                    if ($i == $dataLength - 1) {
                        array_push($ref,$obj->keyword);
                        array_push($dataTable,array(
                            'name' => $obj->obj_title,
                            'desc' => $obj->obj_physicals,
                            'keyword' => $ref,
                            'match' => 0,
                            'found' => array(),
                            'folder' => $obj->obj_refcode,
                            'pic' => $obj->pic_name
                        ));
                    }
                    if ($obj->obj_id != $check) {
                        array_push($dataTable,array(
                            'name' => $oldName,
                            'desc' => $oldDesc,
                            'keyword' => $ref,
                            'match' => 0,
                            'found' => array(),
                            'folder' => $obj->obj_refcode,
                            'pic' => $obj->pic_name
                        ));
                        $check = $obj->obj_id;
                        $ref = array();
                        array_push($ref,$obj->keyword);
                    } else {
                        array_push($ref,$obj->keyword);
                        $oldName = $obj->obj_title;
                        $oldDesc = $obj->obj_physicals;
                    }
                    $i++;
                }
                $conn->close();
        }
        echo json_encode($dataTable);
?>