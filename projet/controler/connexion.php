<?php	
	//on inclut le modèle
	require_once(dirname(__FILE__).'/../model/ProfessionnelManager.php');

	//on inclut la vue
	require_once(dirname(__FILE__).'/../view/connexion.php');

	//On vérifie que l'utilisateur a bien envoyé les informations demandées 	
	if(isset($_POST["mail"]) && isset($_POST["pass"])){
		$pm = new ProfessionnelManager();
		$pass = $pm->getPassByEmail($_POST["mail"]);

		if($pass == $_POST["pass"] && !is_null($pass)){
			
			$var = $pm-> getIdNomByEmail($_POST["mail"]);
			session_destroy();
			session_start();
			
			$_SESSION['id'] = $var['id'];
			$_SESSION['nom'] = $var['nom'];
			$_SESSION['message'] = "<p>Ravi de vous revoir! </p><button class='inputButtons buttonOverlay' onclick='closeOverlay();''> Ok </button>";

			//une fois connecte on redirige vers l'index
			header('Location: index.php?page=mesProduits');

		}
		else{
			//si erreur dans la connexion on redirige vers la page de connexion
			$_SESSION['message'] = "<p>Le mot de passe ou l'email est incorrect </p><button class='inputButtons buttonOverlay' onclick='closeOverlay();''> Ok </button>";
			header('Location: index.php?page=connexion');
		}
	}



?>