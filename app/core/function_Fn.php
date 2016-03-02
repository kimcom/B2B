<?php
class Fn {
	public static function redirectToMain() {
		$host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		header('Location:' . $host);
	}
	
	public static function redirectToController($ControllerName) {
		$host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		header('Location:' . $host . $ControllerName);
	}
	public static function redirectToControllerAndAction($ControllerName,$ActionName) {
		$host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		header('Location:' . $host . $ControllerName . '/' . $ActionName);
	}

	public static function checkErrorMySQLi($mysqli) {
		if ($mysqli->errno) {
//			echo 'mysqli error: ' . $mysqli->errno . ' ' . $mysqli->error.'<br>';
			Fn::ErrorToLog('mysqli error: ' . $mysqli->errno, $mysqli->error);
			return false;
		}
		return true;
	}

	public static function checkErrorMySQLcnn($mysqli) {
		if ($mysqli->connect_errno) {
			Fn::ErrorToLog('mysqli error: ' . $mysqli->connect_errno, $mysqli->connect_error);
			return false;
		}
		return true;
	}

	public static function checkErrorMySQLstmt($stmt) {
		$ar = $stmt->errorInfo();
		if ($stmt->errorCode() > 0 || $ar[1] > 0) {
			Fn::ErrorToLog('stmt error '.$stmt->errorCode(), $ar[1].' '.$ar[2]);
			return false;
		}
		return true;
	}

	public static function writeToLog($ssql) {
		Fn::ErrorToLog('mysql', $ssql . "\n\t\t" . mysql_errno() . ": " . mysql_error());
	}

	public static function debugToLog($Source, $Message) {
		$dir_name = 'Logs';
		$file_name = $dir_name . '/log_' . date('Y-m-d') . '.txt';
		if (!file_exists($dir_name))
			mkdir($dir_name, 0777);
		$fp = fopen($file_name, 'a');
		if (!$fp) {
			echo "Не могу открыть файл ($filename)";
			return;
		}
		if (fwrite($fp, date('Y-m-d H:i:s ') . $Source . ": " . $Message . "\r\n") === FALSE) {
			echo "Не могу произвести запись в файл ($filename)";
			exit;
		}
		fclose($fp);
	}

	public static function errorToLog($Source, $Message) {
//		echo '' . $Source . ': ' . $Message . '<br>';
		$dir_name = 'Logs';
		$file_name = $dir_name . '/error_' . date('Y-m-d') . '.txt';
		if (!file_exists($dir_name))
			mkdir($dir_name, 0777);
		$fp = fopen($file_name, 'a');
		if (!$fp) {
			echo "Не могу открыть файл ($filename)";
			return;
		}
//		$Source = mb_convert_encoding($Source, 'UTF-8');
//		$Message = mb_convert_encoding($Message, 'UTF-8');
		if (fwrite($fp, date('Y-m-d H:i: ') . $Source . ": " . $Message . "\r\n") === FALSE) {
			echo "Не могу произвести запись в файл ($filename)";
			exit;
		}
		fclose($fp);
	}

	public static function paramToLog() {
		ob_start();
		var_dump($_REQUEST);
		Fn::DebugToLog("param\n" . $_SERVER['SCRIPT_FILENAME'] . "\n" . $_SERVER['REQUEST_URI'] . "\n", ob_get_clean());
		ob_end_clean();
	}

	public static function objectToLog($object) {
		ob_start();
		var_dump($object);
		Fn::DebugToLog("param\n" . $_SERVER['SCRIPT_FILENAME'] . "\n" . $_SERVER['REQUEST_URI'] . "\n", ob_get_clean());
		ob_end_clean();
	}
	
	public static function nf($num) {
		return number_format($num, 2, '.', '');
	}

	public static function nfx($num, $count = 0) {
		return number_format($num, $count, '.', '');
	}

	public static function nfx0($num, $count) {
		if ($num == 0) return '';
		return number_format($num, $count, '.', '');
	}
	
	public static function nfPendel($num) {
		if ($num == 0) return '';
		return number_format($num, 2, '.', '');
	}

	public static function nfPendelP($num) {
		if ($num == 0) return '';
		return number_format($num, 2, '.', '').'%';
	}

	public static function isnull($var, $default = null) {
		return is_null($var) ? $default : $var;
	}

	public static function csv_to_array2($file_name) {
		$values = array();
		$row = 1;
		$handle = fopen($file_name, "r");
		//Fn::debugToLog("csv_to_array2", $handle);
		if ($handle !== FALSE) {
			//while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			while (!feof($handle)) {
				$data = fgets($handle, 1000);
				if ($data == null) break;
				$data = iconv('cp1251','utf-8', $data);
				$data = str_getcsv($data,',');
				$num = count($data);
				//$data[$num++] = $row;
				array_push($values, ($data));
				//echo "Строка $row ($num полей): ".json_encode($data)."<br>";//.' '.json_encode($data)."\n";
					//for ($c=0; $c < $num; $c++) {
					//echo $data[$c] . "<br />\n";
					//}
				$row++;
			}
			fclose($handle);
		}
		//echo json_encode($values);
		return $values;
	}

	public static function session_unset($full = false){
		unset($_SESSION['UserID']);
		unset($_SESSION['UserName']);
		unset($_SESSION['UserFIO']);
		unset($_SESSION['UserEMail']);
		unset($_SESSION['UserPost']);
		unset($_SESSION['ClientID']);
		unset($_SESSION['ClientName']);
		unset($_SESSION['StoreID']);
		unset($_SESSION['access']);
		unset($_SESSION['AccessLevel']);
		unset($_SESSION['CurrentOrderID']);
		unset($_SESSION['ViewRemain']);
		if ($full) {
			unset($_SESSION['banners1']);
			unset($_SESSION['banners2']);
			unset($_SESSION['sitename']);
			unset($_SESSION['titlename']);
			unset($_SESSION['company']);
			unset($_SESSION['dbname']);
			unset($_SESSION['siteEmail']);
			unset($_SESSION['adminEmail']);
		}
	}
}
?>