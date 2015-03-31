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

	//Constructeur de la classe Visiteur
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
	
	//Accesseur de l'attribut ID
	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id=$id;
	}
	
	//Accesseur de l'attribut Nom
	public function getNom()
	{
		return $this->nom;
	}
	public function setNom($nom)
	{
		$this->nom=$nom;
	}
	
	//Accesseur de l'attribut Prenom
	public function getPrenom()
	{
		return $this->prenom;
	}
	public function setPrenom($prenom)
	{
		$this->prenom=$prenom;
	}
	
	//Accesseur de l'attribut login
	public function getLogin()
	{
		return $this->login;
	}
	public function setLogin($login)
	{
		$this->login=$login;
	}
	
	//Accesseur de l'attribut adresse
	public function getAdresse()
	{
		return $this->adresse;
	}
	public function setAdresse($adresse)
	{
		$this->adresse=$adresse;
	}

	//Accesseur de l'attribut cp
	public function getCp()
	{
		return $this->cp;
	}
	public function setCp($cp)
	{
		$this->cp=$cp;
	}
	
	//Accesseur de l'attribut ville
	public function getVille()
	{
		return $this->ville;
	}
	public function setVille($ville)
	{
		$this->ville=$ville;
	}
	//Accesseur de l'attribut dateEmbauche
	public function getDateEmbauche()
	{
		return $this->dateEmbauche;
	}
	public function setDateEmbauche($dateEmbauche)
	{
		$this->dateEmbauche=$dateEmbauche;
	}
}
