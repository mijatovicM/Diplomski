<?php
require_once 'config/dbconfig.php';
require_once 'csrf/check_csrf.php';
$id = $_GET['delcommm_id'] ?? '';
$sql = "DELETE FROM comments WHERE comments_id=?";
$result = $pdo->prepare($sql);
$result->execute([$id]);
header('Location: commented.php?csrfToken='.generateCsrfToken());