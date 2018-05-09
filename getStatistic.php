<?php
    include_once("./connect.php");
    $conn = getConnection();

    $CountMuseObjectSQL = "SELECT COUNT(obj_id) AS found FROM muse_object WHERE 1";
    $CountMatchObjectSQL = "SELECT COUNT(obj_id) AS found
             FROM muse_object
             WHERE obj_id IN (
                SELECT mo.obj_id
                FROM muse_object AS mo
                INNER JOIN muse_object_keyword AS mok
                ON mo.obj_id = mok.obj_id
                GROUP BY mo.obj_id
             )";
    $CountMatchKeywordSQL = "SELECT COUNT(key_id) AS found FROM keyword_table WHERE key_ref IS NULL";
    $CountLoveSQL = "SELECT likeCount AS found FROM search_statistic WHERE 1";
    $CountSearchSQL = "SELECT searchCount AS found FROM search_statistic WHERE 1";

    $CountMuseObject = $conn->query($CountMuseObjectSQL);
    $CountMuseObject = $CountMuseObject->fetch_object()->found;

    $CountMatchObject = $conn->query($CountMatchObjectSQL);
    $CountMatchObject = $CountMatchObject->fetch_object()->found;

    $CountMatchKeyword = $conn->query($CountMatchKeywordSQL);
    $CountMatchKeyword = $CountMatchKeyword->fetch_object()->found;

    $CountLove = $conn->query($CountLoveSQL);
    $CountLove = $CountLove->fetch_object()->found;

    $CountSearch = $conn->query($CountSearchSQL);
    $CountSearch = $CountSearch->fetch_object()->found;

    $conn->close();
    $data = array(
        'CountMuseObject' => $CountMuseObject,
        'CountMatchObject' => $CountMatchObject,
        'CountMatchKeyword' => $CountMatchKeyword,
        'CountLove' => $CountLove,
        'CountSearch' => $CountSearch
    );
    echo json_encode($data);
?>