<?php
require_once 'config/dbconfig.php';
require_once 'includes/utils.php';
require_once 'csrf/check_csrf.php';
//require_once 'csrf/csrf.php';
$id = $_POST['news_id'] ?? '';

startSession();
if (isset($_SESSION['userId']) and (int)$id) {
    $nickname = $_SESSION['userUid'];
    if (isset($_POST['user_input']) && !empty($_POST['user_input'])) {
        $user_input = $_POST['user_input'];

        $sql = "INSERT INTO comments (nickname,comments,approved,id,timeofcomment) VALUES (?,?,1,?,NOW())";
        $result = $pdo->prepare($sql);
        $comment_message = checkUserInput($user_input);
        var_dump($comment_message);
        if (!$comment_message){
          if (!$result->execute([$nickname, $user_input, $id])) die($result->errorInfo());
        }
        $comment_message = $comment_message ? $comment_message : 'success';
        header("Location: news.php?comment=$comment_message&id=$id");

    }
}
else header("Location: news.php?comment=notlogged&id=$id");
