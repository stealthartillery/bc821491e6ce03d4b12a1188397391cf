<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Lanterlite</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/experiment/carousel.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css"/>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/header.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/general.js"></script>
 	<style>
	.mySlides {display:none;}
	</style>
    </head>
	<body">

        <style type="text/css">
        </style>
        <div class="experiment">
<!--             <table>
                <tr>
                    <td height="50px" width="50px" bgcolor="#FFFCC9"> </td>
                    <td height="50px" width="50px" bgcolor="#ffffff"> </td>
                </tr>
            </table> 
-->


    <div id="home-post">
        <div class="lt-content lt-section" style="max-width:500px">
            <img src="<?php echo base_url(); ?>assets/images/about/islam.png" style="width:100%">
            <img src="<?php echo base_url(); ?>assets/images/about/islam.png" style="width:100%">
            <img src="<?php echo base_url(); ?>assets/images/about/islam.png" style="width:100%">
            <img src="<?php echo base_url(); ?>assets/images/about/islam.png" style="width:100%">
            <img id="asd" src="<?php echo base_url(); ?>assets/images/about/islam.png" style="width:100%">
            <img class="mySlides lt-animate-fading" src="<?php echo base_url(); ?>assets/images/about/islam.png" style="width:100%">
            <img class="mySlides lt-animate-bottom" src="<?php echo base_url(); ?>assets/images/about/islam.png" style="width:100%">

        </div>

        <script>
        function getPos(el) {
            for (var lx=0, ly=0;
                 el != null;
                 lx += el.offsetLeft, ly += el.offsetTop, el = el.offsetParent);
            return ly
        }

        window.scrollTo(window.scrollX, window.scrollY - 10);
        window.addEventListener("scroll", function(evt) { 

            var scroll = this.scrollY;

            var element = document.getElementById("asd");
            if ((getPos(element) - scroll) < 200) {
                console.log(getPos(element))        
            }
        });

        function offset(el) {
            var rect = el.getBoundingClientRect(),
            scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
            scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
        }

        var element = document.getElementById("asd");
        var rect = element.getBoundingClientRect();
        console.log(rect.top, rect.right, rect.bottom, rect.left);

        var myIndex = 0;
        carousel();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
              x[i].style.display = "none";  
            }
            myIndex++;
            if (myIndex > x.length) {myIndex = 1}    
            x[myIndex-1].style.display = "block";  
            setTimeout(carousel, 10000);    
        }
        </script>

    </div>
        </div>
        <script type="text/javascript">
        </script>
	</body>

</html>