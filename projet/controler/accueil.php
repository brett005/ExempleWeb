<?php
 
//On inclut le modèle
require_once(dirname(__FILE__).'/../model/ProduitManager.php');

$pm = new ProduitManager();
$nb = $pm -> nbProduit();
$produits = $pm -> getAllProduits();

 
//On inclut la vue
require_once(dirname(__FILE__).'/../view/accueil.php');
?>
