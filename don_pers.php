<?php
    require "dbconfig.php";
    session_start();
        if(!isset($_SESSION['cads_id'])){
        header("Location: login.php");
        exit;
    }


    if(!empty($_POST["telefono"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid=mysqli_real_escape_string($conn, $_SESSION["cads_id"]);
        $tel = $_POST["telefono"];
        $query = "UPDATE donatori SET telefono = '$tel' where cai = '$userid'";
        mysqli_query($conn, $query);
    }
    if(!empty($_POST["data"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid=mysqli_real_escape_string($conn, $_SESSION["cads_id"]);
        $data = mysqli_real_escape_string($conn, $_POST["data"]);
        $query = "UPDATE donatori SET dataNascita='$data' where cai = '$userid'";
        mysqli_query($conn, $query);
    }

    if(!empty($_POST["città"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid=mysqli_real_escape_string($conn, $_SESSION["cads_id"]);
        $città = mysqli_real_escape_string($conn, $_POST["città"]);
        $query = "UPDATE donatori SET citta='$città' where cai = '$userid'";
        mysqli_query($conn, $query);
    }
    if(!empty($_POST["via"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid=mysqli_real_escape_string($conn, $_SESSION["cads_id"]);
        $via = mysqli_real_escape_string($conn, $_POST["via"]);
        $query = "UPDATE donatori SET via='$via' where cai = '$userid'";
        mysqli_query($conn, $query);
    }
    if(!empty($_POST["peso"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid=mysqli_real_escape_string($conn, $_SESSION["cads_id"]);
        $peso = mysqli_real_escape_string($conn, $_POST["peso"]);
        $query = "UPDATE donatori SET peso='$peso' where cai = '$userid'";
        mysqli_query($conn, $query);
    }

    if(!empty($_POST["ndata"])){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $_SESSION["cads_id"]);
        $data = $_POST["ndata"];
        $nome = $_POST["sede"];
        $res = mysqli_query($conn, "SELECT disp from donatori where cai = $userid");
        $disp= mysqli_fetch_assoc($res);
        if(($data>date("Y-m-d")) && (strcmp($disp["disp"], "no")!==0)){
            echo "c";
            $cor=false;
            while(!$cor){
                $codpren= rand(0, pow(10, 4));
                $query= "SELECT codpren from prenotazione where codpren = '$codpren'";
                if(mysqli_num_rows(mysqli_query($conn, $query))==0){
                    $cor=true;
                }
            }
            $query = "INSERT INTO prenotazione(codpren, cai, data, codsede) values($codpren, '$userid', '$data', '$nome')";
            mysqli_query($conn, $query);
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
        <link rel="stylesheet" href="pers.css">
        <script src="don.js" defer></script>
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
                <div class="link" id ="mdati">
                    <a>Modifica informazioni personali</a> <img src="Immagini/person.png">
                </div>
                <div class="link" id="pren">
                    <a>Prenota una donazione</a> <img src="Immagini/hospital.png">
                </div>
                <div class = "hidden" id = "home"> 
                <a>Home</a> <img src="Immagini/home.png">
                </div>
            </section>
            <section id="centro">
                <div class="don" id="don">
                    <h3>Donazioni effettuate</h3>
                    <div id= "cal">
                     <div id="tipo">
                     </div>
                     <div id="quantità">
                     </div>
                     <div id="data">
                     </div>
                     <div id="città">
                     </div>
                    </div>
                </div>

                <div class ="prenotazione hidden" id="prenotazione">
                    <div id=mpren>
                        <h3>Le tue prenotazioni</h3>
                        <div id="mypren">
                            <div id="codice">
                            </div>
                            <div id="pcittà">
                            </div>
                            <div id="pdata">
                            </div>
                        </div>
                    </div>
                    <div id="fpren">
                        <h3>Prenota una donazione</h3>
                        <div id = "effpren"></div>
                    </div>
                </div>
                <div class="form hidden" id= "form">
                    <h3>Modifica i tuoi dati personali</h3>
                    <form name="modificaDati" method= "post">
                        <div class="telefono">
                            <div><label for='telefono'>Telefono</label></div>
                            <div><input type='number' name='telefono' <?php if(isset($_POST["telefono"])){echo "value=".$_POST["telefono"];} ?>></div>
                            <span class="hide">Inserisci un numero valido</span>
                        </div>
                        <div class="data">
                            <div><label for='data'>Data di nascita</label></div>
                            <div><input type='date' name='data' <?php if(isset($_POST["data"])){echo "value=".$_POST["data"];} ?>></div>
                            <span class="hide">Inserisci una data valida</span>
                        </div>
                        <div class="città">
                            <div><label for='città'>Città</label></div>
                            <div><input type='text' name='città' <?php if(isset($_POST["città"])){echo "value=".$_POST["città"];} ?>></div>
                            <span class="hide">Inserisci una città valida</span>
                        </div>
                        <div class="via">
                            <div><label for='via'>Via/piazza</label></div>
                            <div><input type='text' name='via' <?php if(isset($_POST["via"])){echo "value=".$_POST["via"];} ?>></div>
                            <span class="hide">Inserisci una via valida</span>
                        </div>
                        <div class="peso">
                            <div><label for='peso'>Peso</label></div>
                            <div><input type='text' name='peso' <?php if(isset($_POST["peso"])){echo "value=".$_POST["peso"];} ?>></div>
                            <span class="hide">Inserisci un peso valido</span>
                        </div>
                        <div>
                            <input type="submit" value="Salva i nuovi dati" id="submit"> 
                        </div>
                    </form>
                </div>
            </section>
        </section>
        <footer>
            <address>Currao Giuseppe - 1000007919</address>
            <h1>Progetto di WebProgramming</h1>
        </footer>
    </body>
</html>
