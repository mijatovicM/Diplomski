<?php
session_start();
if(isset($_POST['signup-submit'])){

    require '../config/dbconfig.php';
    require_once '../utils/csrf.php';


    $username=$_POST['uid'];
    $email=$_POST['mail'];
    $password=$_POST['pwd'];
    $passwordRepeat=$_POST['pwd-repeat'];
    $captcha=$_POST['captcha'];

    if (!checkCsrf()){
        header('Location: ../signup.php?error=csrfError');
        exit();
    }
    elseif(empty($username) || empty($email) || empty($password) || empty($passwordRepeat)|| empty($captcha)){
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username)){
        header("Location: ../signup.php?error=invalidmailuid");
        exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidmail&uid=".$username);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        header("Location: ../signup.php?error=invaliduid&mail=".$email);
        exit();
    }
    elseif ($password !== $passwordRepeat){
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
        exit();
    }
    elseif (strlen($password) <6){
        header("Location: ../signup.php?error=passwordlength&uid=".$username."&mail=".$email);
        exit();
    }
    else if ($_POST['captcha'] != $_SESSION['digit']) {
        header("Location: ../signup.php?error=captcha");


        session_destroy();
        exit();
    }
    else{
        global $connection;
        $sql="SELECT username FROM users WHERE username=?";
        $result = $pdo->prepare($sql);
        $result->execute([$username]);
        $resultCheck=$result->rowCount();
        if($resultCheck>0){
            header("Location: ../signup.php?error=usertaken&mail=".$email);
            exit();
        }
        else{
            $sql="INSERT INTO users(`username`,`email`,`password`,`type`) VALUES (?,?,?,'korisnik')";

            $hashedPwd=password_hash($password, PASSWORD_DEFAULT);
            $result = $pdo->prepare($sql);
            $result->execute([$username, $email, $hashedPwd]);

            $str = "03565emikmtroimfalsmhgzuxiucqnwdoweo324o0-tkerkm235_214rffhgkl";
            $str = str_shuffle($str);
            $str = substr($str, 0,32);
            $current_path = 'localhost/diplomski/';

            $sql = "UPDATE `users` SET registerToken =? WHERE email = ?";
            $result = $pdo->prepare($sql);
            $result->execute([$str, $email]);

            echo " <div class=\"hashtag\" style=\"margin-top: 20%;height:50vh;\">
            <h1 >Za resetovanje lozinke, kliknite na link koji Vam je poslat na email !
                
            </h1>
        </div>";



              header("Location: ../signup.php?signup=success");
                {
                    $current_path = 'localhost/diplomski/';
                    $to      = $_POST["mail"];
                    $subject = 'Registracija | Verifikacija';
                    $message = '

    Hvala na registraciji!
    Vas nalog je uspesno kreiran, mozete se prijaviti sa dole navedenim podacima nakon aktivacije naloga.

    ------------------------------------
    Korisnicko ime: '.$_POST["uid"].'
    Lozinka: '.$_POST["pwd"].'
    ------------------------------------

    Kliknite na ovaj link kako biste aktivirali svoj nalog:
   
    http://'.$current_path. 'verify.php?email='.$_POST["mail"].'&token='.$str.'';
                    $headers = 'From:izvestavajme@gmail.com' . "\r\n";
                    mail($to, $subject, $message, $headers);
                    echo "Uspesna registracija";
                }

                exit();
        }
    }
}
else{
    header("Location: ../signup.php?");
}
?>