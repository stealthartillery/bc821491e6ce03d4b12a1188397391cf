<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

// include 'LanterSword/globvar.php';
// include 'LanterSword/Gen.php';
// include 'LanterSword/inventory.php';
// include 'LanterSword/guild.php';

// if(!class_exists('lanterlite')) { include BASE_DIR . 'init.php'; }
// $L = new Lanterlite();

// echo 'asd';

$LightGen = new LightGen();
// if(!class_exists('lanterlite')) { include 'init.php'; }
// $this->L = new Lanterlite();

include 'LanterSword/Global.php';
include 'LanterSword/Guild.php'; $guild = new Guild();
include 'LanterSword/Confirmation.php'; $confirmation = new Confirmation();
include 'LanterSword/Friendlist.php'; $friendlist = new Friendlist();
include 'LanterSword/Trade.php'; $trade = new Trade();
include 'LanterSword/Duel.php'; $duel = new Duel();
include 'LanterSword/Battle.php'; $battle = new Battle();
include 'LanterSword/Inventory.php'; $inventory = new Inventory();
include 'LanterSword/Gen.php';

class LightGen {

	public function __construct() {
		// if(!class_exists('lanterlite')) { include 'init.php'; }
		// $this->L = new Lanterlite();


		// if(!class_exists('LightClass')) { include 'LightClass.php'; }
		// $this->LightClass = new LightClass();
		// if(!class_exists('PokePlayerClass')) { include 'LanterSword/PokePlayerClass.php'; }
		// $this->PokePlayerClass = new LightClass();
		// if(!class_exists('LanterSwordGenClass')) { include 'LanterSword/LanterSwordGenClass.php'; }
		// $this->LanterSwordGenClass = new LightClass();
		
	}
 
	public function index() {
		// $this->LightClass->test();
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($data)) {
			echo eval($data[DATA]);
		}
	}

}

?>