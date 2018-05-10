<?php
    include_once("./connect.php");
    $conn = getConnection();

    $sql = "SELECT mo.obj_id, mo.obj_title, mok.keyword_obj_id, mok.keyword , mo.obj_physicals, mp.obj_refcode
            FROM muse_object AS mo
            LEFT JOIN muse_object_keyword AS mok ON mo.obj_id = mok.obj_id
            LEFT JOIN muse_pic AS mp ON mp.obj_refcode = mo.obj_refcode
            GROUP BY mok.keyword_obj_id
            ORDER BY mo.obj_title";

    $sql2 = "SELECT COUNT(mo.obj_id) AS num_row FROM muse_object AS mo
            LEFT JOIN muse_object_keyword AS mok ON mo.obj_id = mok.obj_id
            ORDER BY mo.obj_title";

    $sql3 = "SELECT mo.obj_id ,mp.obj_refcode , mp.pic_name
                FROM muse_object AS mo
                LEFT JOIN muse_object_keyword AS mok ON mo.obj_id = mok.obj_id
                LEFT JOIN muse_pic AS mp ON mp.obj_refcode = mo.obj_refcode
                GROUP BY mp.pic_name
                ORDER BY mo.obj_title";

    $dataTable = array();
    $ref = array();
    $check = -1;
    $i = 0;
    $old = null;
    $oldKey = null;
    $oldId = null;
    if ($result = $conn->query($sql)) {
            $dataLength = $conn->query($sql2);
            $dataLength = $dataLength->fetch_object()->num_row;
            while ($obj = $result->fetch_object()) {
                if ($check == -1) {
                    $check = $obj->obj_id;
                }
                if ($obj->keyword_obj_id == null) {
                    if($oldId != null) {
                        array_push($dataTable,array(
                            'id' => $oldId,
                            'name' => $old,
                            'physical' => $oldPhy,
                            'key' => $ref,
                            'folder' => $oldFolder
                        ));
                        $ref = array();
                        $old = null;
                        $oldKey = null;
                        $oldId = null;
                    } 
                    array_push($dataTable, array(
                        'id' => $obj->obj_id,
                        'name' => $obj->obj_title,
                        'physical' => $obj->obj_physicals,
                        'key' => array(),
                        'folder' => $obj->obj_refcode
                    ));
                    $check = -1;
                } else {
                    if ($obj->obj_id != $check && $check = -1) {
                        if ($oldId != null)
                            array_push($dataTable,array(
                                'id' => $oldId,
                                'name' => $old,
                                'physical' => $oldPhy,
                                'key' => $ref,
                                'folder' => $oldFolder
                            ));
                        $check = $obj->obj_id;
                        $ref = array();
                        array_push($ref,$obj->keyword);
                    }else {
                        array_push($ref,$obj->keyword);
                        $check = $obj->obj_id;
                        $old = $obj->obj_title;
                        $oldKey = $obj->keyword_obj_id;
                        $oldId = $obj->obj_id;
                        $oldPhy = $obj->obj_physicals;
                        $oldFolder = $obj->obj_refcode;
                    }
                }
                $i++;
            }
        }

        $conn->close();
        echo json_encode($dataTable);
?>