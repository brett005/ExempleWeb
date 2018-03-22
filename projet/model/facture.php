<?php
/**
*génération de la facture : récupération des items du panier
*
*@return une string "articles"
*/
function facture_articles(){
	global $passage_ligne;
	$pm = new ProduitManager();
	$nb_articles = count($_SESSION['panier']['id_article']);
	$articles = '';

	for($i = 0; $i < $nb_articles; $i++){
		$produit = $pm -> getProduitById($_SESSION['panier']['id_article'][$i])->fetch();
		$articles .= 'article n°'.$i.' : '.$produit['nom'].' x '.$_SESSION['panier']['quantite'][$i].', livraison : '.$_SESSION['panier']['livraison'][$i].$passage_ligne;
	}	
	return $articles;
}

/**
*génération de l'adresse client
*
*@return l'adresse client en string
*/
function adresse_client(){
	return $_POST['numero'].' '.$_POST['rue'].' '.$_POST['code_p'].' '.$_POST['ville'];
}

/**
*génération de la facture pour le client, et envoi le mail

*/
function facture_client(){
	global $passage_ligne, $adresse_client;
	$message = 'Bonjour '.$_POST['nom'].', '.$passage_ligne.$passage_ligne.'Vous avez commandé l"(es) article(s) suivant(s) :'.$passage_ligne.facture_articles().$passage_ligne.'à l"adresse suivante :'.adresse_client().$passage_ligne.' .'.$passage_ligne.', pour un total de :'.montant_panier().'. Votre commande est transmise au producteur.'.$passage_ligne.' Cordialement, l"équipe de L&L' ;
	$_SESSION['message'] = "<p>La commande a été effectuée un email de confirmation vous sera envoyé</p>";
	//form_contact($_POST['nom'],'',$_POST['mail'],$message);
}



/**
*envoi des factures au pro
*/
function facture_pro(){
	global $passage_ligne;
	$plm = new ProfessionnelManager();
	$pm = new ProduitManager();
	$nb_articles = count($_SESSION['panier']['id_article']);

	for($i = 0; $i < $nb_articles; $i++){
		$produit = $pm -> getProduitById($_SESSION['panier']['id_article'][$i])->fetch();
		$nom_pro = $pm -> getProById($produit['id']);
		$mail_pro = $plm -> testMail($nom_pro);
		$message = 'bonjour, '.$_POST['nom'].' a commandé cet article :'.$produit['nom'].' x '.$_SESSION['panier']['quantite'][$i].', livraison : '.$_SESSION['panier']['livraison'][$i].$passage_ligne.'à cette adresse : '.adresse_client().', contact client : '.$_POST['mail'];
		//form_contact($nom_pro,'',$mail_pro,$message);

	}


}

