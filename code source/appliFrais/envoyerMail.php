<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Envoyer unmail au RH"
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
  
  $unObjet = lireDonnee("objet", "");
  $unMessage = lireDonnee("message", "");
  if(!$unObjet==""){
	  envoyerMail($unObjet, $unMessage);
  }
?>
<form action="" method="post">
 <div id="contenu">
      <h2>Envoyer un e-mail aux Ressources Humaines</h2>
	  <div class="corpsForm">
	  
          <input type="hidden" name="etape" value="validerSaisie" />
          <fieldset>
            <legend>Contenu de l'e-mail
            </legend>
			<table>
			<div class="corpsForm">
			<p>
			<label for="objet">Objet : </label>
              <input type="text" id="objet" name="objet" size="25" maxlength="25" 
                     title="Entrez l'objet"/>
			</p>
			<p>
			<label for="message">Message : </label>
              <textarea name="message" id="message" rows="10" cols="50"></textarea>
			</p>
		   </fieldset>
	 </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" 
               title="Enregistrer l'e-mail" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>

</form>


<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>