<?php
/** 
 * Page d'accueil de l'application web AppliFrais
 * @package default
 * @todo  RAS
 */
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
  <!-- Division principale -->
  <div id="contenu">
		<h2>Liste visiteurs</h2>
		<FORM action='cListeVisiteurs.php' method=POST>
			<SELECT name="Ville_Choix">
				<OPTION value="%"> Ville
				<?php
					$choixVille = selectionVille();
					while($take = mysqli_fetch_array($choixVille)){
						?><OPTION><?php echo $take['ville'];
					}
				?>
				<br>
			</SELECT>
			<SELECT name="Cabinet_Choix">
				<OPTION value="%"> Cabinet
				<?php
					$choixCabinet = selectionCabinet();
					while($take = mysqli_fetch_array($choixCabinet)){
						?><OPTION><?php echo $take['nomCabinet'];
					}
				?>
				<br>
			</SELECT>
		<INPUT type="submit" name="OK" value="OK"/>
		</FORM>
		<?php
		if(isset($_POST['OK'])){
		?>
			<FORM action='cListeVisiteurs.php' method=POST>
			<?php
			$liste = listeVisiteurTri();
			?>
			<table align=center, border="1">
				<td>
					<b>Nom</b>
				</td>
				<td>
					<b>Prenom</b>
				</td>
				<td>
					<b>Ville</b>
				</td>
				<td>
					<b>Cabinet</b>
				</td>
			<?php
			while ($data = mysqli_fetch_array($liste)) {
			?>
				<tr>
					<td>
					<?php
						echo $data['nom'].'<br />';
					?>
					</td>
					<td>
					<?php
						echo $data['prenom'].'<br />';
					?>
					</td>
					<td>
					<?php
						echo $data['ville'].'<br />';
					?>
					</td>
					<td>
					<?php
						echo $data['nomCabinet'].'<br />';
					?>
					</td>
				</tr>


			<?php
			}		
			?>
			</table>
			</FORM>
		<?php
		}
		else{
		?>
			<FORM action='cListeVisiteurs.php' method=POST>
			<?php
			$liste = listeVisiteur();
			?>
			<table align=center, border="1">
				<td>
					<b>Nom</b>
				</td>
				<td>
					<b>Prenom</b>
				</td>
				<td>
					<b>Ville</b>
				</td>
				<td>
					<b>Cabinet</b>
				</td>
			<?php
			while ($data = mysqli_fetch_array($liste)) {
			?>
				<tr>
					<td>
					<?php
						echo $data['nom'].'<br />';
					?>
					</td>
					<td>
					<?php
						echo $data['prenom'].'<br />';
					?>
					</td>
					<td>
					<?php
						echo $data['ville'].'<br />';
					?>
					</td>
					<td>
					<?php
						echo $data['nomCabinet'].'<br />';
					?>
					</td>
				</tr>


			<?php
			}		
			?>
			</table>
			</FORM>
		<?php
		}
		?>

  </div>
  
  
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?>
