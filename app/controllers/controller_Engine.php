<?php
class Controller_Engine extends Controller {
//получение настроек пользователя
	public function action_filter_save() {
//Fn::debugToLog('filter_save', ($_POST['filter']));
		$filename = "Users\\Setting\\" . $_SESSION['UserID'] . '_' . $_REQUEST['section'] . '_' . $_REQUEST['gridid'] . ".txt";
		$bl = file_put_contents($filename, $_REQUEST['filter']);
		if ($bl == false)
			Fn::debugToLog("Engine", 'ошибка при записи фильтра в файл: ' . $filename);
	}
	public function action_filter_restore() {
		$filename = "Users\\Setting\\" . $_SESSION['UserID'] . '_' . $_REQUEST['section'] . '_' . $_REQUEST['gridid'] . ".txt";
		$handle = @fopen($filename, "r");
		$response = new stdClass();
		if ($handle != null) {
			$response->success = true;
			$response->message = 'ok';
			$response->data = fread($handle, filesize($filename));
			echo json_encode($response);
		} else {
			//Fn::debugToLog("Engine", 'ошибка при чтении фильтра из файла: ' . $filename);
			$response->success = false;
			$response->message = 'Возникла ошибка при получении настроек!<br><br>Сообщите разработчику!';
			$response->data = 0;
			echo json_encode($response);
		}
	}

	public function action_setting_set() {
		$cnn = new Cnn();
		return $cnn->set_report_setting();
	}
	public function action_setting_get() {
		$cnn = new Cnn();
		return $cnn->get_report_setting_list();
	}
	public function action_setting_get_byName() {
		$cnn = new Cnn();
		return $cnn->get_report_setting_byName();
	}

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

	public function action_doc_edit() {
		$cnn = new Cnn();
		$cnn->doc_edit();
	}
	public function action_doc_info_full() {
		$cnn = new Cnn();
		$cnn->doc_info_full();
	}
	public function action_doc_export_csv() {
		$cnn = new Cnn();
		$cnn->doc_export_csv();
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
//		if ($id=='1') $_SESSION['banners1'] = $_SESSION['banners1'] == false;
//		if ($id=='2') $_SESSION['banners2'] = $_SESSION['banners2'] == false;
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

	public function action_user_info_save() {
		$cnn = new Cnn();
		return $cnn->user_info_save();
	}
	
	public function action_feedback() {
		$cnn = new Cnn();
		return $cnn->feedback();
	}
	
	public function action_combobox(){
		$cnn = new Cnn();
		return $cnn->combobox();
	}

	public function action_report5_data() {
		$cnn = new Cnn();
		return $cnn->get_report5_data();
	}

	public function action_get_file() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
		$userFileName = $file_name;
		$report_name = "Users\\Files\\" . $_SESSION['UserID'] . '_' . $report_name . ".xls";
//Fn::debugToLog('get file', $report_name.' '.  $file_name);
		$path = 'php://output';
		$userFileName = $userFileName . ' ' . date('Y-m-d H:i:s') . '.xls';
		$handle = @fopen($report_name, "r");
		if ($handle != null) {
//Fn::debugToLog('get file', filesize($report_name));
			$content = fread($handle, filesize($report_name));
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
//			header("Content-Disposition: attachment; filename=$userFileName;");
			header("Content-Disposition: attachment; filename=\"" . $userFileName . "\";");
			header('Content-Transfer-Encoding: binary');
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: public");
			header('Content-Length: ' . filesize($report_name));
			//header("Content-type: application/vnd.ms-excel");
			file_put_contents($path, $content);
		}
	}
	public function action_set_file() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
//Fn::paramToLog();
		$report_name = "Users\\Files\\" . $_SESSION['UserID'] . '_' . $report_name . ".xls";
//Fn::debugToLog('set file', $report_name);
		//$html = iconv('utf-8', 'cp1251', $html);
		$html = mb_convert_encoding($html, 'cp1251', 'utf-8');
		$content = <<<EOF
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251">
</head>
<body>
	{$html}
</body>
</html>
EOF;
//Fn::debugToLog("html", $content);
		$bl = file_put_contents($report_name, $content);
//Fn::debugToLog('set file',$bl);
	}

}
