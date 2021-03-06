<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Migration_Add_compta_sei_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la table `compta_sei`
			--

			CREATE TABLE IF NOT EXISTS `compta_sei` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`adherent_id` int(11) unsigned NOT NULL,
			`mode_payement` varchar(30) DEFAULT NULL,
			`bbq_paye` tinyint(1) NOT NULL,
			`prix_paye` float DEFAULT NULL,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `adherent_id` (`adherent_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('compta_sei');
	}
}