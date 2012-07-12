<?php

/**
* Représente un adhérent du BDE
*/
class Adherent_model extends CI_Model {
	/**
    * id identifiant l'adhérent de façon unique
	* @warning 11 chiffres max.
	* @note généré automatiquement par mysql
    * @var int $id
    */
	public $id;
	/**
    * id prénom de l'adhérent
	* @warning 70 caractères max.
    * @var string $prenom
    */
	public $prenom;
	/**
    * nom de l'adhérent
	* @warning 70 caractères max.
    * @var string $nom
    */
	public $nom;
	/**
    * ecole de l'adhérent ('tsp' ou 'tem')
	* @warning 3 caractères max.
    * @var string $ecole
    */
	public $ecole;
	/**
    * sexe de l'adhérent ('m' ou 'f')
	* @warning 1 caractère max.
    * @var string $sexe
    */
	public $sexe;
	/**
    * ecole de l'adhérent ('tsp' ou 'tem')
	* @warning 3 caractères max.
    * @var string $promo
    */
	public $promo;
	/**
    * date de creation de l'adhérent
	* @note exemple '2012-07-14 00:00:00'
	* @note Généré dans ce modèle
    * @var string $creation
    */
	public $creation;
	/**
    * ecole de l'adhérent ('tsp' ou 'tem')
	* @note exemple '2012-07-15 00:00:00'
	* @note Généré et mis à jour automatiquement par mysql
    * @var string $modification
    */
	public $modification;

	function __construct()
	{
		parent::__construct();
	}

	/**
	* Enregistre l'adhérent dans le base de données
	* et retourne son id
	*
	* @return int id de l'adhérent
	*/
	public function enregistrer()
	{
		$data = array(
			'prenom' => $this->prenom,
			'nom' => $this->nom, 
			'ecole' => $this->ecole,
			'sexe' => $this->sexe,
			'promo' => $this->promo,
			'creation' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('adherent', $data);

		return $this->db->insert_id();
	}

	/**
	* Charge les variables d'instaces avec les paramètres
	* d'un adhérent en allant cherchant dans la base de données
	*
	* @param int id de l'adhérent
	* @return Adherent_model objet adhérent
	*/
	public function charger($id)
	{
		$query = $this->db->get_where(
			'adherent',
			array(
				'id' => $id
			)
		);
		
		if ($query->num_rows() != 1)
		{
			return FALSE;
		}
		
		$row = $query->row();
		$this->id = $row->id;
		$this->prenom = $row->prenom;
		$this->nom = $row->nom;
		$this->ecole = $row->ecole;
		$this->sexe = $row->sexe;
		$this->promo = $row->promo;
		$this->creation = $row->creation;
		$this->modification = $row->modification;
		
		return clone $this;
	}

	/**
	* Liste les adhérents selon des critères optionnels de
	* classement et de limite
	*
	* @param int optionnel nombre limite d'adhérents
	* @param int optionnel offset (décalage)
	* @param string optionnel colonne selon laquelle s'effectue l'ordre
	* @param string optionnel direction selon laquelle s'effectue l'ordre ('desc' ou 'asc')
	* @return Adherent_model array tableau des objets des adhérents
	*/
	public function lister($limite=30, $offset=0, $ordre_key='id', $ordre_direction='desc')
	{
		$this->db->select('id');
		$this->db->order_by($ordre_key, $ordre_direction);
		$this->db->limit($limite, $offset);
		$query = $this->db->get('adherent');
		
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}

		$resultat = array();
		foreach($query->result() as $adherent)
		{
			array_push($resultat, $this->load($adherent->id));
		}

		return $resultat;
	}

	/**
	* Cherche des adhérents selon des contraintes
	*
	* @param array tableau associatif des contraintes $colonne => $recherche
	* @param int optionnel nombre limite d'adhérents
	* @param int optionnel offset (décalage)
	* @return int array tableau des id des adhérents
	*         (permet de faire des inclusions, unions, exclusions, ...)
	*/
	public function chercher($contraintes, $limite=0, $offset=0)
	{
		$this->db->select('id');

		foreach($contraintes as $colonne => $recherche)
		{
			if ($recherche)
			{
				// %recherche%
				$this->db->like($colonne, $recherche);
			}
		}

		$this->db->limit($limite, $offset);
		$query = $this->db->get('adherent');

		$resultat = array();

		if ($query->num_rows() == 0)
		{
			return $resultat;
		}

		foreach($query->result() as $adherent)
		{
			array_push($resultat, $adherent->id);
		}

		return $resultat;
	}
}