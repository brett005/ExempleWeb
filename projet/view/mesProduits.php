<?php
 	require_once "./librairies/template.inc";

	$titre = "";
	$titreOnglet = "";
	$contenu = "";

 	if($categorie != ""){
 		$titre = 'Tous les Produits - 
			<div class="selectCat">
				<label class="boldLabels">Catégorie : </label> 
				<select name="affichCat" id="affichCat" onchange="changeCategorie();">
					<option value="0" id="all">Tous les Produits</option>
					<option value="1" id="Al">Alimentaire</option>
					<option value="2" id="Se">Service</option>
					<option value="3" id="Ma">Matériel</option>
					<option value="4" id="Cu">Custom</option>
					<option value="5" id="Au">Autre</option>
				</select>
				<script>
					actualiseSelected(' . json_encode($categorie) . ');
				</script>
			</div>';
		if($categorie == "all"){$titreOnglet = "Tous les Produits";}
		else{$titreOnglet=$categorie;}
}
 	else{
 		$titre = "Vos Produits";
		$contenu = '<a href="index.php?page=produitEdit"><div class="item itemAjout inputButtons">Ajouter un produit</div></a>';
		$titreOnglet = "Mes Produits";
 	}

	$tpl = new template();
	$tpl->set_file("page","view/template.html");

	$tpl->set_block("page","zone_onglet","bloc1");
	$tpl->set_var("titreOnglet", " - " . $titreOnglet);
	$tpl->parse("bloc1","zone_onglet",true);

	$tpl->set_block("page","zone_contenu","bloc2");


	while ($donnees = $produits->fetch()){

		$image = $donnees['image'];
		if(is_null($donnees['image'])){$image = './public/img/apercu.png';}

		$contenu = $contenu . '
			<div class="item">
				<img class="apercu" src=' . $image . '>
				<div class="contenuItem">
					<div class="textApercu">Nom du produit : ' . htmlspecialchars($donnees['nom'],ENT_NOQUOTES) . '</div><br />
					<div class="categorie">Catégorie : ' .  $donnees['categorie'] . '</div><br />
					<div class="divPrix">';
				
		if ($donnees["unite"] != $donnees["unite2"]) {
				$accord = "au ";
				if($donnees['unite'] == "unité"){$accord = "à l'";};
				$contenu = $contenu . "
				<div>
					Ce produit ce vend " . $accord . $donnees['unite'] . ".<br/>
					Estimation : 1 " . $donnees['unite'] . " ~ " . $donnees['estim'] . " " . $donnees['unite2'] . "
				</div>";
		}
		$contenu = $contenu . '
					<div class="sousTitreFiche">Prix :</div> <div class="affichPrix">' . $donnees['prix'] . ' €/' . $donnees['unite2'] .'</div>
				</div><br /><br />

					<div class="description"><div class="titreItem">Description : </div>' . htmlspecialchars($donnees['description'],ENT_NOQUOTES) . '</div><br /><br />
				</div>		
				<div class="buttonDouble">';

		if($categorie == ""){
			$contenu = $contenu . '
				<a href="index.php?page=mesProduits&amp;delProduit=' . $donnees['id'] . '">
					<div class="buttonItem buttonItemDouble"><div class="txtButItem">Supprimer</div><img src="./public/img/supp.png" class="iconeButton"></div><br />
				</a>';
		}


		$contenu = $contenu . '<a href="index.php?page=infoProduit&amp;id=' . $donnees['id'] . '">
					<div class="buttonItem buttonItemDouble"><div class="txtButItem">Accéder à la Fiche Produit</div><img src="./public/img/edit.png" class="iconeButton"><div class="txtMobileItem">Fiche<br />Produit</div></div>
				</a>
			</div>
   		</div>';
	}

	if($contenu == "") {$contenu = "<br /><br /><center>Pas de produits</center>";}
	$produits->closeCursor(); // Termine le traitement de la requête

	if ($_SESSION['message'] != "") {
		$contenu = $contenu . '
			<script>
				displayOverlay();
			</script>';
		$tpl->set_var("overlay", $_SESSION['message']);
		$_SESSION['message'] = "";
	}
	
	$tpl->set_var("titre", "<h1>" . $titre . "<hr></h1>");
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