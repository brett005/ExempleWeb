<?php
//On démarre la session
session_start();
//require_once le menu déroulant
require_once 'model/menu.php';

//require_once du controller panier, pour avoir accès au montant / affichage
require_once 'controler/panier.php';

//deconnexion
if (!empty($_GET['deco'])){
	session_destroy();
	session_start();
	echo '<script type="text/javascript">';
	echo 'window.location.href="index?page=accueil"';
	echo '</script>';
}

// Creastion de la variable de session message
if(!isset($_SESSION['message'])){
	$_SESSION['message'] ="";
}
 
//On inclut le contrôleur s'il existe et s'il est spécifié
if (!empty($_GET['page']) && is_file('controler/'.$_GET['page'].'.php'))
{
	require_once 'controler/'.$_GET['page'].'.php';
}
else
{
	require_once 'controler/accueil.php';
}
 

