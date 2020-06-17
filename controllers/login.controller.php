<?php
session_start();
    require_once '../config/config.php';
    require_once '../models/db.php';
    require_once '../models/user.dao.php';


    if(isset($_SESSION) && !empty($_SESSION)){
        if($_SESSION['statut_user'] === "joueur"){
            header('location:jeux');
        }
        if($_SESSION['statut_user'] === "admin"){
            header('location:dashboard');
        }
    }else{

    $arrayData = array("loginEmail"=>"","password"=>"","loginEmailError"=>"","passwordError"=>"","isSuccess"=>false,"isGood"=>false);
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
           
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
            $arrayData['passwordError'] = "Ce champ est obligatoire";
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
                            
                            $arrayData['redirection'] = "jeux";
                        }
                    }else{
                        $arrayData['loginEmailError'] = "Login(ou email) ou password est incorrect";
                        $arrayData['isSuccess'] = false;
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
                        $arrayData['isSuccess'] = false;
                    }
                    
                }
            }
             
        }
        echo json_encode($arrayData);
        
    }
}
