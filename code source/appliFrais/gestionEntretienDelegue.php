<?php
	$repInclude = './include/';
	require($repInclude . "_init.inc.php");
	require($repInclude . "_entete.inc.html");
	require($repInclude . "_sommaire.inc.php");
	
	echo "<div id='contenu'>
      <h2>Gestion des entretiens pour délégué</h2>";
  
 ?>
 
<html>
	<table width=500px border=1>
		<tr>
				
				<td>
					Visiteur
				</td>
				<td>
					Commentaires
				</td>
				<td>
					Note
				</td>
				<td>
					Date
				</td>
			</tr>
	<?php
	$idUser = obtenirIdUserConnecte() ;
	$entretiens=entretienDelegue($idUser);
	
	foreach($entretiens as $entretien){
		$visiteur=obtenirVisiteurEntretien($entretien['idVisiteur']);
	?>
			
			<tr>
				
				<td>
					<?php
						echo $visiteur[1] ;
					?>
				</td>
				<td>
					<?php
						echo $entretien['commentaires'];
					?>
				</td>
				<td>
					<?php
						echo $entretien['notes'];
					?>
				</td>
				<td>
					<?php
						echo $entretien['Date'];
					?>
				</td>
			</tr>
		
			
<?php
	}
?>
			
		
		</table>
	</div>
</html>
		
		
<?php
	
	require($repInclude . "_pied.inc.html");
	require($repInclude . "_fin.inc.php");
?>