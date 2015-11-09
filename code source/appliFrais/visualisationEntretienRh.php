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
		<tr style="border:2px solid black">
			<td width='150px'>Nom du visiteur</td>
			<td width='150px'>Commentaire</td>
			<td width='150px'>Note</td>
			<td width='150px'>Date</td>
			<td width='150px'>Nom du délégué</td>
		</tr>
		<?php
		foreach($entretiens as $entretien){
			$nomVisiteur=$entretien['nom'];
			$idVisiteur=donneId($nomVisiteur);
			$delegue=selectionneLeDelegue($idVisiteur);
			?>
			<tr>
			
				<?php foreach($entretien as $ligne){ 
					echo '<td>'.$ligne.'</td>'; 
					
					}
				echo '<td>'.$delegue.'</td>';	
					
					
					
				?>
			</tr>
			<?php
		}
		?>
	  </table>
	  
</div>