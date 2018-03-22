<?php
 	require_once "./librairies/template.inc";

	$tpl = new template();
	$tpl->set_file("page","view/template.html");

	$produit = $produits->fetch();
	$professionnel = $professionnel->fetch();

	$tpl->set_block("page","zone_onglet","bloc1");
	$tpl->set_var("titreOnglet", " - Fiche Produit : " . $produit['nom']);
	$tpl->parse("bloc1","zone_onglet",true);

	$tpl->set_block("page","zone_contenu","bloc2");

	$typesLivraison = "";
	for ($i=0; $i < sizeof($livraison); $i++) {
		$typesLivraison = $typesLivraison . "<div class='typeLivraison'>" . $livraison[$i] . "</div>" ;
	}

	$typeView = !isset($_SESSION['id']);

	$image = $produit['image'];
	if(is_null($produit['image'])){$image = './public/img/apercu.png';}

	$contenu = "
		<div class='fiche'>
			<div class='teteFiche'>
				<div class='titreFiche'>Nom du produit : " . $produit['nom'] . "</div>
				<div class='imgProduit'><img src=" . $image . "></div>
			</div><br /><br />
			<div class='corpsFiche'>
				<div class='divPrix'>";
				
	if ($produit['unite'] != $produit['unite2']) {
			$accord = "au ";
			if($produit['unite'] == "unité"){$accord = "à l'";};
			$contenu = $contenu . "
			<div class='affichTypePrix'>
				Ce produit ce vend " . $accord . $produit['unite'] . ".<br/>
				Estimation : 1 " . $produit['unite'] . " ~ " . $produit['estim'] . " " . $produit['unite2'] . "
			</div>";
	}
	$contenu = $contenu . "
				<div class='sousTitreFiche'>Prix :</div> <div class='affichPrix'>" . $produit['prix'] . " €/" . $produit['unite2'] ."</div>";
				
	$contenu = $contenu . "
				</div><br /><br />
				<div class='description'><div class='sousTitreFiche'>Description : </div><br />" . $produit['description'] . "</div><br /><br />
				<div><div class='sousTitreFiche'>Type(s) de livraison disponible(s): </div>" . $typesLivraison . "</div><br />	
				<div class='description'><div class='sousTitreFiche'>Description de la livraison : </div><br />" . $produit['description_livraison'] . "</div><br /><br />
				<div class='description'><div class='sousTitreFiche'>Informations de contact du vendeur : </div><br /> 
				<b>Nom : </b>" . $professionnel['nom'] . "<br />
				<b>Email : </b>" . $professionnel['email'] . "<br />
				<b>Adresse : </b>" . $professionnel['adresse'] . "<br />
				</div><br /><br />
				<div id='adaptatif'>
				</div>
			</div>	
   		</div>
   		<script type='text/javascript'>
				adaptatif(" . json_encode($typeView) . "," . json_encode($produit['prix']) . "," . json_encode($produit['id']) . "," . json_encode($produit['estim']) . "," . json_encode($produit['unite']) . "," . json_encode($produit['unite2']) . "," . json_encode($livraison) . ");
				testPanier(" . json_encode($produit['id']) . "," . json_encode($_SESSION['panier']['id_article']) .");
		</script>";
	

	if ($_SESSION['message'] != "") {
		$contenu = $contenu . '
			<script>
				displayOverlay();
			</script>';
		$tpl->set_var("overlay", $_SESSION['message']);
		$_SESSION['message'] = "";
	}
	
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