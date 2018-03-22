<?php
	require_once "./librairies/template.inc";

	$tpl = new template();
	$tpl->set_file("page","view/template.html");

	$tpl->set_block("page","zone_onglet","bloc1");
	$tpl->set_var("titreOnglet", " - Connexion");
	$tpl->parse("bloc1","zone_onglet",true);


	$tpl->set_block("page","zone_contenu","bloc2");
	$contenu = '
		<div class="formulaire" id="Connexion">
			<form method="post" action="index.php?page=connexion">
				<div class="form-group">
					<label>Email</label><br />
					<input type="email" name="mail" placeholder="Votre mail"><br /><br />	
													
					<label>Mot de passe</label><br />
					<input type="password" name="pass"><br /><br />					
				</div>
				<input type="submit" value="Valider" class="inputButtons"/>
			</form>
		</div>';


	if ($_SESSION['message'] != "") {
		$contenu = $contenu . '
			<script>
				displayOverlay();
			</script>';
		$tpl->set_var("overlay", $_SESSION['message']);
		$_SESSION['message'] = "";
	}
	
	$tpl->set_var("titre", "<h1>Connexion<hr></h1>");
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