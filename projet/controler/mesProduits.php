<?php
//On vérifie que le producteur soit bien connecté pour afficher ses produits
if (isset($_SESSION['id'])){ 
	//On inclut le modèle
	require_once(dirname(__FILE__).'/../model/ProduitManager.php');
	$pm = new ProduitManager();
	if(isset($_GET['delProduit'])){// on supprime des fichier si il faut 
		if( $pm->getIdProById( $_GET['delProduit'] ) == $_SESSION['id'] ){
			$pm ->deleteById($_GET['delProduit']);
			$_SESSION['message'] = "<p>Supression effectuée</p>";
		}
		else{
			$_SESSION['message'] = "<p>Impossible de supprimer le produit</p>";
		}
		//header('Location:./index.php?page=mesProduits');
	}
	//On récupère les produits
	$produits = $pm -> getProduitsByIdPro($_SESSION['id']);
	$categorie = "";
	 
	//On inclut la vue
	require_once(dirname(__FILE__).'/../view/mesProduits.php');
}
else{// si il n'est pas connecter on l'envoie vers la page d'inscription 
	$_SESSION['message'] = "<p>Vous devez avoir un compte pour consulter vos produits</p><button class='inputButtons buttonOverlay' onclick='closeOverlay();''> Ok </button>";
	header('Location:./index.php?page=connexion');
}
?>