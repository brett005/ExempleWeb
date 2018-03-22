<?php

function inscription(){

	//Connexion à la base de données, faire avec une function plus tard
	try{
		$pdo = new PDO('mysql:host=localhost;dbname=projet', 'root', '');
		
	} catch(Exception $e){
		 die('Erreur : ' . $e->getMessage());
	}

//On vérifie que l'utilisateur a bien envoyé les informations demandées 
	if(isset($_POST["mail"]) && isset($_POST["nom"]) && isset($_POST["pass"])){

		$reqsql = 'INSERT INTO professionnel (nom, email, pass) VALUES(:nom, :mail, :pass)';
		//$reqsql_test ='SELECT EXISTS (SELECT * FROM professionnel WHERE nom=:nom) AS test';
		$reqsql_test ='SELECT mail FROM professionnel WHERE nom =:nom';


		$requete = $pdo->prepare($reqsql);
		$requete_test = $pdo->prepare($reqsql_test); 

		$requete->bindParam(':nom', $_POST["nom"]);
		$requete->bindParam(':mail', $_POST["mail"]);
		$requete->bindParam(':pass', $_POST["pass"]);

		$requete_test->bindParam(':mail', $_POST["mail"]);
		//$requete_test->bindParam(':nom', $_POST["nom"]);
		//$requete_test->bindParam(':pass', $_POST["pass"]);		

		//variable test
		$bool = false;
		
		//on cherche a savoir si le nom rempli dans le questionnaire est deja dans la bdd
		$requete_test->execute();
		//$donnees = $requete_test->fetchALL(PDO::FETCH_ASSOC);


		$donnees = $requete_test->rowCount();

		if($donnees == 0){

			//execution de la requete
			$requete->execute();

			//on redirige vers la page d'accueil
			header('Location: index.php');
		}
		else{

			//on redirige vers la page d'inscription et on affiche le message d'erreur
			header('Location: inscription.php');
		}
		
	}
			
}

?>
