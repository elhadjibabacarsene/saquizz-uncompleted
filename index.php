<?php 
session_start();

require_once 'config/config.php';
require_once 'controllers/frontend.controllers.php';
require_once 'controllers/backend.controllers.php';

    $page = $_GET['page'];


if(isset($page) && !empty($page)){

    switch($page){
        //On fait appel à la page de connexion
        case "login":getPageConnexion();
        break;

        //On fait appel à la page d'inscription
        case "inscription": getPageInscription();
        break;

        case "dashboard": getPageDashboard();
        break;

        case "jeux": getPageJeux();
        break;

        //On fait appel à la page de connexion par défaut
        default: getPageConnexion();
        break;

    }
}else{
    //On fait appel à la page de connexion si la variable page n'existe pas
    getPageConnexion();
}