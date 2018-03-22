<?php
 	require_once "./librairies/template.inc";

	$tpl = new template();
	$tpl->set_file("page","view/template.html");

	$tpl->set_block("page","zone_onglet","bloc1");
	$tpl->set_var("titreOnglet", " - Mon Panier");
	$tpl->parse("bloc1","zone_onglet",true);

	$tpl->set_block("page","zone_contenu","bloc2");

	$pm = new ProduitManager();
	$panier = $_SESSION['panier'];

	$items = array(
		"nom" => array(),
		"prix" => array(),
		"quantité" => array(),
		"estim" => array()
	);

	$contenu = "Vous n'avez pas d'articles dans votre panier";

	if (0 != sizeof($panier['id_article'])){
		$contenu = '
					<div class="item">
						<div class="titreItem">Récapitulatif de votre panier - Montant total : ' . round($montant,2,PHP_ROUND_HALF_UP) .'€</div><br />
						<div id="recap"> 
						</div>
						<div class="survol">
							<button id="buttonCommande" class="inputButtons" onClick="document.location = \'index.php?page=validationDuPanier\';"> Passer commande </button>
							<span class="textSurvol" id="survolCommande">Veuillez valider les quantités avant de passer commande</span>
						</div><br />
			   		</div>';

		$tabLivraison = array("Livraison à domicile","A venir chercher","Contacte le client");
		for ($i = 0; $i < sizeof($panier['id_article']); $i++) { 
			$produit = $pm -> getProduitById($panier['id_article'][$i])->fetch();

			$quantite = $panier['quantite'][$i];

			array_push($items["nom"], $produit["nom"]);
			array_push($items["prix"], $produit["prix"]);
			array_push($items["quantité"], $quantite . "");
			array_push($items["estim"], $produit["estim"]);

			$description = $produit["description"];
			if (sizeof($description) > 60) {$description = substr($description, 0, 57) . '...';}
					
			$image = $produit['image'];
			if(is_null($produit['image'])){$image = './public/img/apercu.png';}

			$contenu = $contenu . '
					<div class="item">
						<img class="apercu" src=' . $image . '>
						<div class="contenuItem">
							<div class="textApercu">Nom du produit : ' . $produit["nom"] . ' <div class = "prixUnitaire">(' . $produit["prix"] . '€/' . $produit['unite2'] . ')</div></div><br />
							<div class="categorie">Catégorie : ' .  $produit["categorie"] . '</div><br />
							<div class="description"><div class="titreItem">Description : </div>' . $description . '</div><br /><br />
							<div class="description"><div class="titreItem">Type de livraison : </div>' . $tabLivraison[$panier['livraison'][$i]-1] . '</div><br /><br />
							<div class="calculPrix">
								<div class="option">Quantité : <input type="number" min="1" max="99" value="'. $quantite .'" onChange="refreshPrix(' . $i . ',' . $produit["prix"] . ',' . $produit['estim'] . ',' . $quantite . ');" id="inputQuantite' . $i . '"> ' . $produit['unite'];

			if($produit['unite'] != $produit['unite2']){
				$contenu = $contenu . ' (~<div id="refreshEstim' . $i . '" style="display:inline-block;">' . $produit['estim'] . '</div>' . $produit['unite2'] . ')';
			}

			$contenu = $contenu . '
								</div>
								<div class="prixPanier">Prix : <div class="refresh">' . $quantite*$produit["prix"]*$produit['estim'] . '</div>€</div><br />
								<button class="inputButtons buttonsQuantite" onClick="modifQuantite(' . $panier['id_article'][$i] . ',' . $i . ');" disabled> Valider nouvelle quantité </button>
							</div>
						</div>
						<div class="buttonDouble">
							<a href="index.php?page=panier&amp;delete=' . $panier['id_article'][$i] . '">
								<div class="buttonItem buttonItemDouble"><div class="txtButItem">Supprimer</div><img src="./public/img/supp.png" class="iconeButton"></div><br />
							</a>
							<a href="index.php?page=infoProduit&amp;id=' . $panier['id_article'][$i] . '">
								<div class="buttonItem buttonItemDouble"><div class="txtButItem">Accéder à la Fiche Produit</div><img src="./public/img/edit.png" class="iconeButton"><div class="txtMobileItem">Fiche<br />Produit</div></div>
							</a>
						</div>
			   		</div>';
		}
		$contenu = $contenu . '
			   		<script type="text/javascript">
   						recapPanier(' . json_encode($items['nom']) . ',' . json_encode($items['prix']) . ',' . json_encode($items['quantité']) . ',' . json_encode($items['estim']) . ');
					</script>';
	}


	if ($_SESSION['message'] != "") {
		$contenu = $contenu . '
			<script>
				displayOverlay();
			</script>';
		$tpl->set_var("overlay", $_SESSION['message']);
		$_SESSION['message'] = "";
	}
	

	$tpl->set_var("titre", "<h1>Votre panier<hr></h1>");
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