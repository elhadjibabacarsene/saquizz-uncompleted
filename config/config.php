<?php

function isAjax(){
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] == 'xmlhttprequest');
}

function checkEmail($email){
    if (preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\ .,;:\s@"]+)*)|(" . +"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email)) {
        return true;
     }
}


//CONSTANTE QUI NOUS PERMET D'ACCEDER A L'URL SOURCE
define("URL", str_replace("index.php", "", (isset($_SERVER["HTTPS"]) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));