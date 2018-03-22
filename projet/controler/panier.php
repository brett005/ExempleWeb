<?php
	///////------------Controlleur-------


	//génération du panier
	if(!isset($_SESSION['panier'])){
		$_SESSION['panier'] = array();
		$_SESSION['panier']['id_article'] = array();
		$_SESSION['panier']['quantite'] = array();
		$_SESSION['panier']['livraison'] = array();
	}

	require_once(dirname(__FILE__).'/../model/panier.php');
	require_once(dirname(__FILE__).'/../model/ProduitManager.php');

	if(isset($_GET['delete'])){
		del_article($_GET['delete']);
		header('Location:./index.php?page=panier');
	}

	if(isset($_GET['modifId']) and isset($_GET['quantite'])){
		modif_qte($_GET['modifId'],$_GET['quantite']);
	}

	if(isset($_SESSION['panier'])){
		$montant = montant_panier();
	}

	if(isset($_GET['page']) and $_GET['page'] == 'panier'){
		require_once(dirname(__FILE__).'/../view/panier.php');
	}
	
	//////---------Fin controlleur-----
?>