<?php
require_once '../csrf/check_csrf.php';
if(isset($_POST['login-submit'])) {
    require '../config/dbconfig.php';

    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];
    if (empty($mailuid) || empty($password)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    } else {
        global $connection;
        $sql = "SELECT * FROM users WHERE username=?;";
        $result = $pdo->prepare($sql);
        $result->execute([$mailuid]);
        if ($row = $result->fetch()) {
            $pwdCheck = password_verify($password, $row['password']);
            if ($pwdCheck == false) {
                header("Location: ../index.php?error=wrongpassword");
                exit();
            }
            if ($row['Status'] == 'inactive') {
                header("Location: ../index.php?error=inactive");
                exit();
            } elseif ($pwdCheck == true) {
                startSession();
                $_SESSION['userId'] = $row['users_id'];
                $_SESSION['userUid'] = $row['username'];
                $_SESSION['userType'] = $row['type'];


                header("Location: ../index.php?login=success");
                exit();

            } else {
                header("Location: ../index.php?error=wrongpassword");
                exit();
            }
        } else {
            header("Location: ../index.php?error=nouser");
            exit();
        }
    }
}
else{
    header("Location: ../index.php?");
exit();
}
?>