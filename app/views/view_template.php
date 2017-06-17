<?php
//if ($_SESSION['bs_style'] == 'bs-cerulean'){
//require_once "view_template_header_A15.php";
//if($_SESSION['access']) require_once "view_template_menu_A15.php";
//}else{
	if ($content_view == 'view_login_test3.php'){
		include 'app/views/' . $content_view;
	}else{
		require_once "view_template_header.php";
		//if ($_SESSION['banners1'])	require_once "view_template_slider1.php";
		if ($_SESSION['access']) require_once "view_template_menu.php";
		//if ($_SESSION['banners2'])	
		// if ($_SESSION['access']) require_once "view_template_slider2.php";
		// echo   '<script type="text/javascript">
				// $(document).ready(function(){
					// callback = function () {
						// setTimeout(function() {
							// $("#flexslider2").remove();
							// //$("body").attr("style","margin-top: 150px");
							// //$("body, html").animate({height: "150px"}, 1500);
						// }, 500 );
					// };
					// var options = {};
					// setTimeout(function() {
						// $("#flexslider2").hide("blind", options, 1000, callback );
						// //$("#flexslider2").animate({scrollTop: "150px"}, 1500);
					// }, 5000 );
				// });
				// </script>';
		echo  '<section id="main" class="mt10">';
		include 'app/views/'.$content_view;
		if ($content_view != 'view_login.php')	require_once "view_template_footer.php";
		echo  '</section>';
	}
//}

?>
