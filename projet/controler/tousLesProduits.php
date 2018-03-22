<?php

//On inclut le modèle
require_once(dirname(__FILE__).'/../model/ProduitManager.php');

$pm = new ProduitManager();
if(isset($_GET['cat']) AND $_GET['cat']>0 AND $_GET['cat']<6){
	
	$produits = $pm->getProduitsByIdCat($_GET['cat']);
	$categorie= $pm->getCatbyIdCat($_GET['cat']);
	

}else{//On récupère les produits
	$produits = $pm -> getAllProduits();
	$categorie = "all";
}
 
//On inclut la vue
require_once(dirname(__FILE__).'/../view/mesProduits.php');

?>