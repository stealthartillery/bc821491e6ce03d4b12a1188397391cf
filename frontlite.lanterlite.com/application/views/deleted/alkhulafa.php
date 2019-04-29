<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/product/slide.css"/>
	</head>

	<body background="<?php echo base_url(); ?>assets/images/bgimage.jpg">
	<div id="home-post">
		<div class="product-page">
			<table>
				<tr>
					<td class="col-1">

						<div class="lt-content" style="max-width:100%">
								<img class="mySlides" src="<?php echo base_url(); ?>assets/images/product/alkhulafa/logo-wide.png" style="width:100%">
								<img class="mySlides" src="<?php echo base_url(); ?>assets/images/product/alkhulafa/01-wide.png" style="width:100%;display:none">
								<img class="mySlides" src="<?php echo base_url(); ?>assets/images/product/alkhulafa/02-wide.png" style="width:100%;display:none">

						  <div class="alkhulafa-list-div">
						    <div class="lt-col s4">
						      <img class="demo lt-opacity lt-hover-opacity-off alkhulafa-img" src="<?php echo base_url(); ?>assets/images/product/alkhulafa/logo-wide.png" onclick="currentDiv(1)">
						    </div>
						    <div class="lt-col s4">
						      <img class="demo lt-opacity lt-hover-opacity-off alkhulafa-img" src="<?php echo base_url(); ?>assets/images/product/alkhulafa/01-wide.png" onclick="currentDiv(2)">
						    </div>
						    <div class="lt-col s4">
						      <img class="demo lt-opacity lt-hover-opacity-off alkhulafa-img" src="<?php echo base_url(); ?>assets/images/product/alkhulafa/02-wide.png" onclick="currentDiv(3)">
						    </div>
						  </div>
						</div>

					</td>
					<td class="col-2">
						<div class="col-text"><b>Short Description:</b></div>
						<div class="col-text">Al-Khulafa Ar-Rashidun Encyclopedia (ID), is an encyclopedia application (using bahasa language) that contains histories about first four leaders in history of Islam after the death of Muhammad (saw.), namely Khulafa'ur Rasyidin (Abu Bakr, 'Umar, 'Uthman, 'Ali radhiallahu'anhuma ajma'iin). The source of reference was taken from the book al-Bidayah wan-Nihayah by al-Hafiz Ibn Kathir, which was revised and rearranged by Dr. Muhammad bin Shamil as-Sulami. This app is available in Google Play Store for free.</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	</body>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/product/alkhulafa-page.js"></script>

</html>
