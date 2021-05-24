<?php
    require_once 'dbconfig.php';
    session_start();
    if(!isset($_SESSION['cads_pid'])){
        header("Location: login.php");
        exit;
    }

    header("Content-Type: application/json");

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $userid = mysqli_real_escape_string($conn, $_SESSION["cads_pid"]);
    $tipo= $_SESSION["cads_tipo"];
    if($tipo=="medico"){
        $query= "SELECT s.codsede as codsede, s.nome as nome, d.tipo as tipo from sede s join sede_att_med sm on s.codsede=sm.codsede join medici m on sm.codmed=m.codmed join dipendenti d on m.cf= d.cf where d.cf= '$userid'";
        $res = mysqli_fetch_assoc(mysqli_query($conn, $query));
        $array = array();
        array_push($array, $res);
        echo json_encode($array);
    }else{
        $query= "SELECT s.codsede as codsede, s.nome as nome, sm.giorni as giorni, d.tipo as tipo from sede s join sedi_inf sm on s.codsede=sm.codsede join infermieri m on sm.codinf=m.codinf join dipendenti d on m.cf=d.cf where sm.cf= '$userid'";
        $reso = mysqli_query($conn, $query);
        $array= array();
        if(mysqli_num_rows($reso)>0){
            for($i=0; $i<mysqli_num_rows($res);$i++){
                array_push($array, mysqli_fetch_assoc($res));
            }
            echo json_encode($array);
        }
    }
    exit;
?>