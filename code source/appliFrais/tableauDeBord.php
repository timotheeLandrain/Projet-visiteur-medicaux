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
		$liste = 'SELECT id,nom,prenom FROM visiteur';																		// <---- ligne a modifier
		$reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
	?>
	Selectionner un visiteur :
	<select name="listeVisiteur">
	<?php
		while ($data = mysqli_fetch_array($reqliste)) {?>
		<option value=<?echo $data['id'];?>><?echo $data['nom']." ".$data['prenom'];?></option>
		<?}?>
</form>
<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>