<?php
require_once("Manager.php");

class ProfessionnelManager extends Manager{
	
	public function getPassByEmail($email){
		 	
		$pdo = $this->dbConnect();
		//on prepare la requetes sql
		$requete_pass = $pdo->prepare('SELECT pass FROM professionnel WHERE email = ?');
		$requete_pass->execute(array($email));
		//on recupere les resultat de la requete dans un tableau
		$result_pass = $requete_pass->fetch();
		$pass = $result_pass['pass'];
		$requete_pass->closeCursor();
		return $pass;
		
	}
	
	public function getIdNomByEmail($email){  // retourne le nom et l'id dans un tableau associatif
		$pdo = $this->dbConnect();
		$req = $pdo->prepare('SELECT id, nom FROM professionnel WHERE email = ?');
		$req-> execute(array($email));
		$len = array();
		$result = $req->fetch(); // normalement on ne peut avoir qu'une seule ligne puisque les email sont en unique alors on ne va récuper que la première ligne
		$len['nom'] = $result['nom'];
		$len['id'] = $result['id'];
		$req->closeCursor();
		return $len;	
	}
	
	public function getById($id){ // Récupère le nom et l'email par l'id du pro
		$pdo = $this->dbConnect();
		$req = $pdo->prepare('SELECT* FROM professionnel WHERE id = ?');
		$req-> execute(array($id));
		return $req;
	}



	public function testMail($nom){

		$pdo = $this->dbConnect();
		$requete =$pdo->prepare('SELECT mail FROM professionnel WHERE nom = ?');
		//$requete->execute();
		$donnees = $requete->rowCount();
		return $donnees;
	}

	public function addProfessionnel($nom, $mail, $pass, $numero, $rue, $codep, $ville){

		$pdo = $this->dbConnect();
		$adresse = $numero.' '.$rue.'  '.$codep.' '.$ville;
		$requete = $pdo->prepare('INSERT INTO professionnel (nom, email, pass, adresse) VALUES(?,?,?,?)');
		$requete->execute(array($nom, $mail, $pass, $adresse)); 
		$requete->closeCursor();

	}
		
	
}