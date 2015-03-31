<?php
class visiteur
{
	private $id;
	private $nom;
	private $prenom;
	private $login
	private $mdp
	private $adresse
	private $cp
	private $ville
	private $dateEmbauche
	
	public function construc($id,$nom,$prenom,$login,$mdp,$adresse,$cp,$ville,$dateEmbauche)
	{
		$this->id=$id;
		$this->nom=$nom;
		$this->prenom=$prenom;
		$this->login=$login;
		$this->mdp=$mdp;
		$this->adresse=$adresse;
		$this->cp=$cp;
		$this->ville=$ville;
		$this->dateEmbauche=$dateEmbauche;
	}
}