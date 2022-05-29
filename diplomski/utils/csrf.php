<?php
function createCsrf(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['csrfToken'] = bin2hex(random_bytes('32'));
    ?>
    <div class="input-group">
        <input type="hidden" class="form-control"  name="csrfToken" value="<?=$_SESSION['csrfToken'] ?? ''?>"/>
    </div>
<?php
}

function checkCsrf(){
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $currentLink = $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if (!$token || $token !== $_SESSION['token']) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        echo '<script>location.replace("'.strtok($currentLink, '?')[0].'&error=csrfError");</script>';
    }

    return true;
}
