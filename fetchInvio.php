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
    $data = $_POST["data"];
    $nome = $_POST["sede"];

    $cor=false;
    while(!$cor){
        $codpren= rand(0, pow(10, 4));
        $query= "SELECT codpren from prenotazione where codpren = '$codpren'";
        if(mysqli_num_rows(mysqli_query($conn, $query))==0){
            $cor=true;
        }
    }
    $query = "INSERT INTO prenotazione values($codpren, '$userid', $nome)";
    $res = mysqli_query($conn, $query);

    echo json_encode($res);
    exit;
?>