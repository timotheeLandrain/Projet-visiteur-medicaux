<?php
/** 
 * Regroupe les fonctions d'accès aux données.
 * @package default
 * @author Arthur Martin
 * @todo Fonctions retournant plusieurs lignes sont à réécrire.
 */

/** 
 * Se connecte au serveur de données MySql.                      
 * Se connecte au serveur de données MySql à partir de valeurs
 * prédéfinies de connexion (hôte, compte utilisateur et mot de passe). 
 * Retourne l'identifiant de connexion si succès obtenu, le booléen false 
 * si problème de connexion.
 * @return resource identifiant de connexion
 */
function connecterServeurBD() {
	$mysqli = new mysqli("localhost","root","","gsb_frais");
	
	//Verification de la connexion

	if (mysqli_connect_errno()) {
		printf("Echec de la connexion : %s \n", mysqli_connect_error());
		exit();
		return false;
	}

	//Modification du jeu de réultats en utf8
	$mysqli->set_charset("utf8");
	return $mysqli;
}

function listeVisiteur(){
	$liste = 'SELECT p.nom, p.prenom, p.ville, c.nomCabinet FROM personnel p, visiteur v, medecin m, cabinet c WHERE p.id = v.idPers AND p.id = m.idVisiteur AND m.idCabinet = c.idCabinet';
	$reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
	
	return $reqliste;
}

function listeVisiteurTri(){
	$liste = 'SELECT p.nom, p.prenom, p.ville, c.nomCabinet FROM visiteur v, personnel p, cabinet c, medecin m WHERE p.ville like "'.$_POST['Ville_Choix'].'" AND c.nomCabinet like "'.$_POST['Cabinet_Choix'].'" AND p.id = v.idPers AND p.id = m.idVisiteur AND m.idCabinet = c.idCabinet';
	$reqliste = mysqli_query(connecterServeurBD(), $liste) or die('Erreur SQL !<br />'.$liste.'<br />'.mysqli_error());
	
	return $reqliste;
}

function selectionVille(){
	$listeVille = "SELECT distinct ville FROM visiteur v, personnel p WHERE p.id = v.idPers";
	$reqListeVille = mysqli_query(connecterServeurBD(), $listeVille);
	
	return $reqListeVille;
}

function selectionCabinet(){
	$listeCabinet = "SELECT distinct nomCabinet FROM cabinet";
	$reqListeCabinet = mysqli_query(connecterServeurBD(), $listeCabinet);
	
	return $reqListeCabinet;
}

/**
 * Echappe les caractères spéciaux d'une chaîne.
 * Envoie la chaîne $str échappée, càd avec les caractères considérés spéciaux
 * par MySql (tq la quote simple) précédés d'un \, ce qui annule leur effet spécial
 * @param string $str chaîne à échapper
 * @return string chaîne échappée 
 */    
function filtrerChainePourBD($str) {
    if ( ! get_magic_quotes_gpc() ) { 



        // si la directive de configuration magic_quotes_gpc est activée dans php.ini,
        // toute chaîne reçue par get, post ou cookie est déjà échappée 
        // par conséquent, il ne faut pas échapper la chaîne une seconde fois                              
        $str = mysqli_real_escape_string(connecterServeurBD(),$str);
    }
    return $str;
}

/** 
 * Fournit les informations sur un visiteur demandé. 
 * Retourne les informations du visiteur d'id $unId sous la forme d'un tableau
 * associatif dont les clés sont les noms des colonnes(id, nom, prenom).
 * @param resource $idCnx identifiant de connexion
 * @param string $unId id de l'utilisateur
 * @return array  tableau associatif du visiteur
 */
function obtenirDetailVisiteur($unId) {
    $id = filtrerChainePourBD($unId);
    $requete = "select id, nom, prenom from personnel where id='" . $unId . "'";
    $idJeuRes = mysqli_query(connecterServeurBD(),$requete);  
    $ligne = false;     
    if ( $idJeuRes ) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
        mysqli_free_result($idJeuRes);
    }
    return $ligne ;
}

/** 
 * Fournit les informations d'une fiche de frais. 
 * Retourne les informations de la fiche de frais du mois de $unMois (MMAAAA)
 * sous la forme d'un tableau associatif dont les clés sont les noms des colonnes
 * (nbJustitificatifs, idEtat, libelleEtat, dateModif, montantValide).
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demandé (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return array tableau associatif de la fiche de frais
 */
function obtenirDetailFicheFrais($unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois);
    $ligne = false;
    $requete="select IFNULL(nbJustificatifs,0) as nbJustificatifs, Etat.id as idEtat, libelle as libelleEtat, dateModif, montantValide 
    from FicheFrais inner join Etat on idEtat = Etat.id 
    where idVisiteur='" . $unIdVisiteur . "' and mois='" . $unMois . "'";
    $idJeuRes = mysqli_query(connecterServeurBD(),$requete);  
    if ( $idJeuRes ) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
    }        
    mysqli_free_result($idJeuRes) ;
    
    return $ligne ;
}
              
/** 
 * Vérifie si une fiche de frais existe ou non. 
 * Retourne true si la fiche de frais du mois de $unMois (MMAAAA) du visiteur 
 * $idVisiteur existe, false sinon.g vtftfv r  
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demandé (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return booléen existence ou non de la fiche de frais
 */
function existeFicheFrais($unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois);
    $requete = "select idVisiteur from FicheFrais where idVisiteur='" . $unIdVisiteur . 
              "' and mois='" . $unMois . "'";
    $idJeuRes = mysqli_query(connecterServeurBD(), $requete);  
    $ligne = false ;
    if ( $idJeuRes ) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
        mysqli_free_result($idJeuRes);
    }        
    
    // si $ligne est un tableau, la fiche de frais existe, sinon elle n'exsite pas
    return is_array($ligne) ;
}
/** 
 * Fournit le mois de la dernière fiche de frais d'un visiteur.
 * Retourne le mois de la dernière fiche de frais du visiteur d'id $unIdVisiteur.
 * @param resource $idCnx identifiant de connexion
 * @param string $unIdVisiteur id visiteur  
 * @return string dernier mois sous la forme AAAAMM
 */
function obtenirDernierMoisSaisi($unIdVisiteur) {
	$requete = "select max(mois) as dernierMois from FicheFrais where idVisiteur='" .
				$unIdVisiteur . "'";
	$idJeuRes = mysqli_query(connecterServeurBD(),$requete);
    $dernierMois = false ;
    if ( $idJeuRes ) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
        $dernierMois = $ligne["dernierMois"];
        mysqli_free_result($idJeuRes);
    }        
	return $dernierMois;
}

function deconnecterServeurBD() {
   if (connecterServeurBD()) { mysqli_close (connecterServeurBD()); } 
	
}

/** 
 * Ajoute une nouvelle fiche de frais et les éléments forfaitisés associés, 
 * Ajoute la fiche de frais du mois de $unMois (MMAAAA) du visiteur 
 * $idVisiteur, avec les éléments forfaitisés associés dont la quantité initiale
 * est affectée à 0. Clôt éventuellement la fiche de frais précédente du visiteur. 
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demandé (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return void
 */
function ajouterFicheFrais($unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois);
    // modification de la dernière fiche de frais du visiteur
    $dernierMois = obtenirDernierMoisSaisi($unIdVisiteur);
	$laDerniereFiche = obtenirDetailFicheFrais($dernierMois, $unIdVisiteur);
	if ( is_array($laDerniereFiche) && $laDerniereFiche['idEtat']=='CR'){
		modifierEtatFicheFrais($dernierMois, $unIdVisiteur, 'CL');
	}
    
    // ajout de la fiche de frais à l'état Créé
    $requete = "insert into FicheFrais (idVisiteur, mois, nbJustificatifs, montantValide, idEtat, dateModif) values ('" 
              . $unIdVisiteur 
              . "','" . $unMois . "',0,NULL, 'CR', '" . date("Y-m-d") . "')";
    mysqli_query(connecterServeurBD(),$requete);
    
    // ajout des éléments forfaitisés
    $requete = "select id from FraisForfait";
    $idJeuRes = mysqli_query(connecterServeurBD(),$requete);
    if ( $idJeuRes ) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
        while ( is_array($ligne) ) {
            $idFraisForfait = $ligne["id"];
            // insertion d'une ligne frais forfait dans la base
            $requete = "insert into LigneFraisForfait (idVisiteur, mois, idFraisForfait, quantite)
                        values ('" . $unIdVisiteur . "','" . $unMois . "','" . $idFraisForfait . "',0)";
            mysqli_query(connecterServeurBD(),$requete);
            // passage au frais forfait suivant
            $ligne = mysqli_fetch_assoc ($idJeuRes);
        }
        mysqli_free_result($idJeuRes);;       
    }        
}

/**
 * Retourne le texte de la requête select concernant les mois pour lesquels un 
 * visiteur a une fiche de frais. 
 * 
 * La requête de sélection fournie permettra d'obtenir les mois (AAAAMM) pour 
 * lesquels le visiteur $unIdVisiteur a une fiche de frais. 
 * @param string $unIdVisiteur id visiteur  
 * @return string texte de la requête select
 */                                                 
function obtenirReqMoisFicheFrais($unIdVisiteur) {
    $req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='"
            . $unIdVisiteur . "' order by fichefrais.mois desc ";
    return $req ;
}  
                  
/**
 * Retourne le texte de la requête select concernant les éléments forfaitisés 
 * d'un visiteur pour un mois donnés. 
 * 
 * La requête de sélection fournie permettra d'obtenir l'id, le libellé et la
 * quantité des éléments forfaitisés de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois    
 * @param string $unMois mois demandé (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return string texte de la requête select
 */                                                 
function obtenirReqEltsForfaitFicheFrais($unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois);
    $requete = "select idFraisForfait, libelle, quantite from LigneFraisForfait
              inner join FraisForfait on FraisForfait.id = LigneFraisForfait.idFraisForfait
              where idVisiteur='" . $unIdVisiteur . "' and mois='" . $unMois . "'";
    return $requete;
}

/**
 * Retourne le texte de la requête select concernant les éléments hors forfait 
 * d'un visiteur pour un mois donnés. 
 * 
 * La requête de sélection fournie permettra d'obtenir l'id, la date, le libellé 
 * et le montant des éléments hors forfait de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois    
 * @param string $unMois mois demandé (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return string texte de la requête select
 */                                                 
function obtenirReqEltsHorsForfaitFicheFrais($unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois);
    $requete = "select id, date, libelle, montant from LigneFraisHorsForfait
              where idVisiteur='" . $unIdVisiteur 
              . "' and mois='" . $unMois . "'";
    return $requete;
}

/**
 * Supprime une ligne hors forfait.
 * Supprime dans la BD la ligne hors forfait d'id $unIdLigneHF
 * @param resource $idCnx identifiant de connexion
 * @param string $idLigneHF id de la ligne hors forfait
 * @return void
 */
function supprimerLigneHF($unIdLigneHF) {
    $requete = "delete from LigneFraisHorsForfait where id = " . $unIdLigneHF;
    mysqli_query(connecterServeurBD(),$requete);
}

/**
 * Ajoute une nouvelle ligne hors forfait.
 * Insère dans la BD la ligne hors forfait de libellé $unLibelleHF du montant 
 * $unMontantHF ayant eu lieu à la date $uneDateHF pour la fiche de frais du mois
 * $unMois du visiteur d'id $unIdVisiteur
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demandé (AAMMMM)
 * @param string $unIdVisiteur id du visiteur
 * @param string $uneDateHF date du frais hors forfait
 * @param string $unLibelleHF libellé du frais hors forfait 
 * @param double $unMontantHF montant du frais hors forfait
 * @return void
 */
function ajouterLigneHF($unMois, $unIdVisiteur, $uneDateHF, $unLibelleHF, $unMontantHF) {
    $unLibelleHF = filtrerChainePourBD($unLibelleHF);
    $uneDateHF = filtrerChainePourBD(convertirDateFrancaisVersAnglais($uneDateHF));
    $unMois = filtrerChainePourBD($unMois);
    $requete = "insert into LigneFraisHorsForfait(idVisiteur, mois, date, libelle, montant) 
                values ('" . $unIdVisiteur . "','" . $unMois . "','" . $uneDateHF . "','" . $unLibelleHF . "'," . $unMontantHF .")";
    mysqli_query(connecterServeurBD(),$requete);
}

/**
 * Modifie les quantités des éléments forfaitisés d'une fiche de frais. 
 * Met à jour les éléments forfaitisés contenus  
 * dans $desEltsForfaits pour le visiteur $unIdVisiteur et
 * le mois $unMois dans la table LigneFraisForfait, après avoir filtré 
 * (annulé l'effet de certains caractères considérés comme spéciaux par 
 *  MySql) chaque donnée   
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demandé (MMAAAA) 
 * @param string $unIdVisiteur  id visiteur
 * @param array $desEltsForfait tableau des quantités des éléments hors forfait
 * avec pour clés les identifiants des frais forfaitisés 
 * @return void  
 */
function modifierEltsForfait($unMois, $unIdVisiteur, $desEltsForfait) {
    $unMois=filtrerChainePourBD($unMois);
    $unIdVisiteur=filtrerChainePourBD($unIdVisiteur);
    foreach ($desEltsForfait as $idFraisForfait => $quantite) {
        $requete = "update LigneFraisForfait set quantite = " . $quantite 
                    . " where idVisiteur = '" . $unIdVisiteur . "' and mois = '"
                    . $unMois . "' and idFraisForfait='" . $idFraisForfait . "'";
      mysqli_query(connecterServeurBD(),$requete);
    }
}

/**
 * Contrôle les informations de connexionn d'un utilisateur.
 * Vérifie si les informations de connexion $unLogin, $unMdp sont ou non valides.
 * Retourne les informations de l'utilisateur sous forme de tableau associatif 
 * dont les clés sont les noms des colonnes (id, nom, prenom, login, mdp)
 * si login et mot de passe existent, le booléen false sinon. 
 * @param resource $idCnx identifiant de connexion
 * @param string $unLogin login 
 * @param string $unMdp mot de passe 
 * @return array tableau associatif ou booléen false 
 */
function verifierInfosConnexion($unLogin, $unMdp) {
    $unLogin = filtrerChainePourBD($unLogin);
    $unMdp = filtrerChainePourBD($unMdp);
    // le mot de passe est crypté dans la base avec la fonction de hachage md5
    $req = "select id, nom, prenom, login, mdp from personnel where login='".$unLogin."' and mdp='" . $unMdp . "'";
    $idJeuRes = mysqli_query(connecterServeurBD(),$req);
    $ligne = false;
    if ( $idJeuRes ) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
        mysqli_free_result($idJeuRes);
    }
    return $ligne;
}

/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Met à jour l'état de la fiche de frais du visiteur $unIdVisiteur pour
 * le mois $unMois à la nouvelle valeur $unEtat et passe la date de modif à 
 * la date d'aujourd'hui
 * @param resource $idCnx identifiant de connexion
 * @param string $unIdVisiteur 
 * @param string $unMois mois sous la forme aaaamm
 * @return void 
 */
function modifierEtatFicheFrais($unMois, $unIdVisiteur, $unEtat) {
    $requete = "update FicheFrais set idEtat = '" . $unEtat . 
               "', dateModif = now() where idVisiteur ='" .
               $unIdVisiteur . "' and mois = '". $unMois . "'";
    mysqli_query(connecterServeurBD(),$requete);
}

function ajouterVisiteur($unNom, $unPrenom, $uneAdresse, $uneVille, $unCP, $uneDateEmbauche, $unLogin, $unMdp) {
	$unNom=filtrerChainePourBD($unNom);
	$unPrenom=filtrerChainePourBD($unPrenom);
	$uneAdresse=filtrerChainePourBD($uneAdresse);
	$uneVille=filtrerChainePourBD($uneVille);
	$unCP=filtrerChainePourBD($unCP);
	$unLogin=filtrerChainePourBD($unLogin);
	$unMdp=filtrerChainePourBD($unMdp);
	$uneDateEmbauche=filtrerChainePourBD(convertirDateFrancaisVersAnglais($uneDateEmbauche));
	
	


	$requete = "insert into personnel(id,nom,prenom,login,mdp,adresse,cp,ville,dateEmbauche) values('a89','" .$unNom."','" .$unPrenom."','".$unLogin."','".$unMdp."','" .$uneAdresse."','" .$unCP."','" .$uneVille."','" .$uneDateEmbauche."')";

	$requete2 = "insert into visiteur(idPers) values('a89')";



	mysqli_query(connecterServeurBD(),$requete);	
	mysqli_query(connecterServeurBD(),$requete2);
}  

	
?>