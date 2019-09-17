<?php
define('BASEPATH', 'asd');
	// echo 'asd';
// include 'Light.php';
	$lt = new LightTest();
	// $lt->test_check_attack();
	// $lt->test_check_enemy();
	$lt->test_check_speak_to_npc();

class LightTest {

	public function __construct() {
		if(!class_exists('lanterlite')) { include 'init.php'; }
		$this->L = new lanterlite();
    include 'Color.php';
    $this->color = new Color();
    include 'LightClass.php';
    $this->light = new LightClass();
  }

  public function scenario_check_enemy() {
  	$scenario = [];
  	$_scenario['title'] = 'normal case'; $_scenario['e'] = 'true';
  	$_scenario['player'] = $this->L->arr_to_json(array(
  		'pressed_keys'=>array($this->light->rhand_key), 
  		'char_id'=>'enigma', 
  		'enemies'=>array('ifandhanip'), 
  		'move_directions' => 'north', 
  		'position' => array('x' => 10, 'z' => 11)
  	));
  	$_scenario['other_players'] = array(
  		$this->L->arr_to_json(array('char_id'=>'ifandhanip', 'move_directions' => 'north', 'position' => array('x' => 10, 'z' => 8))),
  		$this->L->arr_to_json(array('char_id'=>'asd', 'move_directions' => 'north', 'position' => array('x' => 10, 'z' => 8)))
  	);
  	array_push($scenario, $_scenario);

  	$_scenario['title'] = 'no enemy'; $_scenario['e'] = 'false';
  	$_scenario['player'] = $this->L->arr_to_json(array(
  		'pressed_keys'=>array($this->light->rhand_key), 
  		'char_id'=>'enigma', 
  		'enemies'=>[], 
  		'move_directions' => 'north', 
  		'position' => array('x' => 10, 'z' => 11)
  	));
  	$_scenario['other_players'] = array(
  		$this->L->arr_to_json(array('char_id'=>'ifandhanip', 'move_directions' => 'north', 'position' => array('x' => 10, 'z' => 8))),
  		$this->L->arr_to_json(array('char_id'=>'asd', 'move_directions' => 'north', 'position' => array('x' => 10, 'z' => 8)))
  	);
  	array_push($scenario, $_scenario);
  	return $scenario;
  }

  public function test_check_enemy() {
  	echo "### check_enemy function test";
  	echo "\n";

  	$scenario = $this->scenario_check_enemy();

  	for ($i=0; $i<sizeof($scenario); $i++) {
	    $is_attack_successfully = $this->light->check_enemy($scenario[$i]['player'], $scenario[$i]['other_players']);
	    $r = ($is_attack_successfully) ? 'true' : 'false';
	    $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	    echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	}
  	echo "\n";
  }

  public function scenario_check_speak_to_npc() {
  	$scenario = [];
  	$move_directions = array('north');
  	$_scenario['title'] = 'north normal case'; $_scenario['e'] = 'true';
  	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key), 'move_directions' => $move_directions, 'position' => array('x' => 15.3, 'z' => 18.9)));
  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 15, 'z' => 15)));
  	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'x match'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 9, 'z' => 11)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'x not match'; $_scenario['e'] = 'false';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 8, 'z' => 11)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'z match'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 13)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'z not match'; $_scenario['e'] = 'false';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 14)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);

		// $move_directions = array('south');
  // 	$_scenario['title'] = 'south normal case'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 5)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'x match'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 9, 'z' => 5)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'x not match'; $_scenario['e'] = 'false';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 8, 'z' => 5)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'z match'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 3)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'z not match'; $_scenario['e'] = 'false';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 2)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);

  // 	$move_directions = array('east');
  // 	$_scenario['title'] = 'east normal case'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 7, 'z' => 8)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'x match'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 5, 'z' => 8)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'x not match'; $_scenario['e'] = 'false';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 4, 'z' => 8)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'z match'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 7, 'z' => 9)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'z not match'; $_scenario['e'] = 'false';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 7, 'z' => 10)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);

  // 	$move_directions = array('west');
  // 	$_scenario['title'] = 'west normal case'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 13, 'z' => 8)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'x match'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 15, 'z' => 8)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'x not match'; $_scenario['e'] = 'false';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 16, 'z' => 8)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'z match'; $_scenario['e'] = 'true';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 13, 'z' => 9)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);
  // 	$_scenario['title'] = 'z not match'; $_scenario['e'] = 'false';
  // 	$_scenario['player'] = $this->L->arr_to_json(array('pressed_keys'=>array($this->light->speak_key),'move_directions' => $move_directions, 'position' => array('x' => 13, 'z' => 10)));
  // 	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
  // 	array_push($scenario, $_scenario);

  	return $scenario;
  }

  public function test_check_speak_to_npc() {
  	echo "### check_speak_to_npc function test";
  	echo "\n";

  	$scenario = $this->scenario_check_speak_to_npc();

  	for ($i=0; $i<sizeof($scenario); $i++) {
	    $is_attack_successfully = $this->light->check_speak_to_npc($scenario[$i]['player'], $scenario[$i]['other_player']);
	    $r = ($is_attack_successfully) ? 'true' : 'false';
	    $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	    echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	}
  	// echo "\n";

  	// $scenario = $this->scenario_check_attack('south');

  	// for ($i=0; $i<sizeof($scenario); $i++) {
	  //   $is_attack_successfully = $this->light->check_attack($scenario[$i]['player'], $scenario[$i]['other_player']);
	  //   $r = ($is_attack_successfully) ? 'true' : 'false';
	  //   $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	  //   echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	// }
  	// echo "\n";
  	
  	// $scenario = $this->scenario_check_attack('east');

  	// for ($i=0; $i<sizeof($scenario); $i++) {
	  //   $is_attack_successfully = $this->light->check_attack($scenario[$i]['player'], $scenario[$i]['other_player']);
	  //   $r = ($is_attack_successfully) ? 'true' : 'false';
	  //   $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	  //   echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	// }
  	// echo "\n";
  	
  	// $scenario = $this->scenario_check_attack('west');

  	// for ($i=0; $i<sizeof($scenario); $i++) {
	  //   $is_attack_successfully = $this->light->check_attack($scenario[$i]['player'], $scenario[$i]['other_player']);
	  //   $r = ($is_attack_successfully) ? 'true' : 'false';
	  //   $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	  //   echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	// }
  }

  public function scenario_check_attack($move_directions='north') {
  	if ($move_directions == 'north') {
	  	$scenario = [];
	  	$_scenario['title'] = 'north normal case'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 11)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'x match'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 9, 'z' => 11)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'x not match'; $_scenario['e'] = 'false';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 8, 'z' => 11)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'z match'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 13)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'z not match'; $_scenario['e'] = 'false';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 14)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
  	}

  	else if ($move_directions == 'south') {
	  	$scenario = [];
	  	$_scenario['title'] = 'south normal case'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 5)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'x match'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 9, 'z' => 5)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'x not match'; $_scenario['e'] = 'false';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 8, 'z' => 5)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'z match'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 3)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'z not match'; $_scenario['e'] = 'false';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 10, 'z' => 2)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
  	}

  	else if ($move_directions == 'east') {
	  	$scenario = [];
	  	$_scenario['title'] = 'east normal case'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 7, 'z' => 8)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'x match'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 5, 'z' => 8)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'x not match'; $_scenario['e'] = 'false';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 4, 'z' => 8)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'z match'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 7, 'z' => 9)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'z not match'; $_scenario['e'] = 'false';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 7, 'z' => 10)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
  	}

  	else if ($move_directions == 'west') {
	  	$scenario = [];
	  	$_scenario['title'] = 'west normal case'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 13, 'z' => 8)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'x match'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 15, 'z' => 8)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'x not match'; $_scenario['e'] = 'false';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 16, 'z' => 8)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'z match'; $_scenario['e'] = 'true';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 13, 'z' => 9)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
	  	$_scenario['title'] = 'z not match'; $_scenario['e'] = 'false';
	  	$_scenario['player'] = $this->L->arr_to_json(array('move_directions' => $move_directions, 'position' => array('x' => 13, 'z' => 10)));
	  	$_scenario['other_player'] = $this->L->arr_to_json(array('position' => array('x' => 10, 'z' => 8)));
	  	array_push($scenario, $_scenario);
  	}

  	return $scenario;
  }

  public function test_check_attack() {
  	echo "### check_attack function test";
  	echo "\n";

  	$scenario = $this->scenario_check_attack('north');

  	for ($i=0; $i<sizeof($scenario); $i++) {
	    $is_attack_successfully = $this->light->check_attack($scenario[$i]['player'], $scenario[$i]['other_player']);
	    $r = ($is_attack_successfully) ? 'true' : 'false';
	    $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	    echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	}
  	echo "\n";

  	$scenario = $this->scenario_check_attack('south');

  	for ($i=0; $i<sizeof($scenario); $i++) {
	    $is_attack_successfully = $this->light->check_attack($scenario[$i]['player'], $scenario[$i]['other_player']);
	    $r = ($is_attack_successfully) ? 'true' : 'false';
	    $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	    echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	}
  	echo "\n";
  	
  	$scenario = $this->scenario_check_attack('east');

  	for ($i=0; $i<sizeof($scenario); $i++) {
	    $is_attack_successfully = $this->light->check_attack($scenario[$i]['player'], $scenario[$i]['other_player']);
	    $r = ($is_attack_successfully) ? 'true' : 'false';
	    $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	    echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	}
  	echo "\n";
  	
  	$scenario = $this->scenario_check_attack('west');

  	for ($i=0; $i<sizeof($scenario); $i++) {
	    $is_attack_successfully = $this->light->check_attack($scenario[$i]['player'], $scenario[$i]['other_player']);
	    $r = ($is_attack_successfully) ? 'true' : 'false';
	    $res = ($scenario[$i]['e'] == $r) ? $this->color->fg_color('green', 'true') : $this->color->fg_color('red', 'false');
	    echo '"'.$scenario[$i]['title'].'" '.'(e) '.$scenario[$i]['e'].' '.'(r) '.$r.' => '.$res."\n";
  	}
  }
}



?>