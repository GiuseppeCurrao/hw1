<?php
    require "dbconfig.php";
    session_start();
    if(!isset($_SESSION['cads_pid'])){
        header("Location: login.php");
        exit;
    }


    if(!empty($_POST["coddona"]) && !empty($_POST["malinf"]) && !empty($_POST["valemo"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid=mysqli_real_escape_string($conn, $_SESSION["cads_id"]);
        $codmed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT codmed from medici where cf='$userid'"));
        $c= $codmed["codmed"];
        $coddona=mysqli_real_escape_string($conn, $_POST["coddona"]);
        $malinf=mysqli_real_escape_string($conn, $_POST["malinf"]);
        $valemo=mysqli_real_escape_string($conn, $_POST["valemo"]);
        $cor=false;
         while(!$cor){
            $codana= rand(0, pow(10, 4));
            $query= "SELECT codana from analisi where codana = '$codana'";
            if(mysqli_num_rows(mysqli_query($conn, $query))==0){
                $cor=true;
            }
        }
        $query = "INSERT into analisi(codana, codmed, coddona, malinf,valemo) values($codana, $c, $coddona,'$malinf', $valemo)";
        mysqli_query($conn, $query);
    }

    if(!empty($_POST["cognome"])){

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
    }
?>

<html>
    <head> 
        <meta charset="utf-8">
        <title Associazioni donazioni sangue Currao></title>
        <link href="https://fonts.googleapis.com/css2?family=Lato&family=Merriweather+Sans&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="head&foot.css">
        <link rel="stylesheet" href="dip.css">
        <script src="dip.js" defer></script>
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
                    <a class="buttom" href = "mhw2.html">
                        Trova sedi vicine 
                    </a>
                    <div id="links">
                        <a href="hw1.php">Home</a>
                        <a href = "logout.php">Logout</a>
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
        <section id="main">
            <section id="lato">
                <div class="link" id ="analisi">
                    <a>Carica analisi</a> <img src="Immagini/person.png">
                </div>
                <div class="link" id="Tdip">
                    <a>Cerca dipendente</a> <img src="Immagini/hospital.png">
                </div>
                <div class = "hidden" id = "home"> 
                <a>Home</a> <img src="Immagini/home.png">
                </div>
            </section>
            <section id="centro">
                <div class="dip" id="dip">
                    <h3>Dove lavori</h3>
                    <div id="dati">
                        <div id="Nome">
                        </div>
                        <div id="luogo">
                        </div>
                        <div id="giorno">
                        </div>
                    </div>
                </div>

                <div class="an" id="an">
                    <h3>Carica valori analisi</h3>
                        <form name="Analisi" method= "post">
                            <div class="coddona">
                                <div><label for='coddona'>Codice donazione</label></div>
                                <div><input type='number' name='coddona' <?php if(isset($_POST["coddona"])){echo "value=".$_POST["coddona"];} ?>></div>
                            </div>
                            <div class="malinf">
                                <div><label for='malinf'>Malattie infettive</label></div>
                                <div><input type='text' name='malinf' <?php if(isset($_POST["malinf"])){echo "value=".$_POST["malinf"];} ?>></div>
                            </div>
                            <div class="valemo">
                                <div><label for='valemo'>Valore emoglobina</label></div>
                                <div><input type='number' name='valemo' <?php if(isset($_POST["valemo"])){echo "value=".$_POST["valemo"];} ?>></div>
                            </div>
                            <div>
                                <input type="submit" value="Carica" id="submit"> 
                            </div>
                        </form>
                </div>

                <div class="trova" id="trova">
                    <h3>Cerca un dipendente tramite il suo cognome</h3>
                    <form name="Trova" method= "post">
                            <div class="nome">
                                <div><input type='text' name='cognome' <?php if(isset($_POST["cognome"])){echo "value=".$_POST["cognome"];} ?>></div>
                            </div>
                            <div>
                                <input type="submit" value="Cerca" id="Tsubmit"> 
                            </div>
                            <div id="result">
                                <div id="name"></div>
                                <div id="tel"></div>
                                <div id="type"></div>
                            </div>
                        </form>
                </div>
            </section>
        </section>
    </body>
</html>
