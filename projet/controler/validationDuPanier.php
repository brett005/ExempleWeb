<?php

	//on inclut le modèle
	require_once(dirname(__FILE__).'/../model/CommandeManager.php');
	require_once(dirname(__FILE__).'/../model/ProfessionnelManager.php');
	require_once(dirname(__FILE__).'/../model/ProduitManager.php');



	if(isset($_POST['mail']) && isset($_POST['nom'])){
		$adresse = $_POST['numero']." rue ".$_POST['rue']." ".$_POST['code_p']." ".$_POST['ville'];

		
		
		$cm = new CommandeManager();
		//$cm->addCommandeTotale( $_POST['nom'], $_POST['mail'], $adresse, $_SESSION['panier']['id_article'], $_SESSION['panier']['livraison'] );

		///envoie de mail iciiiiiiiiiiiiiiiiiiiiiiiiii
		require_once(dirname(__FILE__).'/../model/contact.php');
		require_once(dirname(__FILE__).'/../model/facture.php');
		facture_client();
		facture_pro();
		$_SESSION['message'] = "<p>La commande a &#233;t&#233; effectu&#233;e un email de confirmation vous sera envoy&#233;</p><button class='inputButtons buttonOverlay' onclick='window.location=\"index.php\"'> Ok </button>";
		$_SESSION['panier'] = array();
		$_SESSION['panier']['id_article'] = array();
		$_SESSION['panier']['quantite'] = array();
		$_SESSION['panier']['livraison'] = array();
		echo '<script type="text/javascript">';
		//echo ';';
		echo '</script>';
	}

	//on inclut la vue 

	
	require_once(dirname(__FILE__).'/../view/validationCommande.php');

		

?> 