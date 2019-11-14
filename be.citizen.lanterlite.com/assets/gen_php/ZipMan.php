<?php
	/**
	 * 
	 */
	class ZipMan {
		
		function read_zip($zip_dir, $file_dir) {
			$handle = fopen('zip://'.$zip_dir.'#'.$file_dir, 'r'); 
			// $handle = fopen('zip://test.zip#test.txt', 'r'); 
			$result = '';
			if ($handle) {
				while (!feof($handle)) {
				  $result .= fread($handle, 8192);
				}
				fclose($handle);
				return $result;
			}
			return 'cannot read file';
		}

		function read_zip3($zip_dir, $file_dir) {
			$zip = new ZipArchive;
			if ($zip->open($zip_dir) === TRUE) {
			    echo $zip->getFromName($file_dir);
			    $zip->close();
			} else {
			    echo 'failed';
			}
		}
		function read_zip2($zip_dir, $file_dir) {
			$handle = file_get_contents('zip://'.$zip_dir.'#'.$file_dir); 
			if ($handle) {
				return $handle;
			}
			return 'cannot read file';
		}
	}
?>