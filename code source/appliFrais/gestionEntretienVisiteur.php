<?php
	$repInclude = './include/';
	require($repInclude . "_init.inc.php");
	require($repInclude . "_entete.inc.html");
	require($repInclude . "_sommaire.inc.php");
	
	echo "<div id='contenu'>
      <h2>Gestion des entretiens pour visiteur</h2>";
  
 ?>
 
<html>
	<table width=500px border=1>
		<tr>
				
				<td>
					Délégué
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
	$entretiens=entretienVisiteur($idUser);
	
	foreach($entretiens as $entretien){
		$delegue=selectionneLeDelegue($idUser);
	?>
			
			<tr>
				
				<td>
					<?php
						echo $delegue ;
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
				<td>
					<form action="envoyerMail.php">
						<input type="submit" name="Contester" type="Contester" value="Contester au RH"/>
					</form>
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