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
  
  $liste = 'SELECT * FROM visiteur';
  $reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
?>
  <!-- Division principale -->
  <div id="contenu">
		<h2>Liste visiteurs</h2>
		<FORM action='cListeVisiteurs.php' method=POST>
			<SELECT name="Ville_Choix">
				<OPTION value="%"> Ville
				<?php
					$listeVille = "SELECT distinct ville FROM visiteur";
					$reqListeVille = mysqli_query(connecterServeurBD(), $listeVille);
					while($take = mysqli_fetch_array($reqListeVille)){
						?><OPTION><?php echo $take['ville'];
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
			$liste = 'SELECT * FROM visiteur WHERE ville like "'.$_POST['Ville_Choix'].'"';
			$reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
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
			while ($data = mysqli_fetch_array($reqliste)) {
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
						echo 'None<br />';
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
			$liste = 'SELECT * FROM visiteur';
			$reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
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
			while ($data = mysqli_fetch_array($reqliste)) {
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
						echo 'None<br />';
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
