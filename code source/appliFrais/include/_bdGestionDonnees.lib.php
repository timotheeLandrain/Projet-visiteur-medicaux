<?php
/** 
 * Regroupe les fonctions d'acc�s aux donn�es.
 * @package default
 * @author Arthur Martin
 * @todo Fonctions retournant plusieurs lignes sont � r��crire.
 */

/** 
 * Se connecte au serveur de donn�es MySql.                      
 * Se connecte au serveur de donn�es MySql � partir de valeurs
 * pr�d�finies de connexion (h�te, compte utilisateur et mot de passe). 
 * Retourne l'identifiant de connexion si succ�s obtenu, le bool�en false 
 * si probl�me de connexion.
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

	//Modification du jeu de r�ultats en utf8
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
 * Echappe les caract�res sp�ciaux d'une cha�ne.
 * Envoie la cha�ne $str �chapp�e, c�d avec les caract�res consid�r�s sp�ciaux
 * par MySql (tq la quote simple) pr�c�d�s d'un \, ce qui annule leur effet sp�cial
 * @param string $str cha�ne � �chapper
 * @return string cha�ne �chapp�e 
 */    
function filtrerChainePourBD($str) {
    if ( ! get_magic_quotes_gpc() ) { 



        // si la directive de configuration magic_quotes_gpc est activ�e dans php.ini,
        // toute cha�ne re�ue par get, post ou cookie est d�j� �chapp�e 
        // par cons�quent, il ne faut pas �chapper la cha�ne une seconde fois                              
        $str = mysqli_real_escape_string(connecterServeurBD(),$str);
    }
    return $str;
}

/** 
 * Fournit les informations sur un visiteur demand�. 
 * Retourne les informations du visiteur d'id $unId sous la forme d'un tableau
 * associatif dont les cl�s sont les noms des colonnes(id, nom, prenom).
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
function visiteurEstDelegue($unId) {
	$id = filtrerChainePourBD($unId);
	$requete = "select * from delegue where idDel=".$unId."" ;
	$resultat = mysqli_query(connecterServeurBD(),$requete) or die ('Erreur SQL !<br/>'.$requete.'<br/>');
	$type = "delegue";
	if (mysqli_num_rows($resultat)==0){
		$type="visiteur";
	}

	return $type;
}



function personnelEstRH($unId) {
	$id = filtrerChainePourBD($unId);
	$requete = "select * from rh where id='".$id."'" ;
	$resultat = mysqli_query(connecterServeurBD(),$requete) or die ('Erreur SQL !<br/>'.$requete.'<br/>');
	$res=mysqli_fetch_array($resultat);
	if (count($res)==0){
		$bool=false;
	}
	else{
		$bool=true;
	}
	return $bool;
}


/** 
 * Fournit les informations d'une fiche de frais. 
 * Retourne les informations de la fiche de frais du mois de $unMois (MMAAAA)
 * sous la forme d'un tableau associatif dont les cl�s sont les noms des colonnes
 * (nbJustitificatifs, idEtat, libelleEtat, dateModif, montantValide).
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (MMAAAA)
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
 * V�rifie si une fiche de frais existe ou non. 
 * Retourne true si la fiche de frais du mois de $unMois (MMAAAA) du visiteur 
 * $idVisiteur existe, false sinon.g vtftfv r  
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return bool�en existence ou non de la fiche de frais
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
 * Fournit le mois de la derni�re fiche de frais d'un visiteur.
 * Retourne le mois de la derni�re fiche de frais du visiteur d'id $unIdVisiteur.
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
 * Ajoute une nouvelle fiche de frais et les �l�ments forfaitis�s associ�s, 
 * Ajoute la fiche de frais du mois de $unMois (MMAAAA) du visiteur 
 * $idVisiteur, avec les �l�ments forfaitis�s associ�s dont la quantit� initiale
 * est affect�e � 0. Cl�t �ventuellement la fiche de frais pr�c�dente du visiteur. 
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return void
 */
function ajouterFicheFrais($unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois);
    // modification de la derni�re fiche de frais du visiteur
    $dernierMois = obtenirDernierMoisSaisi($unIdVisiteur);
	$laDerniereFiche = obtenirDetailFicheFrais($dernierMois, $unIdVisiteur);
	if ( is_array($laDerniereFiche) && $laDerniereFiche['idEtat']=='CR'){
		modifierEtatFicheFrais($dernierMois, $unIdVisiteur, 'CL');
	}
    
    // ajout de la fiche de frais � l'�tat Cr��
    $requete = "insert into FicheFrais (idVisiteur, mois, nbJustificatifs, montantValide, idEtat, dateModif) values ('" 
              . $unIdVisiteur 
              . "','" . $unMois . "',0,NULL, 'CR', '" . date("Y-m-d") . "')";
    mysqli_query(connecterServeurBD(),$requete);
    
    // ajout des �l�ments forfaitis�s
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
 * Retourne le texte de la requ�te select concernant les mois pour lesquels un 
 * visiteur a une fiche de frais. 
 * 
 * La requ�te de s�lection fournie permettra d'obtenir les mois (AAAAMM) pour 
 * lesquels le visiteur $unIdVisiteur a une fiche de frais. 
 * @param string $unIdVisiteur id visiteur  
 * @return string texte de la requ�te select
 */                                                 
function obtenirReqMoisFicheFrais($unIdVisiteur) {
    $req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='"
            . $unIdVisiteur . "' order by fichefrais.mois desc ";
    return $req ;
}  
                  
/**
 * Retourne le texte de la requ�te select concernant les �l�ments forfaitis�s 
 * d'un visiteur pour un mois donn�s. 
 * 
 * La requ�te de s�lection fournie permettra d'obtenir l'id, le libell� et la
 * quantit� des �l�ments forfaitis�s de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois    
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return string texte de la requ�te select
 */                                                 
function obtenirReqEltsForfaitFicheFrais($unMois, $unIdVisiteur) {
    $unMois = filtrerChainePourBD($unMois);
    $requete = "select idFraisForfait, libelle, quantite from LigneFraisForfait
              inner join FraisForfait on FraisForfait.id = LigneFraisForfait.idFraisForfait
              where idVisiteur='" . $unIdVisiteur . "' and mois='" . $unMois . "'";
    return $requete;
}

/**
 * Retourne le texte de la requ�te select concernant les �l�ments hors forfait 
 * d'un visiteur pour un mois donn�s. 
 * 
 * La requ�te de s�lection fournie permettra d'obtenir l'id, la date, le libell� 
 * et le montant des �l�ments hors forfait de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois    
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur  
 * @return string texte de la requ�te select
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
 * Ins�re dans la BD la ligne hors forfait de libell� $unLibelleHF du montant 
 * $unMontantHF ayant eu lieu � la date $uneDateHF pour la fiche de frais du mois
 * $unMois du visiteur d'id $unIdVisiteur
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (AAMMMM)
 * @param string $unIdVisiteur id du visiteur
 * @param string $uneDateHF date du frais hors forfait
 * @param string $unLibelleHF libell� du frais hors forfait 
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
 * Modifie les quantit�s des �l�ments forfaitis�s d'une fiche de frais. 
 * Met � jour les �l�ments forfaitis�s contenus  
 * dans $desEltsForfaits pour le visiteur $unIdVisiteur et
 * le mois $unMois dans la table LigneFraisForfait, apr�s avoir filtr� 
 * (annul� l'effet de certains caract�res consid�r�s comme sp�ciaux par 
 *  MySql) chaque donn�e   
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (MMAAAA) 
 * @param string $unIdVisiteur  id visiteur
 * @param array $desEltsForfait tableau des quantit�s des �l�ments hors forfait
 * avec pour cl�s les identifiants des frais forfaitis�s 
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
 * Contr�le les informations de connexionn d'un utilisateur.
 * V�rifie si les informations de connexion $unLogin, $unMdp sont ou non valides.
 * Retourne les informations de l'utilisateur sous forme de tableau associatif 
 * dont les cl�s sont les noms des colonnes (id, nom, prenom, login, mdp)
 * si login et mot de passe existent, le bool�en false sinon. 
 * @param resource $idCnx identifiant de connexion
 * @param string $unLogin login 
 * @param string $unMdp mot de passe 
 * @return array tableau associatif ou bool�en false 
 */
function verifierInfosConnexion($unLogin, $unMdp) {
    $unLogin = filtrerChainePourBD($unLogin);
    $unMdp = filtrerChainePourBD($unMdp);
    // le mot de passe est crypt� dans la base avec la fonction de hachage md5
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
 * Modifie l'�tat et la date de modification d'une fiche de frais
 
 * Met � jour l'�tat de la fiche de frais du visiteur $unIdVisiteur pour
 * le mois $unMois � la nouvelle valeur $unEtat et passe la date de modif � 
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

function ajouterVisiteur($unNom, $unPrenom, $uneAdresse, $uneVille, $unCP, $uneDateEmbauche, $unLogin, $unMdp, $delegue,  $idZone) {
	$unNom=filtrerChainePourBD($unNom);
	$unPrenom=filtrerChainePourBD($unPrenom);
	$uneAdresse=filtrerChainePourBD($uneAdresse);
	$uneVille=filtrerChainePourBD($uneVille);
	$unCP=filtrerChainePourBD($unCP);
	$unLogin=filtrerChainePourBD($unLogin);
	$unMdp=filtrerChainePourBD($unMdp);
	$uneDateEmbauche=filtrerChainePourBD(convertirDateFrancaisVersAnglais($uneDateEmbauche));
	$delegue=filtrerChainePourBD($delegue);
	$idZone=filtrerChainePourBD($idZone);
	//Selectionne l'id maximum et rajoute 1
	$id="SELECT MAX(id) as prochainId FROM personnel";
	$resultat = mysqli_query(connecterServeurBD(),$id);
	$ligne=mysqli_fetch_assoc($resultat);
	$prochainId=$ligne["prochainId"];
	$prochainId=$prochainId+1;
	
	$requete = "insert into personnel(id,nom,prenom,login,mdp,adresse,cp,ville,dateEmbauche,idZone) values(".$prochainId.",'" .$unNom."','" .$unPrenom."','".$unLogin."','" .$unMdp."','" .$uneAdresse."','" .$unCP."','" .$uneVille."','".$uneDateEmbauche."',".$idZone.")";
	
	

	mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	
	
	
	
	if($delegue=='delegue')
	{
		$idRh = obtenirIdUserConnecte() ;
		$requeteDelegue="insert into delegue (idDel,idRH) values(".$prochainId.",".$idRh.")";
		mysqli_query(connecterServeurBD(),$requeteDelegue) or die('Error SQL !'.$requeteDelegue);
		$affectation="insert into visiteur(idPers,idDel) values(".$prochainId.",".$prochainId.")";
		mysqli_query(connecterServeurBD(),$affectation) or die('Error SQL !'.$affectation);
	}
	else{
		$requeteTrouverDelegue="select distinct id from personnel p, visiteur v, delegue d where p.id=d.idDel and P.idZone=".$idZone."";
		$resultat=mysqli_query(connecterServeurBD(),$requeteTrouverDelegue) or die('Error SQL !'.$requeteTrouverDelegue);
		$ligne=mysqli_fetch_assoc($resultat);
		$idDel=$ligne['id'];
		$affectation="insert into visiteur(idPers,idDel) values(".$prochainId.",".$idDel.")";
		mysqli_query(connecterServeurBD(),$affectation) or die('Error SQL !'.$affectation);
	}
}


function visualisationEntretiens(){
	$requete="select nom,E.commentaires, E.notes,E.Date  from entretenir E, visiteur V, personnel P where E.idVisiteur=V.idPers and V.idPers=P.id";
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	return $resultat;
}
function donneId($nom){
	$requete="select id from personnel where '".$nom."'=nom";
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	$resultat=$resultat->fetch_row();
	$value=$resultat[0];
	return $value;
}
function selectionneLeDelegue($idPers){
	$requete="select e.idDel from personnel P, entretenir e where P.id=e.idVisiteur and e.idVisiteur=".$idPers."";
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	$resultat=$resultat->fetch_row();
	$value=$resultat[0];
	$requete2="select nom from personnel where id=".$value."";
	$resultat=mysqli_query(connecterServeurBD(),$requete2) or die('Error SQL !'.$requete2);
	$resultat=$resultat->fetch_row();
	$value=$resultat[0];
	
	return $value;
}
function selectionneLesVisiteurs($idDel){
	$requete="select * from personnel P, visiteur V where P.id=V.idPers and V.idDel=".$idDel."";
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	return $resultat;
	
}


function visiteurEstRh($id){
	$rh=false;
	$requete='select id from rh';
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	 while ($ligne=$resultat->fetch_row()){
		 if($id==$ligne[0]){
			 $rh=true;
		 }
	 }
	return $rh;
	
	
}

function selectionVisiteurs(){
	$requete = 'SELECT id,nom,prenom FROM personnel p, visiteur v WHERE p.id = v.idPers';
	$resultat = mysqli_query(connecterServeurBD(), $requete) or die('Error SQL !'.$requete);
	$liste="<select name='visiteur'>";
	while ($data = mysqli_fetch_array($resultat)) {
		$liste.= "<option value=".$data['id'].">".$data['nom']." ".$data['prenom']."</option>";
	}
	return $liste;
}  

function supprimerVisiteur($unId){
	$requete="delete from personnel where id=".$unId."";
	$resultat = mysqli_query(connecterServeurBD(), $requete) or die('Error SQL !'.$requete);
	
	
}

function obtenirVisiteurEntretien($idVisiteur){
	$requete="select * from personnel P, entretenir E where P.id=E.idVisiteur and E.idVisiteur=".$idVisiteur."";
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	$resultat=$resultat->fetch_row();
	return $resultat;
}

function entretienDelegue($idDel){
	$requete="select * from entretenir where idDel=".$idDel." ";
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	return $resultat;
}
<<<<<<< HEAD
=======

function entretienVisiteur($unId){
	$requete="select * from entretenir where idVisiteur=".$unId." ";
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	return $resultat;
}



>>>>>>> 56d5c9d77ac1fd72cb10789a8c01487e163d5d7b

function selectionneRegions(){
	$requete = 'SELECT id, region FROM zone';
	$resultat = mysqli_query(connecterServeurBD(), $requete) or die('Error SQL !'.$requete);
	$liste="<select name='zone'>";
	while ($data = mysqli_fetch_array($resultat)) {
		$liste.= "<option value=".$data['id'].">".$data['region']."</option>";
	}
	$liste.='</select>';
	return $liste;	
}
  

<<<<<<< HEAD
=======

>>>>>>> 56d5c9d77ac1fd72cb10789a8c01487e163d5d7b
function idVisiteurSelonNom($unVisiteur){
	$requete="select id from personnel where personnel.nom like '".$unVisiteur."'";
	$resultat=mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	$resultat=$resultat->fetch_row();
	$unId=$resultat[0];
	return $unId;
}
function ajouterEntretien($idDel, $unVisiteur, $unCommentaire, $uneNote, $uneDate) {
	
	$unVisiteur = filtrerChainePourBD($unVisiteur);
	$unCommentaire= filtrerChainePourBD($unCommentaire);
	$uneNote= filtrerChainePourBD($uneNote);
	$uneDate = filtrerChainePourBD(convertirDateFrancaisVersAnglais($uneDate));
	//Selectionne l'id maximum et rajoute 1
	$id="SELECT MAX(id) as prochainId FROM entretenir";
	$resultat = mysqli_query(connecterServeurBD(),$id);
	$ligne=mysqli_fetch_assoc($resultat);
	$prochainId=$ligne["prochainId"];
	$prochainId=$prochainId+1;
	
	//Retrouve l'id du visiteur a partir de son nom
	$idVisiteur=idVisiteurSelonNom($unVisiteur);
	
	
	$requete = "insert into entretenir(id,idVisiteur,idDel,commentaires,notes,Date) values(".$prochainId.",".$idVisiteur.",".$idDel.",'" .$unCommentaire."',".$uneNote.",'".$uneDate."')";
	


	mysqli_query(connecterServeurBD(),$requete) or die('Error SQL !'.$requete);
	
	
}

function envoyerMail($unObjet, $unMessage){
	ini_set("SMTP","smtp.gmail.com");
	ini_set("smtp_port","25");
	$to="contactrhgsb@gmail.com";
	mail($to, $unObjet, $unMessage);
	
}

	
?>