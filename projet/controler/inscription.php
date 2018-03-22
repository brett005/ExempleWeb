<?php

	//on inclut le modèle
	require_once(dirname(__FILE__).'/../model/ProfessionnelManager.php');

	if(isset($_POST["mail"]) && isset($_POST["nom"]) && isset($_POST["pass"]) && isset($_POST["numero"]) && isset($_POST["rue"]) && isset($_POST["code_p"]) && isset($_POST["ville"])){	

		$pm = new ProfessionnelManager();

		$test = $pm->testMail($_POST["mail"]);

		if($test == 0){

			//on appelle la fonction qui permet d'ajouter le professionnel à la base
			$pm->addProfessionnel($_POST["nom"], $_POST["mail"], $_POST["pass"], $_POST["numero"], $_POST["rue"], $_POST["code_p"], $_POST["ville"]); 
			//on redirige vers l'index
			$_SESSION['message'] = "<p>Vous êtes bien inscrit</p><button class='inputButtons buttonOverlay' onclick='window.location=\"index.php\";'> Ok </button>";

		}else{
			//si erreur on redirige vers la page d'inscription
			header('Location: inscription.php');
			$_SESSION['message']="<p>Email déjà utilisé</p><button class='inputButtons buttonOverlay' onclick='closeOverlay();''> Ok </button>";
		}
	}
	//on inclut la vue 
	require_once(dirname(__FILE__).'/../view/inscription.php');


?> 
