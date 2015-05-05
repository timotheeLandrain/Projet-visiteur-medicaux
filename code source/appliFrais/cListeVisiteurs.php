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
		<?php
		$liste = 'SELECT * FROM visiteur';
		$reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
		?>
		<FORM action='cListeVisiteurs.php' method=POST>
		<table align=center, border="1">
			<tr>
				<td>
					<b>Nom</b>
				</td>
			</tr>
		<?php
		while ($data = mysqli_fetch_array($reqliste)) {
		?>
			<tr>
				<td>
				<?php
					echo $data['nom'].'<br />';
				?>
				</td>
			</tr>


		<?php
		}		
		?>
		</table>

  </div>
  
  
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?>
