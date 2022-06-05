<?php
function startSession(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function generateCsrfToken(){
    if (!isset($_SESSION['csrfToken'])){
        $_SESSION['csrfToken'] = bin2hex(random_bytes('32'));
    }
    return $_SESSION['csrfToken'];
}

function postCsrf(){
    ?>
    <div class="input-group">
        <input type="hidden" class="form-control"  name="csrfToken" value="<?=generateCsrfToken()?>"/>
    </div>
<?php
}

function simplePostCsrf(){
    return '<input type="hidden" name="csrfToken" value="'.generateCsrfToken().'">';
}

function checkCsrf($silent=false){
    startSession();

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $token = $_POST['csrfToken'] ?? '';
    } else {
        $token = $_GET['csrfToken'] ?? '';
    }
//    $currentLink = $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if (!isset($_SESSION['csrfToken']) || !$token || $token !== $_SESSION['csrfToken']) {
//        echo '<script>location.replace("'.strtok($currentLink, '?')[0].'&error=csrfError");</script>';
        if (!$silent){
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            die('CSRF token nije odgovarajući<br>'.__FILE__);
        } else {
            return false;
        }
    } else {
        unset($_SESSION['csrfToken']);
    }
    return true;
}

function getCsrf(){
    return '?csrfToken='.generateCsrfToken();
}

startSession();