<?php
require_once("Manager.php");

class CommandeManager extends Manager{

	private function getLastCommandeId(){
		$db = $this->dbConnect();
		$req = $db->query('SELECT MAX(client.id) as id FROM `client`');
		$donnees = $req->fetch();
		$id = $donnees['id'];
		$req->closeCursor();
		return $id;
	}
	
	public function addCommandeTotale( $nomClient, $emailClient, $adresseClient, $arrayIdProduits, $arrayIdLivraison ){
		$db = $this->dbConnect();
		$this->addClient($nomClient, $emailClient, $adresseClient);
		$id = $this->getLastClientId();
		$this->addCommande($id);
		$id = getLastCommandeId();
		for($i= 0; i<count($arrayIdproduits); $i++){
			$this->addLien_commande($id, $arrayIdProduits[$i], $arrayIdLivraison[$i]);
		}
		
	}
	
	private function addClient($nomClient, $emailClient, $adresseClient){//fonction qui ajoute un nouveau client à la base
		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO client (`nom`, `email`, `adresse`);
		VALUES (?,?,?)');
		$req->execute(array($nomClient,$emailClient,$adresseClient));
	}
	
	private function getLastClientId(){// retourne l'id du dernier client
		$db = $this->dbConnect();
		$req = $db->query('SELECT MAX(client.id) as id FROM `client`');
		$donnees = $req->fetch();
		$id = $donnees['id'];
		$req->closeCursor();
		return $id;
	}
	

	
	private function addCommande($idClient){
		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO client (`id_client`);
		VALUES (?)');
		$req->execute(array($idClient));
	}
	
	private function addLien_commande($idCom, $idProd, $idLivr){
		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO lien_commande (`id_commande`, `id_produit`, `id_livraison`);
		VALUES (?,?,?)');
		$req->execute(array($idCom, $idProd, $idLivr));
	}
	
	

	
	
	
}