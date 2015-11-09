<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Ajouter un visiteur"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if ( ! estVisiteurConnecte() ) {
      header("Location: cSeConnecter.php");  
  }
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
  $entretiens=visualisationEntretiens();
 ?> 
 <div id="contenu">
      <h2>Visualisation des entretiens</h2>
	  <table>
		<tr>
			<td>Nom du visiteur</td>
			<td>Nom du délégué</td>
			<td>Commentaire</td>
			<td>Note</td>
			<td>Date</td>
		</tr>
		<?php
		foreach($entretiens as $entretien){
			echo 'blabla';
		}
		?>
	  </table>
	  
</div>