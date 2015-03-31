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
  ?>
    <!-- Division principale -->
  <div id="contenu">
      <h2>Ajouter un visiteur</h2>
	  <form action="" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerSaisie" />
          <fieldset>
            <legend>Données du visiteur à entrer
            </legend>
			<table>
			
			<label for="nom">Nom : </label>
              <input type="text" id="nom" name="nom" size="12" maxlength="10" 
                     title="Entrez le nom du visiteur"/>
			<INPUT type="submit" value="Valider"/>
			