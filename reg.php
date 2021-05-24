<?php

    require_once 'dbconfig.php';
    if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['cf']) && !empty($_POST['email']) && !empty($_POST['password']) &&!empty($_POST['confirm_password']) &&!empty($_POST['allow'])){
        session_start();
        $errors= array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        //cf
        $cf = mysqli_real_escape_string($conn, $_POST['cf']);
        $query = "SELECT cf FROM donatori WHERE cf = '$cf'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0){
            $errors[]= "Codice fiscale già registrato";
        }
        
        //password
        if(strlen($_POST['password'])<8){
            $errors[] = "La password deve contenere almeno 8 caratteri";
        }
        //conferma password
        if(strcmp($_POST['password'], $_POST['confirm_password'])!=0){
            $errors[]= "Le password non coincidono";
        } 

        //controllo email
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query = "SELECT mail FROM donatori WHERE mail = '$email'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0){
            $errors[] = "Email già registrata nel database"; 
        }

        if(count($errors)==0){
            //generazione cai
            $cor=false;
            while(!$cor){
                $cai= rand(0, pow(10, 4));
                $query= "SELECT cai from donatori where cai = '$cai'";
                if(mysqli_num_rows(mysqli_query($conn, $query))==0){
                    $cor=true;
                }
            }
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $query = "INSERT INTO donatori(cai, nome, cognome, psw, cf, mail, disp) VALUES($cai, '$name', '$surname', '$password', '$cf', '$email', 'si')";
            if(mysqli_query($conn, $query)){
                $_SESSION['cads_donator'] = $_POST["name"];
                $_SESSION['cads_cai'] = $cai;
                mysqli_close($conn);
                header("Location: don_pers.php");
            }else{
                $error[]= "Errore di connessione al database";
                echo $error[0];
            }
        }

    }
?>

<html>
    <head> 
        <meta charset="utf-8">
        <title>Registrati a Cads</title>
        <link href="https://fonts.googleapis.com/css2?family=Lato&family=Merriweather+Sans&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="head&foot.css">
        <link rel="stylesheet" href="reg.css">
        <script src="signup.js" defer></script>
    </head>
    <body>
        <header>
                <nav>
                    <div id="logo">
                        <div id= "img">
                            <a href="home.php"><img src="Immagini/logo.png" ></a>
                        </div>
                        <a href= "home.php">Cads</a>
                    </div>
                    <a class="buttom" href = "mhw2.html">
                        Trova sedi vicine 
                    </a>
                    <div id="links">
                        <a href="home.php">Home</a>
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
        <section id="f">
            <div id="center">
                <div id="form">
                    <form name='signup' method='post' enctype="multipart/form-data" autocomplete="off">
                        <div class="names">
                            <div class="name">
                                <div><label for='name'>Nome</label></div>
                                <div><input type='text' name='name' <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> ></div>
                                <span class="hide">Inserisci il nome</span>
                            </div>
                            <div class="surname">
                                <div><label for='surname'>Cognome</label></div>
                                <div><input type='text' name='surname' <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?> ></div>
                                <span class="hide">Inserisci il cognome</span>
                            </div>
                        </div>
                        <div class="cf">
                            <div><label for='cf'>Codice fiscale</label></div>
                            <div><input type='text' name='cf' <?php if(isset($_POST["cf"])){echo "value=".$_POST["cf"];} ?>></div>
                            <span class="hide">Codice fiscale già registrato</span>
                        </div>
                        <div class="email">
                            <div><label for='email'>Email</label></div>
                            <div><input type='text' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>></div>
                            <span class="hide">Indirizzo email non valido</span>
                        </div>
                        <div class="password">
                            <div><label for='password'>Password</label></div>
                            <div><input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>></div>
                            <span class ="hide">Inserisci almeno 8 caratteri</span>
                        </div>
                        <div class="confirm_password">
                            <div><label for='confirm_password'>Conferma Password</label></div>
                            <div><input type='password' name='confirm_password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>></div>
                            <span class="hide">Le password non coincidono</span>
                        </div>
                        <div class="allow"> 
                            <div><input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>></div>
                            <div><label for='allow'>Acconsento all'utilizzo dei dati personali</label></div>
                        </div>
                        <div class="submit">
                            <input type='submit' value="Registrati" id="submit" disabled>
                        </div>
                    </form>
                    <div>Hai un account? <a href="login.php">Accedi</a></div>
                </div>
                <img src="Immagini/reg.jpg">
            </div>
        </section>
    </body>
</html>
