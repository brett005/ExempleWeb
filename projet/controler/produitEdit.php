<?php
//On vérifie que le producteur soit bien connecté pour ajouter des produits
if (isset($_SESSION['id'])){ 
	//On inclut la vue
	require_once(dirname(__FILE__).'/../view/ProduitEdit.php');
}
else{// si il n'est pas connecter on l'envoie vers la page de connexion
	header('Location:../controler/connexion.php');
}
?>