<?php
    include_once("./connect.php");
  
        $conn = getConnection();
        $sql = "SELECT t1.key_id AS key_id_key, t1.word AS keyword, t2.key_id, t2.key_ref, t2.word AS reference FROM keyword_table as t1
                INNER JOIN keyword_table as t2 ON t1.key_id = t2.key_ref
                ORDER BY t1.word";
        $sql2 = "SELECT COUNT(t1.key_id) AS num_row FROM keyword_table as t1
                INNER JOIN keyword_table as t2 ON t1.key_id = t2.key_ref
                WHERE 1";
        $dataTable = array();
        $ref = array();
        $check = -1;
        $i = 0;
        if ($result = $conn->query($sql)) {
                $dataLength = $conn->query($sql2);
                $dataLength = $dataLength->fetch_object()->num_row;
                while ($obj = $result->fetch_object()) {
                    if ($check == -1) {
                        $check = $obj->key_id_key;
                    }
                    if ($i == $dataLength - 1 && $obj->key_id_key != $check) {
                        array_push($dataTable,array('id' => $oldId, 'key' => $old, 'ref' => $ref));
                        $check = $obj->key_id_key;
                        $ref = array();
                        array_push($ref,$obj->reference);
                        array_push($dataTable,array('id' => $obj->key_id_key, 'key' => $obj->keyword, 'ref' => $ref));
                    } else {
                        if ($i == $dataLength - 1) {
                            array_push($ref,$obj->reference);
                            array_push($dataTable,array('id' => $obj->key_id_key, 'key' => $obj->keyword, 'ref' => $ref));
                        }
                        if ($obj->key_id_key != $check) {
                            array_push($dataTable,array('id' => $oldId, 'key' => $old, 'ref' => $ref));
                            $check = $obj->key_id_key;
                            $ref = array();
                            array_push($ref,$obj->reference);
                        } else {
                            array_push($ref,$obj->reference);
                            $old = $obj->keyword;
                            $oldId = $obj->key_id_key;
                    }
                    }
                    $i++;
                }
                $conn->close();
        }
        echo json_encode($dataTable);
?>