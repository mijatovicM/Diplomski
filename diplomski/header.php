<?php
$nonce = $nonce ?? '';
require_once 'csrf/csrf.php';
startSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="izvestavaj.me je novinarski portal koji Vas izveštava o najnovijim dešavanjima u svetu i regionu.">
    <meta name="keywords" content="novine, novinarski portal, dešsavanja u svetu,vesti iz sveta, vesti iz regiona, vesti iz politike, zabavne vesti, vesti o poznatima, sportske vesti,vesti,izvestavanja, dnevne vesti, najnovije vesti ">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content=izvestavaj.me>
    <script src="src/bootstrap/js/jquery-3.3.1.min.js"></script>
    <link href="src/css/header.css" rel="stylesheet" type="text/css">
    <?php
    require_once 'csrf/csrf_javascript.php'
    ?>
</head>
<body>
<!--NAVBAR-->
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php"><img src="src/images/iLogo.jpg" height="50px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav nav-fill w-100">
            <li class="nav-item">
                <a class="nav-link" id="index" href="index.php">VESTI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="srbija" href="srbija.php">SRBIJA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="poznati" href="poznati.php">POZNATI</a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" id="zabava" href="zabava.php">ZABAVA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="svet" href="svet.php">SVET</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" id="sport" href="sport.php">SPORT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="politika" href="politika.php">POLITIKA</a>
            </li>
            <li class="nav-item">


                <div class="dropdown">
                    <?php
                    if(isset($_SESSION['userId'])){
                    echo '<i onclick="myFunction()"  class="fas fa-user-circle dropbtn nav-link glow header0"></i>';
                    echo'<div id="myDropdown" class="dropdown-content dropdown-menu-right">';
                    }
                    else{
                        echo'<i onclick="myFunction()"  class="fas fa-user-circle dropbtn nav-link header1"></i>';
                        echo'<div id="myDropdown" class="dropdown-content dropdown-menu-right">';
                    }
                    ?>


                        <?php
                    if(isset($_SESSION['userId'])  && $_SESSION['userType'] == 'redakcija'){

                        echo '<div class="header2"><a href="admin/index.php">Redakcija</a></div>
                    <hr class="header3"/>';

                        echo '<div class="header2"><a href="commented.php">Komentarisane vesti</a></div>
                    <hr class="header3"/>';
                        echo '<div class="header2"><a href="changeinfo.php">Izmenite informacije o sebi</a></div>
         
                    <hr class="header3"/>';



                    }
                    elseif(isset($_SESSION['userId'])  && $_SESSION['userType'] == 'urednik'){


                        echo '<div class="loggedInMessageDiv header8"><p class="loggedInMessage">Urednik: '.$_SESSION['userUid']. '</p></div><hr class="header3"/>';

                        echo '<div class="header2"><a href="commented.php">Komentarisane vesti</a></div>
                    <hr class="header3"/>
                    <div class="header2"><a href="changeinfo.php">Izmenite informacije o sebi</a></div>
                    

                    <hr class="header3"/>';


                    }
                        elseif(isset($_SESSION['userId'])){


                            echo '<div class="loggedInMessageDiv header8"><p class="loggedInMessage">Korisnik: '.$_SESSION['userUid']. '</p></div><hr class="header3"/>';

                            echo '<div class="header2"><a href="commented.php">Komentarisane vesti</a></div>
                    
                    <hr class="header3"/>;
                    <div class="header2"><a href="changeinfo.php">Izmenite informacije o sebi</a></div>
                  
                    
                    <hr class="header3"/>';
                        }


                        ?>




                    <?php
                    if(isset($_SESSION['userId'])){
                        echo ' <form action="includes/logout.inc.php" method="post">
 <div class="logoutdiv">
 
            <button type="submit" name="logout-submit" class="btn btn-danger header20">Odjavi se</button></div>'.simplePostCsrf().'</form>';
                    }
                    else{
                        echo '<form action="includes/login.inc.php" method="post" class="header21">
               <br/>
            <input type="text" class="loginInput" name="mailuid" placeholder="Korisničko ime...">
            '.simplePostCsrf().'
            <br/> <br/>

            <input type="password" class="loginInput" name="pwd" placeholder="Lozinka...">
                        <br/><br/>

            <button type="submit" name="login-submit" class="btn btn-primary">Prijava</button>
                        <br/><br/>
                        
<a href="signup.php" class="reg header22">Registruj se</a>
    <a href="forgotpassword/forgot.php" class="header22"><span>Zaboravljena lozinka?</span></a>

        </form>';

                    }
                    ?>
                    </div>
                </div>

                <script nonce="<?=$nonce?>">
                    /* When the user clicks on the button,
                    toggle between hiding and showing the dropdown content */
                    function myFunction() {
                        document.getElementById("myDropdown").classList.toggle("show");
                    }

                    // Close the dropdown if the user clicks outside of it
                    window.onclick = function(event) {
                        if (!event.target.matches('.dropbtn')) {

                            var dropdowns = document.getElementsByClassName("dropdown-content");
                            var i;
                            for (i = 0; i < dropdowns.length; i++) {
                                var openDropdown = dropdowns[i];
                                if (openDropdown.classList.contains('show')) {
                                    openDropdown.classList.remove('show');
                                }
                            }
                        }
                    }
                </script>
            </li>
        </ul>
    </div>
</nav>
<!--END OF NAVBAR-->

</body>
</html>
<?php
if(isset($_GET['error'])) {
    if ($_GET['error'] == "csrfError") {
        echo "<div class='errordiv'>Forma nije submitovana na odgovarajući način</div>";
    }
}
