<?php
	require_once(dirname(__FILE__).'/../model/ProduitManager.php');
	require_once(dirname(__FILE__).'/../model/ProfessionnelManager.php');
	$pm = new ProduitManager();
	$proM = new ProfessionnelManager();
	$max = $pm->getIdMax();

	if ($_GET['id'] && $_GET['id']<=$max && $_GET['id']>0){
		$produits = $pm->getProduitById($_GET['id']);
		$livraison = $pm->getCatLivraison($_GET['id']);
		$id = $pm->getIdProById($_GET['id']);
		$professionnel = $proM->getById($id);
		
		
		if (isset($_GET['quant']) && isset($_GET['liv']) && $_GET['quant']>0 && $_GET['quant']<100){
			ajout($_GET['id'],$_GET['quant'],$_GET['liv']);
			$_SESSION['message'] = "<p>Produit ajouté dans le panier</p><button class='inputButtons buttonOverlay' onclick='closeOverlay();''> Ok </button>";
			header('Location:./index.php?page=panier');
		}
		else{
			require_once(dirname(__FILE__).'/../view/infoProduit.php');
		}

	}
	else{
		header('Location:./index.php');
	}
?>