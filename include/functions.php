<?php
//  ------- FONCTION UTILISATEUR AUTHENTIFIE -------
// Fonction permettant de savoir si l'utilisateur est authentifié sur le site.

function userConnected(){
    // Si l'indice 'user" dans le fichier de session n'est pas définit, cela veut dire que l'internaute n'est pas passé par la page connexion et n'est pas authentifié.
    if(isset($_SESSION['user'])) 
        return true;
    else 
        return false; // on retourne false si l'indice 'user' est définit dans la session
}

//  ------- FONCTION ADMINISTRATEUR AUTHENTIFIE -------
// Fonction permettant de savoir si un administrateur est authentifié sur le site.

function adminConnected(){
    // Si l'indice 'roles" dans la session est différent d'admin, cela veut dire que c'est un utilisateur lambda, on retourne false.
    if(userConnected() && $_SESSION['user']['roles'] == 'admin') 
        return true;
    else
        return false; // on retourne false si la session le role est bien 'admin'
}