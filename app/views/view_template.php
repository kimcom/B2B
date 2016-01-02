<?php
if ($_SESSION['bs_style'] == 'bs-cerulean'){
require_once "view_template_header_A15.php";
if($_SESSION['access']) require_once "view_template_menu_A15.php";
}else{
	require_once "view_template_header.php";
	if ($_SESSION['access'])
		require_once "view_template_menu.php";
}
include 'app/views/'.$content_view;

require_once "view_template_footer.php";
?>
