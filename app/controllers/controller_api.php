<?php
class Controller_Api extends Controller {
	private $access = false;
	
	function __construct(){
		$cnn = new Cnn();
		$this->access = $cnn->check_auth();
	}
/*
//	function std2simplexml($object, $recursive = false) {
//		$xml = new DOMDocument;
//		$root = $xml->createElement('root');
//		$xml->appendChild($root);
//
//		Fn::debugToLog("object", json_encode($object));
//		foreach ($object as $key => $child) {
//			Fn::debugToLog("key", json_encode($key));
//			Fn::debugToLog("child", json_encode($child));
//			Fn::debugToLog("child is", is_object($child));
//			if (is_object($child)) {
//				$new_xml = std2simplexml($child, true);
//				$new_xml = str_replace(array('', '', ''), '', $new_xml);
//				$el = $xml->createElement($key, $new_xml);
//			$root->appendChild($el);
//			} else {
//				//$el = $xml->createElement($key, $child);
//			}
//		}
//
//		if (!$recursive) {
//			$simple_xml = simplexml_load_string(html_entity_decode($xml->saveXml()));
//			return $simple_xml;
//		} else {
//			return $xml->saveXml();
//		}
//	}

//	function action_jqgrid3() {
//		$cnn = new Cnn();
//		return $cnn->get_jqgrid3();
//	}
//
//	function action_good_getinfo(){
//		if (!$this->access) return;
//		include "app/views/view_template_header_api.php";
//		include 'app/views_bitrix/view_goods_info.php';
//	}
//	function action_good_getinfo2(){
//		if (!$this->access) return;
//		$cnn = new Cnn();
//		$response = $cnn->good_info();
//		header("Content-type: application/json;charset=utf8");
//		echo json_encode($response);
//	}
//	function action_good_getlist_data(){
//		$cnn = new Cnni();
//		return $cnn->get_goods_list();
//	}
//	function action_good_getlist(){
//		if (!$this->access) return;
//		include "app/views/view_template_header_api.php";
//		include 'app/views_bitrix/view_goods_list.php';
//	}
//	function action_good_barcode(){
//		$cnn = new Cnni();
//		return $cnn->get_good_barcode_list();
//	}
//	
//	function action_card_getlist() {
//		if (!$this->access)	return;
//		include "app/views/view_template_header_api.php";
//		include 'app/views_bitrix/view_discountCard_list.php';
//	}
//	function action_card_getinfo() {
//		if (!$this->access)	return;
//		include "app/views/view_template_header_api.php";
//		include 'app/views_bitrix/view_discountCard_attr.php';
//	}
*/
	function action_price_csv() {
		//Fn::debugToLog("access1", 'yes');
		if (!$this->access)	return;
		$v = $_REQUEST['v'];
		if (!isset($v)) {
			echo "Не задан вариант отдачи файла";
			return;
		}
		$cnn = new Cnn();
		$filename = $cnn->price_generate_csv();
		//header("Content-type: application/json;charset=utf8");
		//echo json_encode($response);
		//echo "test ". $filename;
		if ($v == 1) {
			$dt = date('Y/m/d H:i:s');
			$path = 'php://output';
			header('Content-Description: File Transfer');
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes"); 
	//		header('Content-Type: application/csv;charset=cp1251');
			header("Content-Disposition: attachment; filename=\"" . "price_".$_SESSION['ClientID']."_".$dt.".csv\";");
			header('Content-Transfer-Encoding: binary');
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: public");
			header('Content-Length: ' . filesize($filename));
			//file_put_contents($path, $str);
			readfile($filename);
		}else if ($v==2){
			readfile($filename);
		}
	}
	function action_price_json() {
		if (!$this->access)	return;
		//Fn::debugToLog("access2", 'yes');
		$cnn = new Cnn();
		$response = $cnn->price_generate_json();
		header("Access-Control-Allow-Origin: *");
		//header('Access-Control-Allow-Headers "origin, x-requested-with, content-type"');
		header("Content-type: application/json;charset=utf8");
		//Fn::debugToLog('res', json_encode($response));
		echo json_encode($response);
	}

	function action_barcode_csv() {
		//Fn::debugToLog("access1", 'yes');
		if (!$this->access)
			return;
		$v = $_REQUEST['v'];
		if (!isset($v)) {
			echo "Не задан вариант отдачи файла";
			return;
		}
		$cnn = new Cnn();
		$filename = $cnn->barcode_generate_csv();
		//header("Content-type: application/json;charset=utf8");
		//echo json_encode($response);
		//echo "test ". $filename;
		if ($v == 1) {
			$dt = date('Y/m/d');
			$path = 'php://output';
			header('Content-Description: File Transfer');
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			//		header('Content-Type: application/csv;charset=cp1251');
			header("Content-Disposition: attachment; filename=\"" . "barcode_" . $dt . ".csv\";");
			header('Content-Transfer-Encoding: binary');
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: public");
			header('Content-Length: ' . filesize($filename));
			//file_put_contents($path, $str);
			readfile($filename);
		} else if ($v == 2) {
			readfile($filename);
		}
	}

}
?>
