<?php
class Controller_Engine extends Controller {
	public function action_captcha() {
	// создаем случайное число и сохраняем в сессии
		$randomnr = rand(1000, 9999);
		$_SESSION['randomnr2'] = md5($randomnr);
//Fn::debugToLog("captcha set", $randomnr);
//Fn::debugToLog("captcha set", $_SESSION['randomnr2']);
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

	public function action_order_export_csv() {
		$cnn = new Cnn();
		$cnn->order_export_csv();
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
	
	public function action_jqgrid3() {
		$cnn = new Cnn();
		return $cnn->get_jqgrid3();
	}
	public function action_select2() {//for select2
		$cnn = new Cnn();
		return $cnn->select2();
	}
	public function action_select_search() {//for select2
		$cnn = new Cnn();
		return $cnn->select_search();
	}

	public function action_config() {
		$cnn = new Cnn();
		return $cnn->config();
//		if ($_REQUEST['action']=='set') $cnn->config_set();
//		if ($_REQUEST['action']=='get') $cnn->config_get();
	}

	public function action_404() {
		$this->view->generate('view_template_404.php', 'view_template.php');
	}
	public function action_banners() {
		foreach ($_REQUEST as $arg => $val) ${$arg} = $val;
		if ($id=='1') $_SESSION['banners1'] = $_SESSION['banners1'] == false;
		if ($id=='2') $_SESSION['banners2'] = $_SESSION['banners2'] == false;
		header('Location:' . $_SERVER['HTTP_REFERER']);
	}
	
	public function action_upload(){
//		Fn::debugToLog("_FILES", json_encode($_FILES));
		$output_dir = "users_csv/";
		if (isset($_FILES["file_csv"])) {
			$ret = array();
//	This is for custom errors;	
			/* 	$custom_error= array();
			  $custom_error['jquery-upload-file-error']="File already exists";
			  echo json_encode($custom_error);
			  die();
			 */
			$error = $_FILES["file_csv"]["error"];
			//You need to handle  both cases
			//If Any browser does not support serializing of multiple files using FormData() 
			if (!is_array($_FILES["file_csv"]["name"])) { //single file
				$fileName = $_FILES["file_csv"]["name"];
				if(strpos(php_uname(), 'Windows') !== false)
					$fileName = iconv('utf-8','cp1251',$_FILES["file_csv"]["name"]);
				move_uploaded_file($_FILES["file_csv"]["tmp_name"], $output_dir . $fileName);
				$ret[] = $fileName;
			} else {  //Multiple files, file[]
				$fileCount = count($_FILES["file_csv"]["name"]);
				if (strpos(php_uname(), 'Windows') !== false)
					$fileName = iconv('utf-8', 'cp1251', $_FILES["file_csv"]["name"]);
				for ($i = 0; $i < $fileCount; $i++) {
					$fileName = $_FILES["file_csv"]["name"][$i];
					move_uploaded_file($_FILES["file_csv"]["tmp_name"][$i], $output_dir . $fileName);
					$ret[] = $fileName;
				}
			}
			//header("Content-type: application/json;charset=utf8");
			echo json_encode($ret);
		}
	}
	public function action_order_csv_view() {
		$cnn = new Cnn();
		return $cnn->order_csv_view();
	}
	public function action_order_csv_import() {
		$cnn = new Cnn();
		return $cnn->order_csv_import();
	}

	function action_user_info_save() {
		$cnn = new Cnn();
		return $cnn->user_info_save();
	}
	
	function action_feedback() {
		$cnn = new Cnn();
		return $cnn->feedback();
	}
	
	
}
