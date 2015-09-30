<?php
$repInclude = './include/';
require($repInclude . "_init.inc.php");

// page inaccessible si visiteur non connecté
if ( ! estVisiteurConnecte() ) 
{
      header("Location: cSeConnecter.php");  
}
require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaire.inc.php");
?>
<form action="tableauDeBordResultat.php"  method=POST>
	<?php
		$liste = 'SELECT id,nom,prenom FROM personnel p, visiteur v WHERE p.id = v.idPers';
		$reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
	?>
	Selectionner un visiteur :
	<select name="visiteur">
	<?php
		while ($data = mysqli_fetch_array($reqliste)) {
		echo "<option value=".$data['id'].">".$data['nom']." ".$data['prenom']."</option>";}?>
</form>
<input type='submit'></input>
<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>