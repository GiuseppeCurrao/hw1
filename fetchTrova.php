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
    $cognome= mysqli_real_escape_string($conn, $_POST["cognome"]);
    $query = "SELECT nome, telefono, tipo from dipendenti where nome like '$cognome'";
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