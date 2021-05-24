<?php

    require_once 'dbconfig.php';
    session_start();
    if(!isset($_SESSION['cads_id'])){
        header("Location: login.php");
        exit;
    }

    header("Content-Type: application/json");

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $userid = mysqli_real_escape_string($conn, $_SESSION["cads_id"]);
    
    $query = "SELECT codsede, nome, citta, via from sede ORDER BY nome";
    $res = mysqli_query($conn, $query);
    $array= array();
    if(mysqli_num_rows($res)>0){
        for($i=0; $i < mysqli_num_rows($res); $i++){
            array_push($array, mysqli_fetch_assoc($res));
        }
        echo json_encode($array);
    }
    exit;
?>