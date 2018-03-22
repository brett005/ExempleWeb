<?php
//On vérifie que le producteur soit bien connecté pour ajouter des produits
if (isset($_SESSION['id'])){ 
	//On inclut le modèle
	require_once(dirname(__FILE__).'/../model/ProduitManager.php');
	$pm = new ProduitManager();
	
	//Ajout du produit
	if(isset($_POST['nomProduit'])){// on en vérifie qu'un seul comme les champs sont en require_once on suppose que si on en a un ils sont tous là
		
		$nom = $_POST['nomProduit'];
		$descriptionProduit = $_POST['descriptionProduit'];
		$prix = $_POST['prix'];
		$idPro = $_SESSION['id'];
		$idCat = $_POST['categorie'];
		$descriptionLivraison = $_POST['descriptionLivraison'];
		
		
		if ($_POST['typeDePrix'] == "flou"){
			$unite = $_POST['unite'];
			$unite2 = $_POST['unite2'];
			$estim = $_POST['estim'];
		}else{
			$unite2 = $_POST['unite2'];
			$unite = $unite2;
			$estim = 1;
		}
		
		$pm -> addProduit( $nom, $descriptionProduit, $prix, $idPro, $idCat, $descriptionLivraison, $unite, $unite2, $estim, 1 );
		if (isset ($_POST['livrer']) OR isset($_POST['aVenirChercher']) OR isset($_POST['aDefinir'])){
			
			if (isset($_POST['livrer'])){
				$lenlivraison[] = 1;
			}if (isset($_POST['aVenirChercher'])){
				$lenlivraison[] = 2;
			}if (isset($_POST['aDefinir'])){
				$lenlivraison[] = 3;
			}
			$pm -> addInfoLivraison($lenlivraison);
		}
		
		if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0){
        
			if ($_FILES['photo']['size'] <= 1000000){
				// Test si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['photo']['name']);
                $extension_upload = strtolower(  substr(  strrchr($_FILES['photo']['name'], '.')  ,1)  );
                $extensions_autorisees = array('jpg', 'jpeg', 'png');
                if (in_array($extension_upload, $extensions_autorisees)){
					$i = $pm->getIdMax();
					$nom = "./public/img/{$i}.{$extension_upload}";
					move_uploaded_file($_FILES['photo']['tmp_name'],$nom);
					$pm->setImgById($i, $nom);
                }
				
			}
		}
	
	}
	
		
	//On récupère tous les produits
	$produits = $pm -> getProduitsByIdPro($_SESSION['id']);
	$categorie = "";
	//On inclut la vue
	require_once(dirname(__FILE__).'/../view/mesProduits.php');
}
else{// si il n'est pas connecter on l'envoie vers la page de connexion
	header('Location:../controler/connexion.php');
}
?>