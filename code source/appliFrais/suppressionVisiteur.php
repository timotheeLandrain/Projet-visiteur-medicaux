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
  $unId = lireDonnee("id", "");
 ?> 
 <div id="contenu">
      <h2>Suppression d'un visiteur</h2>
	   <form action="" method="post">
	  <?php
	  echo selectionVisiteurs()
	  ?>
	  
	  <div class="piedForm">
      <p>
        <input  type="submit" value="Supprimer" size="20" />
      
      </p> 
	  </form>
     
</div>