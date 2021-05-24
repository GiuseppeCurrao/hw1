<?php

    require_once 'dbconfig.php';
    session_start();
    session_destroy();

    if(isset($_COOKIE['_cads_user_id']) && isset($_COOKIE['_cads_cookie_id']) && isset($_COOKIE['_cads_token'])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $cookieid = mysqli_real_escape_string($conn, $_COOKIE['_cads_cookie_id']);
        $userid = mysqli_real_escape_string($conn, $_COOKIE['_cads_user_id']);
        $res = mysqli_query($conn, "SELECT * from cookie where id = $cookieid AND user = $userid");
        $cookie = mysqli_fetch_assoc($res);
        if($cookie){
            if(password_verify($_COOKIE['_cads_token'], $cookie['hash'])){
                mysqli_query($conn, "DELETE from cookie where id = $cookieid");
                mysqli_close();
                setcookie("_cads_user_id", "");
                setcookie("_cads_cookie_id", "");
                setcookie("_cads_token", "");
            }
        }
    }
    header("Location: login.php");
?>