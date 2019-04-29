<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/slideshow.css"/>
	</head>

	<div id="home-post">
		<div class="contribute-page">
			<table>
				<tr>
					<td class="col-1" rowspan="6">
						<div class="main-title">Contribute by Litegold</div>
						<div class="form-title">You may contribute for the development of Lanterlite products. One of the ways is by buying Litegold. Litegold is a currency that used in future products of Lanterlite. Every contribute You do will empower us to develop our product for achieving our goals. You can read our vision and mission here.</div> 
					</td>
					<td class="col-2-head" colspan="2"> 
						<div class="main-title">Litegold</div> 
						<div class="form-title" id="not-logged-in" style="display: none">Currently You are not logged in. Login first to contribute. If You don't have any account, You may <a id="create-here"href="<?php echo base_url(); ?>register">create here</a>.</div>
					</td>
				</tr>
				<tr id="row-email" style="display: none">
					<td class="col-2" width="180px"> <div class="form-title">Email</div> </td>
					<td class="col-3" width="180px"> <span id="contribute-email"></span> </td>
				</tr>
				<tr id="row-bank-account" style="display: none">
					<td class="col-2" width="200px"> <div class="form-title">Bank Account Name</div> </td>
					<td class="col-3" width="175px"> <input id="contribute-bank-account" type="text" spellcheck="false"> </td>
				</tr>
				<tr id="row-litegold" style="display: none">
					<td class="col-2" width="175px"> <div class="form-title">Litegold to Buy</div> </td>
					<td class="col-3" width="175px"> 
						<input id="contribute-litegold" type="text" spellcheck="false" style="text-indent:100px;" onkeypress="validate(this)" oninput="lgToRp(this)"> 
						<span style="margin-left: 2px" id="contribute-litegold-warn">Litegold</span>
					</td>
				</tr>
				<tr id="row-rupiah" style="display: none">
					<td class="col-2" width="175px"> <div class="form-title">Litegold in Rupiah</div> </td>
					<td class="col-3" width="175px"> 
						<div style="display: inline;">
							<span id="rp">Rp</span> 
							<span id="contribute-rupiah">0</span> 
						</div> 
					</td>
				</tr>
				<tr id="row-button" style="display: none">
					<td class="col-2"> </td>
					<td class="col-3"> <a class="form-title" id="contribute-button" href="<?php echo base_url(); ?>donate">Donate</a> </td>
				</tr>
			</table>
		
		</div>
	</div>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/contribute-page.js"></script>
</html>