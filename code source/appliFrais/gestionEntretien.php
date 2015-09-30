<?php
	$repInclude = './include/';
	require($repInclude . "_init.inc.php");
	require($repInclude . "_entete.inc.html");
	require($repInclude . "_sommaire.inc.php");
    $idUser = obtenirIdUserConnecte() ;
	echo visiteurEstDelegue($idUser);
	if (visiteurEstDelegue($idUser) == true){
		header("Location: gestionEntretienDelegue.php");
	}
	else{
		header("Location: gestionEntretienVisiteur.php");
	}
	require($repInclude . "_pied.inc.html");
	require($repInclude . "_fin.inc.php");
?>