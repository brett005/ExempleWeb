<?php
 	require_once "./librairies/template.inc";

	$tpl = new template();
	$tpl->set_file("page","view/template.html");


	$tpl->set_block("page","zone_onglet","bloc5");
	$tpl->set_var("titreOnglet", " - Infos Livraison");
	$tpl->parse("bloc5","zone_onglet",true);


	$tpl->set_block("page","zone_contenu","bloc1");

	$contenu = "
		<div class='fiche infoLiv'>
			<b>Trois types de livraisons sont disponibles :</b>
			<ul>
				<li>
					<div style='font-weight:bold;'>Livraison à domicile</div>
					<p>  Le professionel s'occupant du produit se charge de faire livrer le client à son domicile par la méthode de son choix</p>
				</li>
				<li>
					<div style='font-weight:bold;'>A venir chercher</div>
					<p>  Le client viendra chercher le produit à l'adresse que lui fournira le professionel en réponse à sa commande</p>
				</li>
				<li>
					<div style='font-weight:bold;'>Contacte le client</div>
					<p>  Le professionel contat le client pour discuter avec lui de la manière dont le produit sera récupéré</p>
				</li>
			</ul>
		</div>";

	if ($_SESSION['message'] != "") {
		$contenu = $contenu . '
			<script>
				displayOverlay();
			</script>';
		$tpl->set_var("overlay", $_SESSION['message']);
		$_SESSION['message'] = "";
	}

	$tpl->set_var("titre", "<h1>Informations Livraison<hr></h1>");
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