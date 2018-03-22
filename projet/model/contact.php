<?php
//-----------------test contact----------------------------------


//on init le passage à la ligne(pour les différents types de serveurs)
/*if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)){
	$passage_ligne = "\r\n";
}else{*/
    $passage_ligne = "\n";
//}

//génération de la boundary (prérequis de la fonction mail de php)
$boundary = "-----=".md5(rand());

//génération du MIME-version, utile pour l'interprétation du mail
$mime = 'MIME-Version: 1.0'.$passage_ligne;

//génération du Content-type
$content_mail = 'Content-Type: multipart/alternative;'.$passage_ligne;

/**
*fonction de création du header, réutilisable dans plusieurs cas
*
*@param nom, prénom et mail du contact
*@return le header bien formaté
*/
function header1($nom,$prenom,$mail){
	global $passage_ligne, $boundary , $content_mail, $mime;
	$contact = '"'.$nom.' '.$prenom.'"<'.$mail.'>';
	$header = 'From: '.$contact.$passage_ligne.'Reply-to: '.$contact.$passage_ligne.$mime.$passage_ligne.$content_mail.$passage_ligne.' boundary="'.$boundary.'"'.$passage_ligne;
	return $header;
}

/**
*function pour le formulaire de contact
*
*@param les données du form : nom, prénom, mail, message
*/
function form_contact($nom,$prenom,$mail,$message){
	global $passage_ligne, $boundary;
	$sujet = 'message de'. $prenom . $nom;
	$mail1 = 'commande@L&L.web'; // adresse du webmaster
	$header = header1($nom,$prenom,$mail1);
	$texte = $passage_ligne."--".$boundary.$passage_ligne."Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne."Content-Transfer-Encoding: 8bit".$passage_ligne.$message.$passage_ligne.$passage_ligne."--".$boundary."--".$passage_ligne; 

	mail($mail,$sujet,$texte,$header);
}



