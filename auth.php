<?php
    require_once 'dbconfig.php';
    session_start();

    function checkAuth() {
        if(!isset($_SESSION['_cads_user_id'])) {
            if(isset($_COOKIE['_cads_user_id']) && isset($_COOKIE['_cads_cookie_id'])&& isset($_COOKIE['_cads_token'])){
                $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
                $cookieid = $_COOKIE['_cads_cookie_id'];
                $userid = $_COOKIE['_cads_user_id'];
                $res = mysqli_query($conn, "SELECT * from cookie where id = $cookieid AND user = $userid");
                $cookie = mysqli_fetch_assoc($res);
                if(time()>$cookie["expires"]){
                    mysqli_query($conn, "DELETE from cookie where token = $cookieid");
                    header("Location: logout.php");
                }else if(password_verify($_COOKIE["_cads_token"], $cookie["hash"])){
                    $_SESSION['_cads_user_id'] = $_COOKIE["_cads_user_id"];
                    mysqli_close();
                    return $_SESSION['_cads_user_id'];
                }
            }
        } else {
            return $_SESSION['_cads_user_id'];
        }
    }
?>