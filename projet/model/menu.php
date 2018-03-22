<?php

$menu = '';
$panier= false;

if(isset($_SESSION['id'])){
	$menu = '
	<nav id="menuderoulant" class="menuCo">
		<ul>
			<li> 
				<a href="index.php?page=tousLesProduits">Tous les produits</a>
				<ul>
					<li><a href="index.php?page=tousLesProduits&amp;cat=1">Alimentaire</a></li>
					<li><a href="index.php?page=tousLesProduits&amp;cat=2">Services</a></li>
					<li><a href="index.php?page=tousLesProduits&amp;cat=3">Matériel</a></li>
					<li><a href="index.php?page=tousLesProduits&amp;cat=4">Custom</a></li>
					<li><a href="index.php?page=tousLesProduits&amp;cat=5">Autre</a></li>
				</ul>
			</li>
			<li> <a href="index.php?page=mesProduits" > Mes produits</a></li>
	    </ul>
	</nav>
	';

	$bouton = '<div class="inputButtons upButton" onclick="document.location = \'./index.php?deco=true\'">Deconnexion</div>';

}else{
	$panier=true;
	$menu = '
		<nav id="menuderoulant" class="menuNonCo">
			<ul>
				<li> <a href="index.php?page=tousLesProduits">Tous les produits</a>
					<ul>
						<li><a href="index.php?page=tousLesProduits&amp;cat=1">Alimentaire</a></li>
						<li><a href="index.php?page=tousLesProduits&amp;cat=2">Services</a></li>
						<li><a href="index.php?page=tousLesProduits&amp;cat=3">Matériel</a></li>
						<li><a href="index.php?page=tousLesProduits&amp;cat=4">Custom</a></li>
						<li><a href="index.php?page=tousLesProduits&amp;cat=5">Autre</a></li>
					</ul>
				</li>
				<li> <a href="index.php?page=inscription" id="login">Inscription</a></li>
				<li> <a href="index.php?page=connexion" id="co">Connexion</a></li> 
				<li> <a href="index.php?page=panier">Panier{montantPanier}</a></li> 
		    </ul>
		</nav>
	';
	$bouton = '
		<div id="bouttonConnexion" onclick="affichConnexion()">Se Connecter<br /><hr />S\'Inscrire</div>
			<div id="espaceConnexion">
				
				<form id="formConnexion" method="post" action="index.php?page=connexion">
					<div id ="fieldSeConnecter">
						<div id="titreConnexion">Se Connecter :</div>
						<div class="groupesConnexion">
							<label>Email</label>
							<input type="email" name="mail" placeholder="Votre mail" id="pseudo"><br />	
							<label>Mot de passe</label>
							<input type="password" name="pass" id="mdp" ><br />	
						</div>
						<div id="incomplet">Veuillez remplir tout les champs !</div>
						<input type="submit" value="Valider" onclick="testChampsConnexion()" class="inputButtons"/>
					</div>
					<div id ="fieldSinscrire">
						<div id="titreInscription">Pas encore de compte ?</div>
						<input type="button" name="sinscrire" value=" S\'Inscrire " class="inputButtons" onclick="window.location.replace(\'index.php?page=inscription\')">
					</div>			
				</form>
			</div>
		</div>';
}