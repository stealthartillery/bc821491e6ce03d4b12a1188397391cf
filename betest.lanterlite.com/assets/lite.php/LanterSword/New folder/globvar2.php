<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

if(!class_exists('lanterlite')) { include 'init.php'; }
$L = new Lanterlite();
const speed = 2;
define('glob', [
	'speed' => 2,
	'walk_speed' => 1,
	'camera_direction_key' => 1,

	'rhand_key' => 2,
	'lhand_key' => 3,
	'total_item_limit' => 25,
	
	'male_base_atk' => 60,
	'male_base_def' => 40,
	'female_base_atk' => 40,
	'female_base_def' => 60,

	'atk_stamina' => 20,
	'def_stamina' => 5,

	'left_key' => 65,
	'top_key' => 87,
	'right_key' => 68,
	'bottom_key' => 83,

	'circle_key' => 76,
	'cross_key' => 75,
	'triangle_key' => 73,
	'square_key' => 74,

	'r1_key' => 85,
	'r2_key' => 79,
	'l1_key' => 69,
	'l2_key' => 81
]);

// $GLOBALS = $L->arr_to_json(array(
// 	'speed' => 2,
// 	'walk_speed' => 1,
// 	'camera_direction_key' => 1,

// 	'rhand_key' => 2,
// 	'lhand_key' => 3,
// 	'total_item_limit' => 25,
	
// 	'male_base_atk' => 60,
// 	'male_base_def' => 40,
// 	'female_base_atk' => 40,
// 	'female_base_def' => 60,

// 	'atk_stamina' => 20,
// 	'def_stamina' => 5,

// 	'left_key' => 65,
// 	'top_key' => 87,
// 	'right_key' => 68,
// 	'bottom_key' => 83,

// 	'circle_key' => 76,
// 	'cross_key' => 75,
// 	'triangle_key' => 73,
// 	'square_key' => 74,

// 	'r1_key' => 85,
// 	'r2_key' => 79,
// 	'l1_key' => 69,
// 	'l2_key' => 81

// ));

?>