<?php
require_once("Manager.php");

class ProduitManager extends Manager{
//--------------- Fonctions de sélection
	public function getCatbyIdCat($idCat){
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT `nom` FROM `categorie` WHERE id = ? ');
		$req->execute(array($idCat));
		$donnees = $req->fetch();
		$nom =$donnees['nom'];
		$req->closeCursor();
		return $nom;
	}

	public function getIdMax(){
		$db = $this->dbConnect();
		$req = $db->query('SELECT MAX(produit.id) as n FROM `produit`');
		$donnees = $req->fetch();
		$n =$donnees['n'];
		$req->closeCursor();
		return $n;
	}
	
	public function getCatLivraison($idProd){ //renvoie les catégories de livraisons pour un id d'ojet donné
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT tl.libellé as cat FROM type_livraison tl INNER JOIN lien_livraison_produit llp ON llp.id_livraison = tl.id WHERE llp.id_produit = ? ');
		$req->execute(array($idProd));
		while ($donnees = $req->fetch()){
			$categorie[] = $donnees['cat'];
		}
		$req->closeCursor();
		return $categorie;
	}
	
	public function getAllProduits(){// renvoie toutes les infos sur les produits : id, nom description, prix, categorie et typeLivraison (un tabeau de tableau)
		$db = $this->dbConnect();
		$req = $db->query('SELECT p.id, p.nom, p.description, p.prix, c.nom AS categorie , pro.nom AS nomPro, p.unite, p.unite2, p.estim, p.image FROM produit p LEFT JOIN categorie c ON p.id_categorie = c.id LEFT JOIN professionnel pro ON p.id_user = pro.id');
		return $req;
	}
	
	public function getProduitsByIdPro($id){// on récupère tous les objets d'un producteur 
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT p.id, p.nom, p.description, p.prix, c.nom AS categorie, p.unite, p.unite2, p.estim, p.image FROM produit p LEFT JOIN categorie c ON p.id_categorie = c.id WHERE id_user = ? ');
		$req->execute(array($id));
		return $req;
	}
	
	
	public function getProduitsByIdCat($id){// on récupère tous les objets d'une catégorie 
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT p.id, p.nom, p.description, p.prix, c.nom AS categorie , pro.nom AS nomPro, p.unite, p.unite2, p.estim, p.image FROM produit p LEFT JOIN categorie c ON p.id_categorie = c.id LEFT JOIN professionnel pro ON p.id_user = pro.id WHERE p.id_categorie = ? ');
		$req->execute(array($id));
		return $req;
		
	}
//                   --- Fonctions qui récupèrent en fonctiond de l'id du produit 

	public function getProduitById($id){// renvoie les infos sur un produit par son id
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT p.id, p.nom, p.description, p.prix, p.id_user, p.description_livraison, c.nom AS categorie, p.unite, p.unite2, p.estim, p.image FROM produit p LEFT JOIN categorie c ON p.id_categorie = c.id WHERE p.id = ?');
		$req->execute(array($id));
		return $req;
	}
	
	public function getIdProById($id){// on récupère l'id pro par l'id d'un objet
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT pro.id as idPro FROM professionnel pro INNER JOIN produit prod ON prod.id_user = pro.id WHERE prod.id = ?');
		$req->execute(array($id));
		$donnees = $req->fetch();
		$idPro =$donnees['idPro'];
		$req->closeCursor();
		return $idPro;
	
	}
	
	public function getProById($id){
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT pro.nom as nomPro FROM professionnel pro INNER JOIN produit prod ON prod.id_user = pro.id WHERE prod.id = ?');
		$req->execute(array($id));
		$donnees = $req->fetch();
		$nomPro =$donnees['nomPro'];
		$req->closeCursor();
		return $nomPro;
	}
	
	public function getPrixById($id){
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT `prix` FROM `produit` WHERE id = ?');
		$req->execute(array($id));
		$donnees = $req->fetch();
		$prix =$donnees['prix'];
		$req->closeCursor();
		return $prix;
	}
	
//------------------ Fonctions D'ajout 
	
	public function addProduit( $nom, $commentaire, $prix, $id_user, $idCategorie, $description_livraison, $unite, $unite2, $estim){
		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO produit (`nom`, `description`, `prix`, `id_user`, `id_categorie`, `description_livraison`, `unite`, `unite2`, `estim`)
		VALUES (?,?,?,?,?,?,?,?,?)');
		$req->execute(array($nom,$commentaire,$prix,$id_user,$idCategorie, $description_livraison, $unite, $unite2, $estim));
	}
	
	public function addInfoLivraison( $len_info_livraison ){// ajout des modes de livraisons len_info_livraison contient des id des modes de livraisons
		$db = $this->dbConnect();
		$req1 = $db->query('SELECT MAX(produit.id) as id_produit FROM `produit`');
		$donnees = $req1->fetch();
		foreach($len_info_livraison as $element){
			$req = $db->prepare('INSERT INTO lien_livraison_produit (id_produit, id_livraison)
			VALUES (?,?)');
			$req->execute(array($donnees['id_produit'],$element));
		}
		$req1->closeCursor();
	}
	
//----------------- Fonctions de modifications
	
	public function setImgById($id, $nomDuChemin){
		$db = $this->dbConnect();
		$req = $db->prepare('UPDATE `produit` SET `image` = ? WHERE `produit`.`id` = ?');
		$req->execute(array($nomDuChemin, $id));
		
	}
	
//----------------- Fonction de comptage
	
	public function nbProduit(){// retourne un int qui correspond au nombre de produit dans la bdd
		$db = $this->dbConnect();
		$req = $db->query('SELECT COUNT(*)AS nbProd FROM `produit` ');
		$donnees = $req->fetch();
		$nb = $donnees['nbProd'];
		$req->closeCursor();
		return $nb;
	}
	
//---------------- Fontions de suppréssion 
	
	public function deleteById($id){// supprime un produit de la bdd à partir de son id 
		$db = $this ->dbConnect();
		$req = $db -> prepare('DELETE FROM `produit` WHERE id = ?');
		$req -> execute(array($id));
		$req1 = $db -> prepare('DELETE FROM `lien_livraison_produit` WHERE id_produit = ?');
		$req1 -> execute(array($id));
	}
}
?>