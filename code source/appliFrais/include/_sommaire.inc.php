<?php
/** 
 * Contient la division pour le sommaire, sujet à des variations suivant la 
 * connexion ou non d'un utilisateur, et dans l'avenir, suivant le type de cet utilisateur 
 * @todo  RAS
 */

?>
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    <?php      
      if (estVisiteurConnecte() ) {
          $idUser = obtenirIdUserConnecte() ;
          $lgUser = obtenirDetailVisiteur($idUser);
          $nom = $lgUser['nom'];
          $prenom = $lgUser['prenom'];
		  $type = "Visiteur médical";
		  if (visiteurEstDelegue($idUser)=="delegue"){
			  $type = "Visiteur médical Délégué";
		  }
		  elseif (personnelEstRh($idUser)){
			  $type = "Ressources Humaines";
		  }
		 
	  
    ?>
        <h2>
    <?php  
            echo $nom . " " . $prenom ;
    ?>
        </h2>
        <h3>
			<?php
				echo $type;
			?>
		</h3>        
    <?php
	  } 
    ?>  
      </div>  
<?php      
  if (estVisiteurConnecte() ) {
?>
        <ul id="menuList">
           <li class="smenu">
              <a href="cAccueil.php" title="Page d'accueil">Accueil</a>
           </li>
           <li class="smenu">
              <a href="cSeDeconnecter.php" title="Se déconnecter">Se déconnecter</a>
           </li>
           <li class="smenu">
              <a href="cSaisieFicheFrais.php" title="Saisie fiche de frais du mois courant">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="cConsultFichesFrais.php" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
		    
           <li class="smenu">
              <a href="cListeVisiteurs.php" title="Consultation des visiteurs">Les visiteurs</a>
           </li>
		   <li class="smenu">
		      <a href="tableauDeBord.php" title="suivi des visiteurs">Tableau de bord</a>
		   </li>
		    <li class="smenu">
		      <a href="gestionEntretien.php" title="Gestion des entretiens">Gestion des entretiens</a>
		   </li>
		   <?php
		   if(visiteurEstDelegue($idUser)=='delegue'){
		   ?>
				<li class="smenu">
		      <a href="ajoutEntretien.php" title="Ajouter un entretien">Ajouter un entretien</a>
		   </li>
		   <?php
		   }
		   ?>
		   <?php
		   if(visiteurEstRh($idUser)==true){
		   ?>
			   <li class="smenu">
				  <a href="AjouterUnVisiteur.php" title="Ajouter un Visiteur">Ajouter un Visiteur</a>
				</li> 
				<li class="smenu">
				  <a href="visualisationEntretienRh.php" title="Visualisation des entretiens">Visualisation des entretiens</a>
			   </li>
			   <li class="smenu">
				  <a href="suppressionVisiteur.php" title="Suppression d'un visiteur">Suppression d'un visiteur</a>
			   </li>
		   <?php } ?>  
         </ul>
        <?php
          // affichage des éventuelles erreurs déjà détectées
          if ( nbErreurs($tabErreurs) > 0 ) {
              echo toStringErreurs($tabErreurs) ;
          }
  }
        ?>
    </div>
    