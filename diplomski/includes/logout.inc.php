<?php
require_once '../csrf/csrf.php';
startSession();
require_once '../csrf/check_csrf.php';
session_unset();
session_destroy();
header("Location: ../index.php");
?>