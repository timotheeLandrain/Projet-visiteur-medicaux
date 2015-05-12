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
  
  $unNom = lireDonnee("nom", "");
  $unPrenom = lireDonnee("prenom", "");
  $uneAdresse= lireDonnee("adresse", "");
  $uneVille= lireDonnee("ville", "");
  $unCP = lireDonnee("codepostale", "");
  $uneDateEmbauche = lireDonnee("dateembauche", "");
  $unMdp= lireDonnee("motdepasse", "");
  $unId="";
  ajouterVisiteur($unNom, $unPrenom, $uneAdresse, $uneVille, $unCP, $uneDateEmbauche, $unId, $unMdp);
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
			<div class="corpsForm">
			<p>
			<label for="nom">Nom : </label>
              <input type="text" id="nom" name="nom" size="12" maxlength="10" 
                     title="Entrez le nom du visiteur"/>
			</p>
			<p>
			<label for="prenom">Prenom :</label>
			  <input type="text" id="prenom" name="prenom" size="12" maxlength="10" 
                     title="Entrez le prenom du visiteur"/>
			</p>
			<p>
			<label for="codepostale">Code Postal :</label>
			  <input type="text" id="codepostale" name="codepostale" size="12" maxlength="10" 
                     title="Entrez le codepostale du visiteur"/>
			</p>
			<p>
			<label for="ville">Ville :</label>
			  <input type="text" id="ville" name="ville" size="12" maxlength="10" 
                     title="Entrez la ville du visiteur"/>
			</p>
			<p>
			<label for="adresse">Adresse :</label>
			  <input type="text" id="adresse" name="adresse" size="12" maxlength="10" 
                     title="Entrez l'adresse du visiteur"/>
			</p>
			<p>
			<label for="DateEmbauche">Date d'embauche :</label>
			  <input type="text" id="dateembauche" name="dateembauche" size="12" maxlength="10" 
                     title="Entrez la date d'embauche du visiteur"/>
			</p>
			<p>
			<label for="MotDePasse">Mot de Passe:</label>
			  <input type="text" id="motdepasse" name="motdepasse" size="12" maxlength="10" 
                     title="Entrez le mot de passe du visiteur"/>
			</p>
			</fieldset>
			<?php
			
			?>
	  </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" 
               title="Enregistrer les nouvelles valeurs des éléments forfaitisés" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>