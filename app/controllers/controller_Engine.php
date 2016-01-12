<?php
class Controller_Engine extends Controller {
	public function action_captcha_check() {
		if (md5($_POST['norobot']) == $_SESSION['randomnr2']) {
			echo "Отлично , кажется, что вы не робот";
		} else {
			echo "вы весьма надоедливый бот!";
		}
	}
	public function action_captcha() {
	// создаем случайное число и сохраняем в сессии
		$randomnr = rand(1000, 9999);
		$_SESSION['randomnr2'] = md5($randomnr);
		//создаем изображение
		$im = imagecreatetruecolor(120, 60);

		//цвета:
		$white = imagecolorallocate($im, 255, 255, 255);
		$blue = imagecolorallocate($im, 0, 0, 255);
		$grey = imagecolorallocate($im, 130, 200, 130);
		$green = imagecolorallocate($im, 0, 255, 0);
		$black = imagecolorallocate($im, 0, 0, 0);

		//imagefilledrectangle($im, 0, 0, 200, 35, $black);
		imagefilledrectangle($im, 0, 0, 120, 60, $white);

		//путь к шрифту:
		$font = $_SERVER["DOCUMENT_ROOT"]."/css/fonts/Karate.ttf";
		//рисуем текст:
		imagettftext($im, 30, 6, 17, 45, $grey, $font, $randomnr);
		imagettftext($im, 26, 8, 15, 50, $blue, $font, $randomnr);

		// предотвращаем кэширование на стороне пользователя
		header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		//отсылаем изображение браузеру
		header("Content-type: image/gif");
		imagegif($im);
		imagedestroy($im);
	}
	
	public function action_catalog() {
		$cnn = new Cnn();
		$cnn->tree();
	}
	public function action_goods_list() {
		$cnn = new Cnn();
		$cnn->get_JSgrid();
	}

	public function action_order_edit() {
		$cnn = new Cnn();
		$cnn->order_edit();
	}
	public function action_order_info() {
		$cnn = new Cnn();
		$cnn->order_info();
	}
	public function action_order_info_full() {
		$cnn = new Cnn();
		$cnn->order_info_full();
	}

	public function action_tree_NS() {
		$cnn = new Cnn();
		$cnn->tree_NS();
	}
//	public function action_goods_list2() {
//		$cnn = new Cnn();
//		$cnn->goods_list();
//	}
	
	function action_jqgrid3() {
		$cnn = new Cnn();
		return $cnn->get_jqgrid3();
	}
	function action_select2() {//for select2
		$cnn = new Cnn();
		return $cnn->select2();
	}
	function action_select_search() {//for select2
		$cnn = new Cnn();
		return $cnn->select_search();
	}

	public function action_tree_json() {
	echo '{
	"rows":[
		{"category_id":"1","name":"ELECTRONICS","price":"0.00","qty_onhand":"0","color":"","lft":"1","rgt":"44","level":"0","uiicon":""},
		{"category_id":"2","name":"TELEVISIONS","price":"0.00","qty_onhand":"0","color":"","lft":"2","rgt":"19","level":"1","uiicon":""},
		{"category_id":"3","name":"TUBE","price":"0.00","qty_onhand":"0","color":"","lft":"3","rgt":"8","level":"2","uiicon":""},
		{"category_id":"11","name":"26 \" TV","price":"200.00","qty_onhand":"1","color":"black","lft":"4","rgt":"5","level":"3","uiicon":"ui-icon-image"},
		{"category_id":"12","name":"30 \" TV","price":"350.00","qty_onhand":"2","color":"black","lft":"6","rgt":"7","level":"3","uiicon":"ui-icon-document"},
		{"category_id":"4","name":"LCD","price":"0.00","qty_onhand":"0","color":"","lft":"9","rgt":"12","level":"2","uiicon":""},
		{"category_id":"13","name":"Super-LCD 42\" ","price":"400.00","qty_onhand":"10","color":"all","lft":"10","rgt":"11","level":"3","uiicon":"ui-icon-video"},
		{"category_id":"5","name":"PLASMA","price":"0.00","qty_onhand":"0","color":"","lft":"13","rgt":"18","level":"2","uiicon":""},
		{"category_id":"14","name":"Ultra-Plasma 62\" ","price":"440.00","qty_onhand":"2","color":"silver","lft":"14","rgt":"15","level":"3","uiicon":"ui-icon-clipboard"},
		{"category_id":"15","name":"Value Plasma 38\" ","price":"312.00","qty_onhand":"0","color":"silver","lft":"16","rgt":"17","level":"3","uiicon":"ui-icon-clipboard"},
		{"category_id":"6","name":"PORTABLE ELECTRONICS","price":"0.00","qty_onhand":"0","color":"","lft":"20","rgt":"43","level":"1","uiicon":""},
		{"category_id":"7","name":"MP3 PLAYERS","price":"0.00","qty_onhand":"0","color":"","lft":"21","rgt":"32","level":"2","uiicon":""},
		{"category_id":"8","name":"FLASH","price":"0.00","qty_onhand":"0","color":"","lft":"22","rgt":"29","level":"3","uiicon":""},
		{"category_id":"17","name":"Super-Shuffle 1gb","price":"20.00","qty_onhand":"11","color":"all","lft":"23","rgt":"24","level":"4","uiicon":"ui-icon-note"},
		{"category_id":"21","name":"5Gb Flash","price":"0.00","qty_onhand":"0","color":"","lft":"25","rgt":"26","level":"4","uiicon":"ui-icon-comment"},
		{"category_id":"22","name":"10Gb  flash ","price":"0.00","qty_onhand":"0","color":"","lft":"27","rgt":"28","level":"4","uiicon":"ui-icon-tag"},
		{"category_id":"16","name":" Power-MP3 128mb","price":"123.00","qty_onhand":"2","color":"withe","lft":"30","rgt":"31","level":"3","uiicon":"ui-icon-signal-diag"},
		{"category_id":"9","name":"CD PLAYERS","price":"0.00","qty_onhand":"0","color":"","lft":"33","rgt":"38","level":"2","uiicon":""},
		{"category_id":"18","name":" Porta CD ","price":"10.00","qty_onhand":"0","color":"","lft":"34","rgt":"35","level":"3","uiicon":"ui-icon-eject"},
		{"category_id":"19","name":"CD To go!","price":"110.00","qty_onhand":"11","color":"","lft":"36","rgt":"37","level":"3","uiicon":"ui-icon-power"},
		{"category_id":"10","name":"2 WAY RADIOS","price":"0.00","qty_onhand":"0","color":"","lft":"39","rgt":"42","level":"2","uiicon":""},
		{"category_id":"20","name":"Family Talk 360 ","price":"200.00","qty_onhand":"15","color":"","lft":"40","rgt":"41","level":"3","uiicon":"ui-icon-volume-on"},
		{"category_id":"23","name":"COMPUTERS","price":"0.00","qty_onhand":"0","color":"","lft":"45","rgt":"50","level":"0","uiicon":""},
		{"category_id":"25","name":"DESKTOP ","price":"0.00","qty_onhand":"0","color":"","lft":"46","rgt":"47","level":"1","uiicon":""},
		{"category_id":"26","name":"LAPTOPS","price":"0.00","qty_onhand":"0","color":"","lft":"48","rgt":"49","level":"1","uiicon":""},
		{"category_id":"24","name":"APPLIANCES","price":"0.00","qty_onhand":"0","color":"","lft":"51","rgt":"52","level":"0","uiicon":""}
	]
}';
		
	}
	
	public function action_404() {
		$this->view->generate('view_template_404.php', 'view_template.php');
	}
}
