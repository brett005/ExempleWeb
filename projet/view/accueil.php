<?php
 	require_once "./librairies/template.inc";

	$tpl = new template();
	$tpl->set_file("page","view/template.html");
	$tpl->set_block("page","zone_contenu","bloc1");

	$contenu = "<div id='accueil'>";
	if ($nb < 5){
		for ($i=0; $i < $nb ; $i++) { 
			$produit = $produits->fetch();
			$image = $produit['image'];
			if(is_null($produit['image'])){$image = './public/img/apercu.png';}

			$contenu = $contenu . "
				<div class='accueil'>
					<div class='titreAccueil'>".$produit['nom']."</div>
					<div class='catAccueil'>".$produit['categorie']."</div>
					<div class='imgAccueil'><img src=" . $image . "></div>
					<button class='inputButtons' onclick='document.location = \"./index.php?page=infoProduit&amp;id=" . $produit['id'] . "\"'> Voir la Fiche Produit </button>
				</div>";
		}
	}
	else{
		$random = array();

		$j=0;
		while ($j < 5) { 
			$n = rand (0, $nb-1);
			if (!in_array($n, $random)) {
				array_push($random, $n);
				$j++;
			}			
		}
		for ($i=0; $i < $nb ; $i++) { 
			$produit = $produits->fetch();
			if (in_array($i,$random)) {

				$image = $produit['image'];
				if(is_null($produit['image'])){$image = './public/img/apercu.png';}

				$contenu = $contenu . "
					<div class='accueil'>
						<div class='titreAccueil'>".$produit['nom']."</div>
						<div class='catAccueil'>".$produit['categorie']."</div>
						<div class='imgAccueil'><img src=" . $image . "></div>
						<button class='inputButtons' onclick='document.location = \"./index.php?page=infoProduit&amp;id=" . $produit['id'] . "\"'> Voir la Fiche Produit </button>
					</div>";
			}
		}
	}
	
	$contenu = $contenu ."</div>";



	if ($_SESSION['message'] != "") {
		$contenu = $contenu . '
			<script>
				displayOverlay();
			</script>';
		$tpl->set_var("overlay", $_SESSION['message']);
		$_SESSION['message'] = "";
	}

	$tpl->set_var("titre", "<h1>Découvrez nos produits<hr></h1>");
	$tpl->set_var("contenu", $contenu);
	$tpl->set_var("overlay", $_SESSION['message']);
	$tpl->parse("bloc1","zone_contenu",true);

	$tpl->set_block("page","zone_menu","bloc4");
	$tpl->set_var("menu", $menu);
	$tpl->set_var("bouton", $bouton);

	if($panier){
		$tpl->set_var("montantPanier", " : " . $montant . "€");
	}

	$tpl->parse("bloc4","zone_menu",true);

	$tpl->pparse("view","page");
?>