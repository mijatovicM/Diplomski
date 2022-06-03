<?php
require_once 'csrf/check_csrf.php';

function postNews() {
    $id = $_GET['id'];

    if (isset($_SESSION['userId'])) {
        $nickname = $_SESSION['userUid'];

        $find = array('idiot', 'kreten', 'moron', 'retard', 'imbecil');
        $replace = array('<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>');

        if (isset($_POST['user_input']) && !empty($_POST['user_input'])) {
            $user_input = $_POST['user_input'];
            $user_input_new = str_ireplace($find, $replace, $user_input);

            $sql = "INSERT INTO comments (nickname,comments,approved,id,timeofcomment) VALUES (?,?,0,?,NOW())";
            $result = $pdo->prepare($sql);
            $result->execute([$nickname, $user_input_new, $id]);

        }
    }
}


function cookieCount($row, $id)
{
    global $pdo;
    $content = $row["cookie_count"];
    $val = $content + 1;
    $sql = "UPDATE news SET cookie_count=? WHERE id=?";
    $result = $pdo->prepare($sql);
    $result->execute([$val, $id]);
    setcookie("count" . $id, $val, time() + 600);
}