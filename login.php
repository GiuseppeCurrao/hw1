<?php
    require "dbconfig.php";
    session_start();
    if(isset($_SESSION['cads_pid'])){
        header("Location: dip_pers.php");
        exit;
    } 
    
    if(isset($_SESSION['cads_id'])){
        header("Location: don_pers.php");
        exit;
    }

    if(!empty($_POST["cf"]) && !empty($_POST["dpassword"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $cf = mysqli_real_escape_string($conn, $_POST["cf"]);
        $psw = mysqli_real_escape_string($conn, $_POST["dpassword"]);

        $query = "SELECT * from donatori where cf = '$cf'";
        $res= mysqli_query($conn, $query);

        if(mysqli_num_rows($res)>0){
            $entry= mysqli_fetch_assoc($res);
            if($psw==$entry['psw']){
                session_start();
                $_SESSION["cads_cf"] = $entry["name"];
                $_SESSION["cads_id"] = $entry["cai"];
                header("Location: don_pers.php");
                mysqli_close($conn);
                exit();
            }
        }
        $error = "Codice fiscale o password errati";
    }

    if(!empty($_POST["id_dip"]) && !empty($_POST["mpassword"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $id =mysqli_real_escape_string($conn, $_POST["id_dip"]);
        $psw = mysqli_real_escape_string($conn, $_POST["mpassword"]);

        $query = "SELECT cf, psw, tipo from dipendenti where cf = '$id'";
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res)>0){
            $entry = mysqli_fetch_assoc($res);
            echo $entry['psw'];
            if($_POST["mpassword"]==$entry['psw']){
                session_start();
                $_SESSION["cads_name"] = $entry["name"];
                $_SESSION["cads_pid"] = $entry["cf"];
                $_SESSION["cads_tipo"] = $entry["tipo"];
                header("Location: dip_pers.php");
                mysqli_close($conn);
                exit();
            }
        }
        $error = "Codice o passwrd errati";
    }
?>

<html>
    <head> 
        <meta charset="utf-8">
        <title Associazioni donazioni sangue Currao></title>
        <link href="https://fonts.googleapis.com/css2?family=Lato&family=Merriweather+Sans&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="head&foot.css">
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <header>
                <nav>
                    <div id="logo">
                        <div id= "img">
                            <a href="hw1.php"><img src="Immagini/logo.png" ></a>
                        </div>
                        <a href= "hw1.php">Cads</a>
                    </div>
                    <a class="buttom" href = "locali.php">
                        Trova sedi vicine 
                    </a>
                    <div id="links">
                        <a href="hw1.php">Home</a>
                        <a href = "login.php">Accedi</a>
                    </div>
                    <div id="menù">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </nav>

                <h1>
                    <strong>Associazione </br>donazione sangue</strong>
                </h1>
            </header>
        <section id="center">
            <section class ="form">
                <form name="login" method= "post">
                    <h3>Area dipendenti</h3>
                    <div class="username">
                        <div><label for='id_dip'>ID personale</label></div>
                        <div><input type='text' name='id_dip' <?php if(isset($_POST["id_dip"])){echo "value=".$_POST["id_dip"];} ?>></div>
                    </div>
                    <div class="password">
                        <div><label for='mpassword'>Password</label></div>
                        <div><input type='password' name='mpassword' <?php if(isset($_POST["mpassword"])){echo "value=".$_POST["mpassword"];} ?>></div>
                    </div>
                    <div>
                        <input type="submit" value="Accedi"> 
                    </div>
                </form>
                <img src="Immagini/doc.png">
            </section>
            <section class ="form">
                <form name="login" method= "post">
                    <h3>Area donatori</h3>
                    <div class="cf">
                        <div><label for='cf'>Codice fiscale</label></div>
                        <div><input type='text' name='cf' <?php if(isset($_POST["cf"])){echo "value=".$_POST["cf"];} ?>></div>
                    </div>
                    <div class="password">
                        <div><label for='dpassword'>Password</label></div>
                        <div><input type='password' name='dpassword' <?php if(isset($_POST["dpassword"])){echo "value=".$_POST["dpassword"];} ?>></div>
                    </div>
                    <div class = "remember">
                        <div><input type='checkbox' name='remember' value="1" <?php if(isset($_POST["remember"])){echo $_POST["remember"] ? "checked" : "";} ?>></div>
                        <div><label for='remember'>Ricorda l'accesso</label></div>
                    </div>
                    <div>
                        <input type="submit" value="Accedi"> 
                    </div>
                    <div class="signup">Non hai un account? <a href="reg.php">Registrati</a></div>
                </form>
                <img src="Immagini/drop.png">
            </section>
        </section>
    </body>
</html>
