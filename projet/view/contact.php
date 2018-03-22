<?php
 	require_once "./librairies/template.inc";

	$tpl = new template();
	$tpl->set_file("page","view/template.html");

	$tpl->set_block("page","zone_onglet","bloc1");
	$tpl->set_var("titreOnglet", " - Contact");
	$tpl->parse("bloc1","zone_onglet",true);

	$tpl->set_block("page","zone_contenu","bloc2");

	$contenu = '
		<form action="../controler/contact.php" method="post">
			<p>Votre nom : <input type="text" name="nom" /></p>
			<p>Votre prénom : <input type="text" name="prenom" /></p>
			<p>Votre mail : <input type="email" name="mail" /></p>
			<p>Votre message : <textarea name="message"></textarea></p>
		</form>';


	if ($_SESSION['message'] != "") {
		$contenu = $contenu . '
			<script>
				displayOverlay();
			</script>';
		$tpl->set_var("overlay", $_SESSION['message']);
		$_SESSION['message'] = "";
	}
	

	$tpl->set_var("titre", "<h1>Contact<hr></h1>");
	$tpl->set_var("contenu", $contenu);

	$tpl->parse("bloc2","zone_contenu",true);


	//$tpl->set_block("page","zone_panier","bloc3");
	//$tpl->set_var("montantPanier", " : " . $montant . "€");
	//$tpl->parse("bloc3","zone_panier",true);

	$tpl->set_block("page","zone_menu","bloc4");
	$tpl->set_var("menu", $menu);
	$tpl->set_var("bouton", $bouton);

	if($panier){
		$tpl->set_var("montantPanier", " : " . $montant . "€");
	}

	$tpl->parse("bloc4","zone_menu",true);

	$tpl->pparse("view","page");

?>