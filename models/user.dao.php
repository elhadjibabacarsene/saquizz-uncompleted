<?php
//var_dump($bdd);
/**
 * fonction qui me permet de récupérer les informations d'un utilisateur à partir du login
 * @param $login string
 * @param $password string
 * @return array
 */
function getAllInfosUserByLogin($login)
{
    global $bdd;
    $req = '
            SELECT * FROM users
            WHERE login_user = :login
           ';
    $stmt = $bdd->prepare($req);
    $stmt->bindValue(":login", $login, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $user;
}

/**
 * fonction qui me permet de récupérer les informations d'un utilisateur à partir de l'email
 * @param $login string
 * @param $password string
 * @return array
 */
function getAllInfosUserByEmail($email)
{
    global $bdd;
    $req = '
            SELECT * FROM users
            WHERE email_user = :email
            ';
    $stmt = $bdd->prepare($req);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $user;
}



function createNewUser($prenom, $nom, $login, $email, $password, $avatar, $statut)
{
    $req = '
            INSERT INTO users
            (`prenom_user`, `nom_user`, `login_user`, `email_user`, `password_user`, `avatar_user`, `statut_user`)
            VALUES (:prenom, :nom, :login, :email, :password, :avatar, :statut)
    ';
    global $bdd;
    $stmt = $bdd->prepare($req);
    $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
    $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
    $stmt->bindValue(":login", $login, PDO::PARAM_STR);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->bindValue(":password", $password, PDO::PARAM_STR);
    $stmt->bindValue(":avatar", $avatar, PDO::PARAM_STR);
    $stmt->bindValue(":statut", $statut, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
}


function countUserBySearch($table,$table_column,$element_search){
    $req = "
            SELECT COUNT(id_user) FROM ".$table." WHERE ".$table_column."=:element_search
    ";
    global $bdd;
    $stmt = $bdd->prepare($req);
    $stmt->bindValue(":element_search",$element_search,PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $count[0]["COUNT(id_user)"];
}