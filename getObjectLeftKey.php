<?php
    include_once("./connect.php");
    $conn = getConnection();

    $sql = "SELECT mo.obj_id, mo.obj_title, mok.keyword_obj_id, mok.keyword FROM muse_object AS mo
            LEFT JOIN muse_object_keyword AS mok ON mo.obj_id = mok.obj_id
            ORDER BY mo.obj_id";

    $sql2 = "SELECT COUNT(mo.obj_id) AS num_row FROM muse_object AS mo
            LEFT JOIN muse_object_keyword AS mok ON mo.obj_id = mok.obj_id
            ORDER BY mo.obj_id";

    $dataTable = array();
    $ref = array();
    $check = -1;
    $i = 0;
    if ($result = $conn->query($sql)) {
            $dataLength = $conn->query($sql2);
            $dataLength = $dataLength->fetch_object()->num_row;
            while ($obj = $result->fetch_object()) {
                if($obj->keyword_obj_id == null) {
                    if ($oldKey != null){
                        array_push($dataTable,array('key' => $old, 'ref' => $ref));
                        $check = $obj->obj_id;
                        $ref = array();
                        // array_push($ref,$obj->keyword);
                        $oldKey = null;
                    } else {
                        array_push($dataTable, array('name' => $obj->obj_title, 'key' => array()));
                        $check = -1;
                    }
                } else {
                    if ($check == -1) {
                        $check = $obj->obj_id;
                    }
                    if ($i == $dataLength - 1) {
                        array_push($ref,$obj->keyword);
                        array_push($dataTable,array('key' => $obj->obj_title, 'ref' => $ref));
                    }
                    if ($obj->obj_id != $check) {
                        array_push($dataTable,array('key' => $old, 'ref' => $ref));
                        $check = $obj->obj_id;
                        $ref = array();
                        array_push($ref,$obj->keyword);
                    } else {
                        array_push($ref,$obj->keyword);
                        $old = $obj->obj_title;
                        $oldKey = $obj->keyword_obj_id;
                    }
                }
                $i++;
            }
            $conn->close();
        }
        echo json_encode($dataTable);
?>
//simalar getObject But use left join