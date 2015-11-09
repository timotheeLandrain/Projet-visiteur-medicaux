<?php
	$repInclude = './include/';
	require($repInclude . "_init.inc.php");
	require($repInclude . "_entete.inc.html");
	require($repInclude . "_sommaire.inc.php");
	
	echo "<div id='contenu'>
      <h2>Gestion des entretiens pour délégué</h2>
  </div>";
	echo visiteurEstDelegue($idUser);
	
	require($repInclude . "_pied.inc.html");
	require($repInclude . "_fin.inc.php");
?>