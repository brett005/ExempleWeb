<?php
 	require_once "./librairies/template.inc";

	$tpl = new template();
	$tpl->set_file("page","view/template.html");

	/*$produit = $produits->fetch();*/

	$tpl->set_block("page","zone_onglet","bloc1");
	$tpl->set_var("titreOnglet", " - Ajout nouveau produit");//. $produit['nom']
	$tpl->parse("bloc1","zone_onglet",true);

	$tpl->set_block("page","zone_contenu","bloc2");

	$contenu = '
		<div class="fiche formModif">
	   		<form method="post" action="index.php?page=produitEditTraitement" enctype="multipart/form-data" onsubmit="return verifFormProduit();">
				<fieldset>
					<legend>Informations sur le produit</legend>
					
					<div class="left"><label class="boldLabels">Nom du produit : </label> <input type="text" name="nomProduit" required /></div>
					<div class="right">
						<label class="boldLabels">Photo du produit : </label><input type="file" name="photo" accept=".jpg, .jpeg, .png" id="choixImage" onChange="testFileValide(this);"/>
						<div id="errorImage" class="errorForm">Veuillez selectionner un fichier .png/.jpg/.jpeg</div>
					</div><br /><br />
					<label class="boldLabels">Catégorie : </label> 
					<select name="categorie" id="categorie" >
					   <option value="1" selected>Alimentaire</option>
					   <option value="2">Service</option>
					   <option value="3">Matériel</option>
					   <option value="4">Custom</option>
					   <option value="5">Autre</option>
					</select><br /><br />
					<label for="descriptionProduit" class="boldLabels">Décrivez le produit : </label><br />
					<div class="errorForm" id="errorDescription">Veuillez saisir 255 caractères maximum</div> 
					<textarea name="descriptionProduit" id="areaDescription" placeholder="255 caractères max." onkeyup="testDescriptionP();" required></textarea><br /><br />
				</fieldset>
				
				<fieldset>
					<legend>Informations sur le prix</legend>

					<label class="boldLabels">Type de prix : </label>
					<input type="radio" name="typeDePrix" value="fixe" id="fixe" onChange="checkRadios();" checked/> <label for="fixe">Prix fixe</label>
					<input type="radio" name="typeDePrix" value="flou" id="flou" onChange="checkRadios();"/> <label for="flou">Prix flou</label><br />
					<br />

					<div class="hidePrix">
						<div><label for="unite" class="boldLabels">Le produit se vend : </label>
						<select name="unite" id="unite" onchange="limitation();">
							<option value="unité">A l\'unité</option>
							<option value="kg">Au kilo</option>
							<option value="cm">Au centimètre</option>
							<option value="m">Au mètre</option>
							<option value="m2">Au mètre carré</option>
							<option value="litre">Au litre</option>
						</select><br /></div><br />
					</div>

					<div><label for="prix" class="boldLabels">Prix : </label><input name="prix" type="number" id="prix" min=0.01 step=0.01 required/>€/ 
					<select name="unite2" id="unite2" onchange="majEstimation();">
						<option value="unité">Unité</option>
						<option value="kg" selected>Kilo</option>
						<option value="cm">Centimètre</option>
						<option value="m">Mètre</option>
						<option value="m2">Mètre carré</option>
						<option value="litre">Litre</option>
					</select></div><br />
					<div class="errorForm" id="errorUnite">Veuillez saisir des unités différentes</div> 

					<div class="hidePrix">
						<div class="boldLabels">Estimation de quantité :</div> 
						<div>
							1 <div id="estimUnite"></div> ~ 
							<input name="estim" type="number" id="estim" min=0.01 step=0.01 />
							<div id="estimUnite2"></div>
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Informations sur la livraison</legend>
						<input type="checkbox" name="livrer" id="livrer" /> <label for="livrer">Livraison à domicile</label><br />
						<input type="checkbox" name="aVenirChercher" id="aVenirChercher" /> <label for="aVenirChercher">A venir chercher</label><br />
						<input type="checkbox" name="aDefinir" id="aDefinir" /> <label for="aDefinir">A définir avec le client</label><br />
						<div class="errorForm" id="errorCheckboxs">Veuillez cocher au moins une cases</div> 
						<br /><label for="descriptionLivraison" class="boldLabels">Décrivez la livraison : </label><br />
						<div class="errorForm" id="errorLivraison">Veuillez saisir 255 caractères maximum</div> 
						<textarea name="descriptionLivraison" id="areaLivraison" placeholder="255 caractères max."  onkeyup="testDescriptionL();" required></textarea><br /><br />
				</fieldset>	
				<input type="submit" value="Valider" class="inputButtons"/>
				<input type="button" onclick="window.location.replace(\'index.php?page=mesProduits\')" value="Annuler" class="inputButtons"/> 
			</form>
		</div>
		<script>
			majEstimation();
		</script>';
			

	if ($_SESSION['message'] != "") {
		$contenu = $contenu . '
			<script>
				displayOverlay();
			</script>';
		$tpl->set_var("overlay", $_SESSION['message']);
		$_SESSION['message'] = "";
	}
	

	$tpl->set_var("titre", "<h1>Ajoutez un nouveau produit<hr></h1>");
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