<?php
//  ------- CONNEXION BDD -------
$connect_db = new PDO('mysql:host=localhost;dbname=shop', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);

//  ------- CONNEXION BDD -------
session_start();

//  ------- CHEMIN -------
define('RACINE_SITE', $_SERVER['DOCUMENT_ROOT'] . '/php/shop/');
// echo '<pre>'; print_r(RACINE_SITE); '<pre>';
//  Cette constante retourne le chemin physique du dossier htdocs sur le serveur, de notre dossier 'shop' sur le serveur.
//  Lors de l'enregistrement d'iimage/photos, nous aurons besoin du chemin complet dossier images pour enregistrer la photo.
// echo RACINE_SITE . 'shop/assets/images/product.jpg';

define("URL", "http://localhost/php/shop/");
//  Cette constante servira à enregistré l'URL d'une photo/image dans la BDD, on ne peut pas conservé la photo physiquement dans la BDD, donc on définit une URL vers le bon dossier.

//  ------- VARIABLES -------
$content ='';

//  ------- FAILLE XSS -------
foreach($_POST as $key => $value){
    $_POST[$key] = htmlentities(addslashes(trim($value)));
}

foreach($_GET as $key => $value){
    $_GET[$key] = htmlentities(addslashes(trim($value)));
}
// trim() :  fonction prédéfinie qui supprime les espaces en début et fin de la chaine de caactères

//  ------- INCLUSIONS FONCTIONS -------
require_once("functions.php");
