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
  
  $idDel = obtenirIdUserConnecte();
  $unVisiteur = lireDonnee("visiteur", "");
  $unCommentaire= lireDonnee("commentaire", "");
  $uneNote= lireDonnee("note", "");
  $uneDate = lireDonnee("date", "");

  if(!$unVisiteur==""){
	  ajouterEntretien($idDel, $unVisiteur, $unCommentaire, $uneNote, $uneDate); 
	  
  }
 


  
  ?>
    <!-- Division principale -->
  <div id="contenu">
      <h2>Ajouter un entretien</h2>
	  <form action="" method="post">
      <div class="corpsForm">
	  
          <input type="hidden" name="etape" value="validerSaisie" />
          <fieldset>
            <legend>Données de l'entretien à entrer
            </legend>
			<table>
			<div class="corpsForm">
			<p>
			<label for="visiteur">Nom du visiteur : </label>
              <input type="text" id="visiteur" name="visiteur" size="25" maxlength="25" 
                     title="Entrez le nom du visiteur"/>
			</p>
			<p>
			<label for="commentaire">Commentaires :</label>
			  <input type="text" id="commentaire" name="commentaire" size="25" maxlength="25" 
                     title="Entrez un commentaire"/>
			</p>
			<p>
			<label for="note">Note :</label>
			  <input type="text" id="note" name="note" size="10" maxlength="6" 
                     title="Entrez une note"/>
			</p>
			<p>
			<label for="date">Date (jj/mm/aaaa) :</label>
			  <input type="text" id="date" name="date" size="25" maxlength="25" 
                     title="Entrez la date de l'entretien"/>
			</p>
			
			
			
			</fieldset>
			<?php
			
			?>
	  </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" 
               title="Enregistrer le nouvel entretien" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>