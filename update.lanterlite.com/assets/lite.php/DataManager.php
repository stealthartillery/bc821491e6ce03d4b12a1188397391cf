<?php 
	include 'E:/liteapps/lanterlite.gen.php';
	include 'outermod/Packer.php';
	/*
	 * params of the constructor :
	 * $script:           the JavaScript to pack, string.
	 * $encoding:         level of encoding, int or string :
	 *                    0,10,62,95 or 'None', 'Numeric', 'Normal', 'High ASCII'.
	 *                    default: 62 ('Normal').
	 * $fastDecode:       include the fast decoder in the packed result, boolean.
	 *                    default: true.
	 * $specialChars:     if you have flagged your private and local variables
	 *                    in the script, boolean.
	 *                    default: false.
	 * $removeSemicolons: whether to remove semicolons from the source script.
	 *                    default: true.
	 */
	$src_dir = 'E:/liteapps/__src/';
	$des_dir = $src_dir.'res/';
	$filename = 'test.js';
	$js = file_get_contents($src_dir.$filename);
	$packer = new Tholu\Packer\Packer($js, 'High ASCII', true, false, false);
	$packed_js = $packer->pack();
	// saveFileText($packed_js, $des_dir.$filename);
	echo $packed_js;
?>