<?php
require_once 'csrf/csrf.php';
startSession();
require_once 'csrf/check_csrf.php';
$userid=$_SESSION['userId'];
$username= $_SESSION['userUid'];
$news_id=$_GET['likenews_id'];

include_once("config/dbconfig.php");
global $connection;
# dodati proveru da li postoji vise korisnika sa istim lajkom
# script name u headeru ime fa
$sql = "INSERT INTO liked_news(users_id,username,id) VALUES (?, ?, ?)";

$result = $pdo->prepare($sql);
!$result->execute([$userid, $username, $news_id]) ? die($result->errorInfo()) : false;


if($result->rowCount() > 0) {

    header("Location: news.php?id=$news_id&csrfToken=".generateCsrfToken());
}

?>