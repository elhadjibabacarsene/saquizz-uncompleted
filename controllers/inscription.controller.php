<?php
session_start();

require_once '../config/config.php';
require_once '../models/db.php';
require_once '../models/user.dao.php';




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
    //var_dump($_FILES['imageAvatar']);
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
                    $arrayData['imageAvatarError'] = "Seuls les images avec extensions PNG, JPG ou JPEG sont autorisés";
                    $isUploadSuccess = false;
                }
                if ($_FILES['imageAvatar']['size'] > 500000) {
                    $arrayData['imageAvatarError'] = "La taille de l'image ne doit pas dépasser les 500KB";
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
            //echo '<script>alert("Votre compte a été créé avec success ! Vous pouvez vous connecter maintenant et commencer à tester votre culture général")</script>';
        }

    }    
    echo json_encode($arrayData);
}

