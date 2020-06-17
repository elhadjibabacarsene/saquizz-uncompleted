<?php

const HOST_NAME = "localhost";
const DATABASE_NAME = "saquizz";
const USERNAME = "root";
const PASSWORD = "Louysablem2019!";


    try {
        $bdd = new PDO('mysql:host=' . HOST_NAME . ';dbname=' . DATABASE_NAME . ';charset=utf8', USERNAME
            , PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } catch (PDOException $e) {
        //$message = "Erreur PDO avec le message: " . $e->getMessage();
        die("Une erreur est survenue lors de la connexion à la base de donnée. Veuillez contacter l'administrateur au 78 149 92 06");
    }


    