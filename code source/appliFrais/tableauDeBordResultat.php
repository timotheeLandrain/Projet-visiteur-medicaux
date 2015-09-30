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

$idVisiteur=$_POST['visiteur'];
$liste = "SELECT nom,prenom FROM personnel WHERE id = '".$idVisiteur."'";
$reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
while ($data=mysqli_fetch_array($reqliste)){
echo '<h3>Tableau de bord de '.$data['nom'].' '.$data['prenom'].'</h3>';}


require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>