<?php
//-----------------test panier----------------------------------

/**
* Ajout d'article, à voir quels attributs sont importants à passer
*
*@param array $article variable contenant le produit, tableau "associatif"
*/
function ajout($id_article,$qte,$livraison){
	/*on place l'id de l'article à la fin du panier, et on lui attribue la quantité
	* voulue, et on retrouve le produit grâce à l'id pour l'affichage
	* l'article est ajouté uniquement si il n'est pas déjà dans le panier
	*/
	if(!verif_panier($id_article)){
		array_push($_SESSION['panier']['id_article'], $id_article);
		array_push($_SESSION['panier']['quantite'], $qte);
		array_push($_SESSION['panier']['livraison'], $livraison);
	}else{

		$nb_article = count($_SESSION['panier']['id_article']);
		for($i = 0; $i < $nb_article; $i++){
			if($id_article == $_SESSION['panier']['id_article'][$i]){
				$qte +=$_SESSION['panier']['quantite'][$i];
			}
		}
		modif_qte($id_article,$qte);
	}
}

/**
*vérification si un article est déjà dans le panier
*la fonction pourra être utilisée pour griser le bouton ajouter, ou le remplacer par
*modifier la quantité
*
*@param id de l'article, vraisemblablement un int
*@return Boolean , renvoie vrai si l'article est trouvé dans le panier
*/
function verif_panier($id_article){
	$present = false;

	if (count($_SESSION['panier']['id_article']) > 0 && array_search($id_article, $_SESSION['panier']['id_article']) !== false) {
		$present = true;
	}
	return $present;
}

/**
* Modifie la quantité de l'article voulu
*
*@param $id_article correspond à l'article à modifier
*@param $qte correspond à la quantité voulue de l'article
*/
function modif_qte($id_article,$qte){
	$nb_article = count($_SESSION['panier']['id_article']);

	for($i = 0; $i < $nb_article; $i++){
		if($id_article == $_SESSION['panier']['id_article'][$i]){
			$_SESSION['panier']['quantite'][$i] = $qte;
			
		}
	}
}


/**
*Supprime un article du panier, on le retrouve grâce à son id
*on recrée le panier, mais en enlevant l'article à supprimer.
*il y a forcément plus simple, mais au moins je sais comment faire et comment l'expliquer
*
*@param $id_article
*/
function del_article($id_article){
	//on init un panier temporaire, on le remplit avec le contenu du panier - l'article à supprimer
	$panier_tmp = array("id_article" => array(),"quantite" => array(),"livraison" => array());
	$nb_article = count($_SESSION['panier']['id_article']);

	for($i = 0;$i <$nb_article;$i++){
		if($_SESSION['panier']['id_article'][$i] != $id_article){
			array_push($panier_tmp['id_article'], $_SESSION['panier']['id_article'][$i]);
			array_push($panier_tmp['quantite'], $_SESSION['panier']['quantite'][$i]);
			array_push($panier_tmp['livraison'], $_SESSION['panier']['livraison'][$i]);
		}
	}

	$_SESSION['panier'] = $panier_tmp;
	unset($panier_tmp);
}


/**
*calcule le montant de la commande
*
*@return un float probablement, à voir
*/
function montant_panier(){

	$pm = new ProduitManager();

	$montant = 0;
	$nb_article = count($_SESSION['panier']['id_article']);

	for($i = 0; $i< $nb_article; $i++){
		$produit = $pm -> getProduitById($_SESSION['panier']['id_article'][$i])->fetch();
		$montant += $_SESSION['panier']['quantite'][$i] * $produit['prix'] * $produit['estim'];
	}

	return $montant;
}
//--------------------------------------------------------------