<?php
define('REPLACE', array('<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>', '<b>*cenzurisano*</b>'));
define('PROFANITIES',array('idiot', 'kreten', 'moron', ' retard ', 'imbecil'));
define('CURRENT_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

function checkUserInput($input, $find=PROFANITIES, $replace=REPLACE){
    if ($input !== strip_tags($input)) return 'html_detected';
    if ($input !== str_ireplace($find, $replace, $input)) return 'prfanity_detected';
    return '';
}

function url($url=CURRENT_URL){
    $query = parse_url($url, PHP_URL_QUERY);

    if ($query) {
        return CURRENT_URL.'&';
    }
    return CURRENT_URL.'?';
}
