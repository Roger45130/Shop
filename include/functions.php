<?php
//  ------- FONCTION UTILISATEUR AUTHENTIFIE -------
// Fonction permettant de savoir si l'utilisateur est authentifié sur le site.

function userConnected()
{
    // Si l'indice 'user" dans le fichier de session n'est pas définit, cela veut dire que l'internaute n'est pas passé par la page connexion et n'est pas authentifié.
    if (isset($_SESSION['user']))
        return true;
    else
        return false; // on retourne false si l'indice 'user' est définit dans la session
}

//  ------- FONCTION ADMINISTRATEUR AUTHENTIFIE -------
// Fonction permettant de savoir si un administrateur est authentifié sur le site.

function adminConnected()
{
    // Si l'indice 'roles" dans la session est différent d'admin, cela veut dire que c'est un utilisateur lambda, on retourne false.
    if (userConnected() && $_SESSION['user']['roles'] == 'admin')
        return true;
    else
        return false; // on retourne false si la session le role est bien 'admin'
}

//  ------- FONCTION CREATION PANIER SESSION -------
function createCart()
{
    if (!isset($_SESSION['cart'])) {
        //  Si l'indice 'cart' n'est pas définit dans la session de l'utilisateur, cela veut dire que l'utilisateur n'a ajouté aucun produit dans le panier, alors on crée les différents tableaux dans la session.
        $_SESSION['cart'] = [];
        $_SESSION['cart']['id_product'] = [];
        $_SESSION['cart']['title'] = [];
        $_SESSION['cart']['picture'] = [];
        $_SESSION['cart']['reference'] = [];
        $_SESSION['cart']['quantity'] = [];
        $_SESSION['cart']['price'] = [];
    }
}

//  ------- FONCTION AJOUTER PRODUIT DANS LE PANIER SESSION -------
function addProductToCart($id_product, $title, $picture, $reference, $quantity, $price)
{
    createCart(); //    On contrôle si le panier exite ou non dans la session.

    //  On contrôle si id_produit que l'on tente d'ajouter dans la session panier existe déjà.
    $positionProduct = array_search($id_product, $_SESSION['cart']['id_product']);
    // var_dump($positionProduct);

    //  Si la valeur de $positionProduct est différent de false, cela veut dire que l'id_product existe dans le panier, on modifie seulement la quantité du produit.
    if ($positionProduct !== false) {
        $_SESSION['cart']['quantity'][$positionProduct] += $quantity;
    } else {
        //  Sinon l'id n'est pas dans la session, on crée une nouvelle ligne dans le panier.
        //  Les [] vide oremettent de créer des indices numérique dans les tableau Array.
        $_SESSION['cart']['id_product'][] = $id_product;
        $_SESSION['cart']['title'][] = $title;
        $_SESSION['cart']['picture'][] = $picture;
        $_SESSION['cart']['reference'][] = $reference;
        $_SESSION['cart']['quantity'][] = $quantity;
        $_SESSION['cart']['price'][] = $price;
    }
}

//  ------- FONCTION SUPPRESSION ARTICLE DU PANIER -------
function removeProductToCart($id_product)
{
    // On recherche a quel indice se trouve l'id du produit a supprimé dans la session en passant par le tableau Array $_SESSION['cart']['id_product']
    $positionProduct = array_search($id_product, $_SESSION['cart']['id_product']);
    // var_dump($positionProduct);

    if ($positionProduct !== false) {
        // La fonction prédér=finie array_splice permet de supprimer un élément dans un array à un indice correspondant et elle remonte les indices inférieur vers les indice supérieur, si je supprime le produit à l'indice [2] du tableau Array, le produit à l'indice [3] remonte à l'indice [2].
        array_splice($_SESSION['cart']['id_product'], $positionProduct, 1);
        array_splice($_SESSION['cart']['title'], $positionProduct, 1);
        array_splice($_SESSION['cart']['picture'], $positionProduct, 1);
        array_splice($_SESSION['cart']['reference'], $positionProduct, 1);
        array_splice($_SESSION['cart']['quantity'], $positionProduct, 1);
        array_splice($_SESSION['cart']['price'], $positionProduct, 1);
    }
}


//  ------- FONCTION CALCUL MONTANT TOTAL DU PANIER -------
function totalAmount()
{
    $total = 0;
    for ($i = 0; $i < count($_SESSION['cart']['id_product']); $i++) {
        $total += $_SESSION['cart']['quantity'][$i] * $_SESSION['cart']['price'][$i];
    }
    return round($total, 2);
}


//  ------- FONCTION LIENS ACTIFS NAV -------
function activeLink($url)
{
    if ($_SERVER['PHP_SELF'] == $url)
        echo ' active';
}