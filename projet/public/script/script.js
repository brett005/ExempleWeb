window.onload = resizeHeight;

window.addEventListener("resize", resizeHeight);

function resizeHeight() {
	var hauteur = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	if (document.body.scrollHeight > hauteur){
		document.getElementById("footer").style.position = "relative";
	}
	else {document.getElementById("footer").style.position = "absolute";}

}

function testChampsConnexion(){
	resetHeight();
	var erreur = false;

	var pseudo = document.forms["formConnexion"]["pseudo"];
	if (pseudo.value == "") {
		pseudo.style.backgroundColor = "rgba(255,0,0,0.8)";
		erreur = true;
	}
	else{pseudo.style.backgroundColor = "white";}

	var mdp = document.forms["formConnexion"]["mdp"];
	if (mdp.value == "") {
		mdp.style.backgroundColor = "rgba(255,0,0,0.8)";
		erreur = true;
	}
	else{mdp.style.backgroundColor = "white";}

	var incomplet = document.getElementById("incomplet");
	var dejaErreur = incomplet.style.dispparseFloatlay == "block";
	if (erreur) {
		incomplet.style.display = "block";
		if (!dejaErreur) {document.getElementById("espaceConnexion").style.height = document.getElementById("espaceConnexion").offsetHeight + incomplet.offsetHeight + 10 + "px";}
	}
	else{
		if (dejaErreur) {document.getElementById("espaceConnexion").style.height = 190 + "px";}
		incomplet.style.display = "none";
	}
}	

function affichConnexion() {
	var visible = document.getElementById("espaceConnexion").style.display;
	if (visible != "block") {document.getElementById("espaceConnexion").style.display = "block";}
	else {
		document.getElementById("espaceConnexion").style.display= "none";
		resetForm();
	}
}

function resetForm() {
	document.forms["formConnexion"].reset();
	pseudo.style.backgroundColor = "white";
	mdp.style.backgroundColor = "white";
	document.getElementById("incomplet").style.display = "none";
	resetHeight();
}
function resetHeight() {
	document.getElementById("espaceConnexion").style.height = 190 + "px";
}

function refreshPrixSimple(prix, estim) {
	var quantite = document.getElementById("inputQuantiteF").value;

	if (quantite != "") {
		document.getElementById("inputQuantiteF").style.backgroundColor = "white";		
		document.getElementById("refreshF").innerHTML = Math.round(estim*prix*document.getElementById("inputQuantiteF").value*100)/100;
		if(estim != 1){document.getElementById('refreshEstimF').innerHTML = Math.round(estim*quantite*100)/100;}
		document.getElementById('buttonAjout').disabled = false;
	}
	else{
		quantite = 1;
		document.getElementById("inputQuantiteF").style.backgroundColor = "rgba(255,0,0,0.8)";
		document.getElementById("refreshF").innerHTML = Math.round(prix*estim*100)/100;
		if(estim != 1){document.getElementById('refreshEstimF').innerHTML = estim;}
		document.getElementById('buttonAjout').disabled = true;
	}
}

function refreshPrix(id, prix, estim, quantiteInitiale){
	var quantite = document.getElementById("inputQuantite" + id).value;

	if (quantite != "") {
		document.getElementById("inputQuantite" + id).style.backgroundColor = "white";	
		
		document.getElementsByClassName("refresh")[id].innerHTML = Math.round(estim*prix*document.getElementById("inputQuantite" + id).value*100)/100;
		if(estim != 1){document.getElementById('refreshEstim' + id).innerHTML = estim*quantite;}

		if (quantiteInitiale != quantite){
			document.getElementsByClassName("buttonsQuantite")[id].disabled = false;
			document.getElementById('buttonCommande').disabled = true;
			document.getElementById("survolCommande").style.display = "inline-block";
		}
		else{
			document.getElementsByClassName("buttonsQuantite")[id].disabled = true;
			document.getElementById('buttonCommande').disabled = false;
			document.getElementById("survolCommande").style.display = "none";
		}
	}
	else{
		quantite = 1;
		document.getElementById("inputQuantite" + id).style.backgroundColor = "rgba(255,0,0,0.8)";
		document.getElementsByClassName("refresh")[id].innerHTML = Math.round(prix*estim*100)/100;
		document.getElementsByClassName("buttonsQuantite")[id].disabled = true;
		document.getElementById('buttonCommande').disabled = true;
		document.getElementById("survolCommande").style.display = "inline-block";
	}
}

function recapPanier(tabNom, tabPrix, tabQuantite, tabEstim) {
	var contenu = "";
	for (var i = 0; i < tabNom.length; i++) {
		var cout = Math.round(parseFloat(tabPrix[i]) * parseFloat(tabQuantite[i]) * parseFloat(tabEstim[i])*100)/100;
		var coef = Math.round(parseFloat(tabQuantite[i]) * parseFloat(tabEstim[i])*100)/100;
		contenu += "<div class='itemRecap'>	&#9654 <b>" + tabNom[i] + " : </b>" + tabPrix[i] + "€ x " + coef + " &#8680; " + cout + "€</div><br />";
	}
	document.getElementById('recap').innerHTML = contenu;	
}

function modifQuantite(idProduit, idItem) {	
	document.location = "index.php?page=panier&modifId=" + idProduit + "&quantite=" + document.getElementById("inputQuantite" + idItem).value;
}

function testFileValide(input){
	var typesValides = ['image/jpeg', 'image/pjpeg', 'image/png']
	var file = input.files[0];
	var valide = false;

	if (file) {
		var i = 0;
		while( i < typesValides.length && !valide) {
			if(file.type === typesValides[i]) {valide = true;}
			i++;
		}
		if(valide) {
			document.getElementById("choixImage").style.backgroundColor = "rgba(0,255,0,0.8)";		
			document.getElementById("errorImage").style.display = "none";
		}
		else{
			document.getElementById("choixImage").style.backgroundColor = "rgba(255,0,0,0.8)";			
			document.getElementById("errorImage").style.display = "block";
			return false;
		}
	}
	else{
		document.getElementById("choixImage").style.backgroundColor = "rgb(175,175,175)";	
		document.getElementById("errorImage").style.display = "none";
	}
	return true;
}

function checkRadios(){
	var radios = document.getElementsByName('typeDePrix');
	for (var i = 0, length = radios.length; i < length; i++) {
		if ((radios[i].checked && radios[i].value == "fixe") || (!radios[i].checked && radios[i].value == "1")) {
			for (var i = 0; i < document.getElementsByClassName("hidePrix").length; i++) {
				document.getElementsByClassName("hidePrix")[i].style.display = "none";
			}
			document.getElementById("estim").required = false;
			break;
		}
		else{			
			for (var i = 0; i < document.getElementsByClassName("hidePrix").length; i++) {
				document.getElementsByClassName("hidePrix")[i].style.display = "block";
			}
			document.getElementById("estim").required = true;
		}
	}
}

function limitation() {
	var choix1 = document.getElementById('unite').value;
	var optionsChoix2 = document.getElementById('unite2').getElementsByTagName("option");
	for (var i = 0; i < optionsChoix2.length; i++) {
		optionsChoix2[i].style.display = 'block';
		if(optionsChoix2[i].value == choix1){
			optionsChoix2[i].style.display = 'none';
		}
	}
	majEstimation();
}
function majEstimation() {
	document.getElementById('estimUnite').innerHTML = document.getElementById('unite').value;
	document.getElementById('estimUnite2').innerHTML = document.getElementById('unite2').value;
}
function testCheckboxs() {
	if(document.getElementById('livrer').checked == true || document.getElementById('aVenirChercher').checked == true || document.getElementById('aDefinir').checked == true){
		document.getElementById('errorCheckboxs').style.display = "none";
		return true;
	}
	document.getElementById('errorCheckboxs').style.display = "block";
	return false;
}

function testDescriptionP() {
	if(document.getElementById('areaDescription').value.length > 255){
		document.getElementById('errorDescription').style.display = "block";
		return false;
	}
	document.getElementById('errorDescription').style.display = "none";
	return true;
}
function testDescriptionL() {
	if(document.getElementById('areaLivraison').value.length > 255){
		document.getElementById('errorLivraison').style.display = "block";
		return false;
	}
	document.getElementById('errorLivraison').style.display = "none";
	return true;
}
function testUnite() {
	if (document.getElementById('unite').value == document.getElementById('unite2').value) {
		document.getElementById('unite').style.backgroundColor = "rgba(255,0,0,0.8)"
		document.getElementById('unite2').style.backgroundColor = "rgba(255,0,0,0.8)"
		document.getElementById('errorUnite').style.display = "block";
		return false;
	}
	document.getElementById('errorUnite').style.display = "none";
	document.getElementById('unite').style.backgroundColor = "rgb(255,255,255)";
	document.getElementById('unite2').style.backgroundColor = "rgb(255,255,255)";
	return true;
}
function verifFormProduit(){
	window.scrollTo(0,75);
	return testFileValide(document.getElementById('choixImage')) && testUnite() && testCheckboxs() && testDescriptionP() && testDescriptionL() ;
}

function adaptatif(type, prix, id, estim, unite, unite2, tabLivraison){
	var div = "";
	if (type) {
		/* Livraison */
		div += '<hr><br /><div>Type de Livraison : </div>'
		if(tabLivraison.length > 1){
			$checked = "checked";
			for (var i = 0; i < tabLivraison.length; i++) {
				div += '<input type="radio" name="typeLivraison" value="' + tabLivraison[i] + '" ' + $checked + '/> <label for="' + tabLivraison[i]+ '">' + tabLivraison[i] + '</label><br />';
				$checked = "";
			}
			div += '<br /><br />';
		}
		else{
			div += '<div id="typeLivraison">' + tabLivraison[0] + '</div><br />';
		}
		/* */

		/* Quantité */
		div += '<div class="option">Quantité : <input type="number" min="1" max="99" value="1" id="inputQuantiteF" onchange="refreshPrixSimple(' + prix + ',' + estim + ')";> ' + unite + '</div>';

		if(unite != unite2){
			div += ' (~<div id="refreshEstimF">' + estim + '</div>' + unite2 + ')';
		}
		div += '<div class="prixPanier">Prix : <div id="refreshF">' + (Math.round(prix*estim*100)/100) + '</div>€</div><br />';
		document.getElementById('adaptatif').innerHTML = div;
		div += '<button class="inputButtons" title="" id="buttonAjout" onclick="ajoutPanier(' + id + ');"> Ajouter au panier </button></a>';
		/* */
	}
	document.getElementById('adaptatif').innerHTML = div;
}
function ajoutPanier(id){
	var tabLivraison = ["Livraison à domicile","A venir chercher","Contacte le client"];
	var liv = 0;	
	if(document.getElementsByName('typeLivraison').length == 0){
		for (var i = 0; i < tabLivraison.length; i++) {
			if(tabLivraison[i] == document.getElementById('typeLivraison').innerHTML){liv = i+1;}
		}		
	}
	else{
		for (var i = 0; i < document.getElementsByName('typeLivraison').length; i++) {
			if(document.getElementsByName('typeLivraison')[i].checked == true){
				for (var j = 0; j < tabLivraison.length; j++) {
					if(tabLivraison[j] == document.getElementsByName('typeLivraison')[i].value){liv = j+1;}
				}			
			}
		}
	}
	document.location = 'index.php?page=infoProduit&id=' + id + '&quant=' +  document.getElementById('inputQuantiteF').value + '&liv=' + liv;
}
function testPanier(id, tabId) {
	for (var i = 0; i < tabId.length; i++) {
		if (id == tabId[i]){
			document.getElementById('buttonAjout').disabled = true;
			document.getElementById('buttonAjout').title = "Produit déjà dans le panier";
			document.getElementById('inputQuantiteF').disabled = true;
		}
	}
}
function closeOverlay() {
	document.getElementById('overlay').style.display = 'none';
}
function displayOverlay() {
	document.getElementById('overlay').style.display = 'block';
}

function changeCategorie(){
	document.location = "index.php?page=tousLesProduits&cat=" + document.getElementById('affichCat').value;
}

function actualiseSelected(categorie){
	var id = "";
	if(categorie == "all"){id="all";}
	else{id=categorie.substring(0,2);}
	document.getElementById(id).selected = true;
}