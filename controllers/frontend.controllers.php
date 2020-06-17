<?php

require_once 'config/config.php';

require_once 'models/user.dao.php';

require_once 'models/db.php';

function getPageTest()
{
    require_once 'models/test.php';
}

/**
 * fonction qui fait appel à la page de connexion
 */
function getPageConnexion()
{

    if(isset($_SESSION) && !empty($_SESSION)){
        
        if($_SESSION['statut_user'] === "joueur"){
            echo "<script>location.replace('jeux');</script>";
        }
        if($_SESSION['statut_user'] === "admin"){
            echo "<script>location.replace('admin');</script>";
        }
    }else{

        $arrayData = array("loginEmail"=>"","password"=>"","loginEmailError"=>"","passwordError"=>"","redirection"=>"",
        "isSuccess"=>false, "isGood"=>false);       
       
        if ($_SERVER['REQUEST_METHOD'] === "POST"){
                 //On attend donc une authentification s'il n'y a pas de SESSION en cours
        
            //var_dump($_POST);
            
            $arrayData['loginEmail'] = $_POST['loginEmail'];
            $arrayData['password'] = $_POST['password'];
            $arrayData['isSuccess'] = true;
            $arrayData['isGood'] = false;
            //var_dump($arrayData);

            //var_dump("$arrayData");
            //On contrôle si les champs sont vides
            if (empty($arrayData['loginEmail'])) {
                $arrayData['loginEmailError'] = "Ce champs est obligatoire";
                $arrayData['isSuccess'] = false;
            }
            if (empty($arrayData['password'])) {
                $arrayData['passwordError'] = "Ce champs est obligatoire";
                $arrayData['isSuccess'] = false;
            }
            
            //S'il n'y pas d'erreur
            if ($arrayData['isSuccess']) {
                //On vérifie si le user a saisi un email
                if (checkEmail($arrayData['loginEmail'])) {
                    //On récupère les infos de l'utilisateur dans un tableau
                    $rslt_infos = getAllInfosUserByEmail($arrayData['loginEmail']);
                    $users_infos = $rslt_infos[0];
                    if (!$rslt_infos) {
                        $arrayData['loginEmailError'] = "Login(ou email) ou password est incorrect";
                    } else {
                        $isPasswordCorrect = password_verify($arrayData['password'], $users_infos['password_user']);
                        if ($isPasswordCorrect) {
                            $arrayData['isGood'] = true;
                            $_SESSION['id_user'] = $users_infos['id_user'];
                            $_SESSION['prenom_user'] = $users_infos['prenom_user'];
                            $_SESSION['nom_user'] = $users_infos['nom_user'];
                            $_SESSION['login_user'] = $users_infos['login_user'];
                            $_SESSION['email_user'] = $users_infos['email_user'];
                            $_SESSION['avatar_user'] = $users_infos['avatar_user'];
                            //Si le user est un admin
                            if ($users_infos['statut_user'] === "admin") {
                                $_SESSION['statut_user'] = "admin";
                                
                                $arrayData['redirection'] = "dashboard";
                            }
                            //Si le user est un joueur
                            if ($users_infos['statut_user'] === "joueur") {
                                $_SESSION['statut_user'] = "joueur";
                               
                                $arrayData['redirection'] = "joueur";
                            }
                        }else{
                            $arrayData['loginEmailError'] = "Login(ou email) ou password est incorrect";
                        }
                    }
                } else {
                    //On récupère les infos de l'utilisateur dans un tableau
                    $infos = getAllInfosUserByLogin($arrayData['loginEmail']);
                    $users_infos = $infos[0];
                    
                    if(!$users_infos){
                        $arrayData['loginEmailError'] = "Login(ou email) ou password est incorrect";
                    }else{
                        $isPasswordCorrect = password_verify($arrayData['password'], $users_infos['password_user']);
                        
                        if($isPasswordCorrect){
                            $arrayData['isGood'] = true;
                            $_SESSION['id_user'] = $users_infos['id_user'];
                            $_SESSION['prenom_user'] = $users_infos['prenom_user'];
                            $_SESSION['nom_user'] = $users_infos['nom_user'];
                            $_SESSION['login_user'] = $users_infos['login_user'];
                            $_SESSION['email_user'] = $users_infos['email_user'];
                            $_SESSION['avatar_user'] = $users_infos['avatar_user'];
                            //Si le user est un admin
                            if ($users_infos['statut_user'] === "admin") {
                                $_SESSION['statut_user'] = "admin";
                            
                                $arrayData['redirection'] = "dashboard";
                            }
                            //Si le user est un joueur
                            if ($users_infos['statut_user'] === "joueur") {
                                $_SESSION['statut_user'] = "joueur";
                    
                                $arrayData['redirection'] = "jeux";
                            }
                        }else{
                            $arrayData['loginEmailError'] = "Login(ou email) ou password est incorrect";
                        }
                        
                    }
                }
                 
            }
            
            echo json_encode($arrayData);
        }

    }
        //var_dump($arrayData);

        
        require_once 'views/frontend/authentification.view.php';
        
}

/**
 * fonction qui fait appel à la page d'inscription
 */
function getPageInscription()
{
    
    $title = 'S\'inscrire';

$arrayData = array("prenom"=>"","nom"=>"","login"=>"","email"=>"","password"=>"","confirmerPassword"=>"","imageAvatar"=>"",
    "prenomError"=>"","nomError"=>"","loginError"=>"","emailError"=>"","passwordError"=>"","confirmerPasswordError"=>"",
    "imageAvatarError"=>"","isSuccess"=>false,"isGood"=>false
);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $arrayData["prenom"] = $_POST['prenom'];
    $arrayData["nom"] = $_POST['nom'];
    $arrayData["login"] = $_POST['login'];
    $arrayData["email"] = $_POST['email'];
    $arrayData["password"] = $_POST['password'];
    $arrayData["confirmerPassword"] = $_POST['confirmerPassword'];
    $arrayData["imageAvatar"] = $_FILES['imageAvatar']['name'];
    $statut = "joueur";
    $arrayData["isSuccess"] = true;

    //Email checked
    if (!preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\ .,;:\s@"]+)*)|(" . +"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $arrayData["email"])) {
        $arrayData["emailError"] = "L'email est invalide";
        $arrayData["isSuccess"] = false;
    }


    //Password matchs
    if ($arrayData["password"] !== $arrayData["confirmerPassword"]) {
        $arrayData["confirmerPasswordError"] = "Les deux mots de pass ne correspondent pas";
        $arrayData["isSuccess"] = false;
    }

    //CheckLenght Login
    if (strlen(trim($arrayData["login"])) < 5) {
        $arrayData["loginError"] = "Le login ne doit pas être inférieur à 5";
        $arrayData["isSuccess"] = false;
    }
    if (strlen(trim($arrayData["login"])) > 8) {
        $arrayData["loginError"] = "Le login ne doit pas être supérieur à 8";
        $arrayData["isSuccess"] = false;
    }
    //CheckLenght Password
    if (strlen(trim($arrayData["password"])) < 4) {
        $arrayData["passwordError"] = "Le mot de pass ne doit pas être inférieur à 4";
        $arrayData["isSuccess"] = false;
    }
    if (strlen(trim($arrayData["password"])) > 20) {
        $arrayData["passwordError"] = "Le mot de pass ne doit pas être inférieur à 20";
        $arrayData["isSuccess"] = false;
    }

    //On gère la validation serveur de nos images
        $image = $_FILES['imageAvatar']['name'];
        $urlAvatarDirectory = 'public/source/images/avatars/';
        //On définit le lien de destination de l'image
        $imagePath = $urlAvatarDirectory . basename($image);
        //On récupère l'extension de l'image envoyée
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        //Tableau des extensions
        $tabExtension = ['png', 'jpg', 'jpeg'];

        $isUploadSuccess = false;
        $isUploadLoading = true;

        if (empty($image)) {
            $isUploadSuccess = true;
            $avatar = "avatar-default.png";
        } else {
                $isUploadSuccess = true;
                if (!in_array($imageExtension, $tabExtension)) {
                    $imageAvatarError = "Seuls les images avec extensions PNG, JPG ou JPEG sont autorisés";
                    $isUploadSuccess = false;
                }
                if ($_FILES['imageAvatar']['size'] > 500000) {
                    $imageAvatarError = "La taille de l'image ne doit pas dépasser les 500KB";
                    $isUploadSuccess = false;
                }
            }

    //Inoput checked
    if (empty($arrayData["prenom"])) {
        $arrayData["prenomError"] = "Ce champs est obligatoire";
        $arrayData["isSuccess"] = false;
    }
    if (empty($arrayData["nom"])) {
        $arrayData["nomError"] = "Ce champs est obligatoire";
        $arrayData["isSuccess"] = false;
    }

    if (empty($arrayData["login"])) {
        $arrayData["loginError"] = "Ce champs est obligatoire";
        $arrayData["isSuccess"] = false;
    }
    if (empty($arrayData["email"])) {
        $arrayData["emailError"] = "Ce champs est obligatoire";
        $arrayData["isSuccess"] = false;
    }
    if (empty($arrayData["password"])) {
        $arrayData["passwordError"] = "Ce champs est obligatoire";
        $arrayData["isSuccess"] = false;
    }
    if (empty($arrayData["confirmerPassword"])) {
        $arrayData["confirmerPasswordError"] = "Ce champs est obligatoire";
        $arrayData["isSuccess"] = false;
    }

    if((int)countUserBySearch("users","login_user",$arrayData["login"]) !== 0){
        $arrayData["loginError"] = "Ce login existe déjà";
        $arrayData["isSuccess"] = false;
    }

    if((int)countUserBySearch("users","email_user",$arrayData["email"]) !== 0){
        $arrayData["emailError"] = "Ce email est déjà utilisé";
        $arrayData["isSuccess"] = false;
    }

    if ($arrayData["isSuccess"]) {
        if($isUploadSuccess){
            $arrayData["password"] = password_hash($arrayData["password"],PASSWORD_DEFAULT);
            createNewUser($arrayData["prenom"], $arrayData["nom"], $arrayData["login"], $arrayData["email"], $arrayData["password"], $avatar, $statut);
            $arrayData['isGood'] = true;
        }

        
    }
    echo json_encode($arrayData);
}
   
    require_once 'views/frontend/authentification.view.php'; 
}



function getPageDashboard()
{
    $title = "Dashboard";

    if(isset($_SESSION) && !empty($_SESSION)){
        
        if($_SESSION['statut_user'] !== "admin"){
            echo "<script>location.replace('jeux');</script>";
        }else{
            if (isset($_POST['deconnexion'])) {
                session_destroy();
                echo "<script>location.replace('login');</script>";
            }
            require_once 'views/backend/dashbord.view.php';
        }
}
}

function getPageJeux()
{
    $title = "Jeux";

    if (isset($_POST['deconnexion'])) {
        session_destroy();
        echo "<script>location.replace('login');</script>";
    }

    require_once 'views/frontend/jeux.view.php';
}