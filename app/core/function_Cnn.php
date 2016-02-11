<?php
class Cnn {
	private $db = null;
	public function __construct() {
		try {
			// 192.168.1.3
			$this->db = new PDO('mysql:host=localhost;dbname=' . $_SESSION['dbname'] . ';port=' . $_SESSION['server_port'], $_SESSION['server_user'], $_SESSION['server_pass'], array(1006));
		} catch (PDOException $e) {
			Fn::errorToLog("PDO error!: ", $e->getMessage());
			die();
		}
	}

//controller login
	public function user_list() {
//		$name = "%" . $filter["name"] . "%";
//		$address = "%" . $filter["address"] . "%";
//		$country_id = $filter["country_id"];
//		$sql = "SELECT * FROM clients WHERE name LIKE :name AND address LIKE :address AND (:country_id = 0 OR country_id = :country_id)";
//		$q->bindParam(":name", $name);
//		$q->bindParam(":address", $address);
//		$q->bindParam(":country_id", $country_id);
		$stmt = $this->db->prepare("CALL pr_login('user_list', @id, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->bindParam(2, $userpass, PDO::PARAM_STR);
		$stmt->bindParam(3, $email, PDO::PARAM_STR);
		$stmt->bindParam(4, $fio, PDO::PARAM_STR);
		$stmt->bindParam(5, $post, PDO::PARAM_STR);
		$stmt->bindParam(6, $company, PDO::PARAM_STR);
		$stmt->bindParam(7, $phone, PDO::PARAM_STR);
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) return false;
		$result = array();
		do {
			$rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rowset as $row) {
				array_push($result, ($row));
			}
		} while ($stmt->nextRowset());
//Fn::debugToLog("json", json_encode($result));
		echo json_encode($result);
	}
	public function user_find($username) {
		foreach ($_REQUEST as $arg => $val) ${$arg} = $val;
//Fn::debugToLog("username", $username);
		$stmt = $this->db->prepare("CALL pr_login('user_find', @id, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->bindParam(2, $userpass, PDO::PARAM_STR);
		$stmt->bindParam(3, $email, PDO::PARAM_STR);
		$stmt->bindParam(4, $fio, PDO::PARAM_STR);
		$stmt->bindParam(5, $post, PDO::PARAM_STR);
		$stmt->bindParam(6, $company, PDO::PARAM_STR);
		$stmt->bindParam(7, $phone, PDO::PARAM_STR);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) return false;
		$result = false;
		do {
			$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
			if ($rowset) {
				foreach ($rowset as $row) {
					$_SESSION['UserID'] = $row['UserID'];
					$_SESSION['UserName'] = $row['Username'];
					$_SESSION['UserEMail'] = $row['Email'];
					$_SESSION['UserPost'] = $row['Post'];
					$_SESSION['ClientID'] = $row['CompanyID'];
					$_SESSION['ClientName'] = $row['CompanyName'];
					$_SESSION['AccessLevel'] = $row['AccessLevel'];
					$_SESSION['CurrentOrderID'] = $row['CurrentOrderID'];
					$_SESSION['access'] = true;
					$result = $row['Userpass'];
					break;
				}
			}
		} while ($stmt->nextRowset());
//Fn::debugToLog("$_SESSION", json_encode($_SESSION));
		return $result;
	}
	public function user_find_by_email() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
//Fn::debugToLog("username", $username);
		$response = new stdClass();
		$stmt = $this->db->prepare("CALL pr_login('user_find_by_email', @id, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->bindParam(2, $userpass, PDO::PARAM_STR);
		$stmt->bindParam(3, $email, PDO::PARAM_STR);
		$stmt->bindParam(4, $fio, PDO::PARAM_STR);
		$stmt->bindParam(5, $post, PDO::PARAM_STR);
		$stmt->bindParam(6, $company, PDO::PARAM_STR);
		$stmt->bindParam(7, $phone, PDO::PARAM_STR);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) {
			$ar = $stmt->errorInfo();
			$response->success = false;
			$response->message = "Ошибка доступа!";
			$response->sql = $ar[1] . ' ' . $ar[2];
		} else {
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				if ($rowset) {
					foreach ($rowset as $row) {
						$response->success = ($row[0] != false);
						$response->message = $row[2];
						$response->sql = $row[2];
						$fio = $row['FIO'];
						$user = $row[0];
						$pass = $row[1];
						break;
					}
				}
			} while ($stmt->nextRowset());
		}
//Fn::debugToLog("resp", json_encode($response));
		if ($response->success) {
//оправляем сообщение пользователю
			$subject = 'Восстановление пароля для доступа к информационной системе компании ' . $_SESSION['company'];
			$message = "
Здравствуйте, " . $fio . "!

Вы можете войти в систему по адресу http://" . $_SERVER['HTTP_HOST'] . "/logon

Ваш логин : " . $user . "
Ваш пароль: " . $pass . "

Если вы получили это сообщение по ошибке, не предпринимайте никаких действий. 

Успехов!
------------------
" . $_SESSION['adminEmail'] . "
";
			$sended = Mail::smtpmail($email, $fio, $subject, $message);
			if (!$sended) {
				$response->success = false;
				$response->message = "Ошибка при отправке сообщения с информацией о Вашем доступе!";
			}
			$sended = Mail::smtpmail($_SESSION['adminEmail'], $fio, $subject, $message . 'E-mail:' . $email);
		}
//Fn::debugToLog("resp", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}
	public function user_register() {
		foreach ($_REQUEST as $arg => $val) ${$arg} = $val;
		$response = new stdClass();
//Fn::paramToLog();
		if (md5($captcha) != $_SESSION['randomnr2']) {
			$response->success = false;
			$response->message = "Неверный проверочный код!";
			//$response->sql = "";
			header("Content-type: application/json;charset=utf-8");
			echo json_encode($response);
			return;
		}
		$stmt = $this->db->prepare("CALL pr_login('user_register', @id, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->bindParam(2, $userpass, PDO::PARAM_STR);
		$stmt->bindParam(3, $email, PDO::PARAM_STR);
		$stmt->bindParam(4, $fio, PDO::PARAM_STR);
		$stmt->bindParam(5, $post, PDO::PARAM_STR);
		$stmt->bindParam(6, $company, PDO::PARAM_STR);
		$stmt->bindParam(7, $phone, PDO::PARAM_STR);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) {
			$ar = $stmt->errorInfo();
			$response->success = false;
			$response->message = "Ошибка при регистрации пользователя!";
			//$response->sql = $ar[1] . ' ' . $ar[2];
		} else {
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				if ($rowset) {
					foreach ($rowset as $row) {
						$response->success = ($row[0] != 0);
						$response->message = $row[1];
						//$response->sql = $row[1];
						break;
					}
				}
			} while ($stmt->nextRowset());
		}
//Fn::debugToLog("resp", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}
	public function user_sendmail() {
		foreach ($_REQUEST as $arg => $val) ${$arg} = $val;
		$response = new stdClass();
		$response->success = true;
		$response->message = "Сообщение успешно отправлено!";
		if (md5($captcha) != $_SESSION['randomnr2']) {
			$response->success = false;
			$response->message = "Неверный проверочный код!";
			header("Content-type: application/json;charset=utf-8");
			echo json_encode($response);
			return;
		}
		if ($response->success) {
			$subject = 'Регистрация аккаунта в инф. системе ';
			$message = "
Здравствуйте, " . $fio . "!

Ваш email был зарегистрирован в информационной системе компании " . $_SESSION['company'] . "

ВНИМАНИЕ!!!
Вы сможете работать в нашей системе после идентификации администратором системы.
Сообщение администратору о Вашей регистрации уже отправлено.

Если вы получили это сообщение по ошибке, не предпринимайте никаких действий. 

Успехов!
------------------
" . $_SESSION['adminEmail'] . "
";
//Fn::debugToLog("send", 'start');
			$sended = Mail::smtpmail($email, $fio, $subject, $message);
//Fn::debugToLog("send", 'stop');
			if (!$sended) {
				$response->success = false;
				$response->message = "Ошибка при отправке сообщения с информацией о Вашем доступе!";
			}
//Fn::debugToLog("send", 'start');
			$sended = Mail::smtpmail($_SESSION['adminEmail'], $fio, $subject, $message);
//Fn::debugToLog("send", 'stop');
		}
//Fn::debugToLog("resp", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}
	
	public function user_feedback() {
		foreach ($_REQUEST as $arg => $val) ${$arg} = $val;
		$response = new stdClass();
		$response->success = true;
		$response->message = "Сообщение успешно отправлено!";
		
		if (md5($captcha) != $_SESSION['randomnr2']) {
			$response->success = false;
			$response->message = "Неверный проверочный код!";
			header("Content-type: application/json;charset=utf-8");
			echo json_encode($response);
		}
		
		if ($response->success) {
//Fn::debugToLog("send", 'start');
//Fn::debugToLog("email", $email);
//Fn::debugToLog("fio", $fio);
//Fn::debugToLog("subject", $subject);
//Fn::debugToLog("message", $message);

			//$sended = Mail::smtpmail($email, $fio, $subject, $message);
			
			$sended = Mail::smtpmail($email, $_SESSION['adminEmail'], $fio, $subject, $message);
			if (!$sended) {
				$response->success = false;
				$response->message = "Ошибка при отправке сообщения!";
				echo json_encode($response);
			}
		}
//Fn::debugToLog("resp", json_encode($response));
		Fn::debugToLog("response", $response);
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}

//jsGrid
	function createTree($category, $lft = 0, $rgt = null) {
		$tree = array();
		foreach ($category as $cat => $range) {
			if ($range['lft'] == $lft + 1 && (is_null($rgt) || $range['rgt'] < $rgt)) {
				$cell = array();
				$cell['CatID']   = $range['CatID'];
				$cell['ParentID']   = $range['ParentID'];
				$cell['tags'] = array($range['cnt']);
				$cell['childs'] = $range['cnt'];
				$cell['text'] = $range['Name'];
				if ($range['cnt'] > 0)
					$cell['nodes'] = $this->createTree($category, $range['lft'], $range['rgt']);
				array_push($tree,$cell);
				$lft = $range['rgt'];
			}
		}
		return $tree;
	}
	public function tree() {
		foreach ($_REQUEST as $arg => $val) ${$arg} = $val;
		$stmt = $this->db->prepare("CALL pr_tree_b2b('', @id, ?)");
		$stmt->bindParam(1, $parentid, PDO::PARAM_STR);
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) return false;
		$tree = array();
		do {
			$rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$tree = $this->createTree($rowset, $rowset[0]['lft']-1);
			break;
		} while ($stmt->nextRowset());
//Fn::debugToLog("json tree", json_encode($tree));
		echo json_encode($tree);
	}
	public function get_JSgrid() {
		foreach ($_REQUEST as $arg => $val) ${$arg} = $val;
		$url = urldecode($_SERVER['QUERY_STRING']);
Fn::debugToLog("url", $url);
		$stmt = $this->db->prepare("CALL pr_JSgrid(?, @id, ?)");
		$stmt->bindParam(1, $action, PDO::PARAM_STR);
		$stmt->bindParam(2, $url, PDO::PARAM_STR);
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt))
			return false;
		$result = array();
		do {
			$rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (!empty($rowset[0]['_rows_count'])) continue;
			foreach ($rowset as $row) {
				array_push($result, ($row));
			}
		} while ($stmt->nextRowset());
Fn::debugToLog("json", json_encode($result));
		echo json_encode($result);
	}

//jqGrid
	public function tree_NS() {
		foreach ($_REQUEST as $arg => $val) ${$arg} = $val;
//Fn::paramToLog();
		$stmt = $this->db->prepare("CALL shop.pr_tree_NS('category', 'CatID', ?, ?, ?, ?)");
		$stmt->bindParam(1, $nodeid, PDO::PARAM_STR);
		$stmt->bindParam(2, $n_level, PDO::PARAM_STR);
		$stmt->bindParam(3, $n_left, PDO::PARAM_STR);
		$stmt->bindParam(4, $n_right, PDO::PARAM_STR);
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt))
			return false;
		//$tree = array();
		do {
			$rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//$tree = $this->createTree($rowset, $rowset[0]['lft'] - 1);
			break;
		} while ($stmt->nextRowset());
		
//Fn::DebugToLog('tree result: ', json_encode($rowset));
//return;
		//$result = Shop::GetCategoryTreeNS($this->dbi, $nodeid, $n_level, $n_left, $n_right);
		if ($nodeid > 0) {
			$n_level = $n_level + 1;
		} else {
			$n_level = 0;
		}
		$response = new stdClass();
		$response->page = 1;
		$response->total = 1;
		$response->records = 1;
		$i = 0;
//		while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		if ($rowset) {
				foreach ($rowset as $row) {
				if ($row['rgt'] == $row['lft'] + 1)
					$leaf = 'true';
				else
					$leaf = 'false';
				if ($n_level == $row['level']) { // we output only the needed level
					$response->rows[$i]['id'] = $row['CatID'];
					$response->rows[$i]['cell'] = array($row['CatID'],
						//$row['name'].' ('.$row['CatID'].')',
						$row['name'],
						$row['level'],
						$row['lft'],
						$row['rgt'],
						$leaf,
						'false'
					);
				}
				$i++;
			}
		}
//Fn::DebugToLog('tree result2: ', json_encode($response));
		header("Content-type: text/html;charset=utf-8");
		echo json_encode($response);
	}
	public function get_jqgrid3() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
//Fn::paramToLog();
//Fn::debugToLog('QUERY_STRING', urldecode($_SERVER['QUERY_STRING']));
		$url = urldecode($_SERVER['QUERY_STRING']);
		$url = str_replace("field1", $f1, $url);
		$url = str_replace("field2", $f2, $url);
		$url = str_replace("field3", $f3, $url);
		$url = str_replace("field4", $f4, $url);
		$url = str_replace("field5", $f5, $url);
		$url = str_replace("field6", $f6, $url);
		$url = str_replace("field7", $f7, $url);
		$url = str_replace("field8", $f8, $url);
		$url = str_replace("field9", $f9, $url);
		$url = str_replace("field10", $f10, $url);
		$url = str_replace("field11", $f11, $url);
		$url = str_replace("field12", $f12, $url);
		$url = str_replace("field13", $f13, $url);
		$url = str_replace("field14", $f14, $url);
		$url = str_replace("field15", $f15, $url);

		$url = str_replace("pr.Status=-1", "pr.Status<>100", $url);
		$url = str_replace("pc.Status=-1", "pc.Status<>100", $url);

		$url = str_replace("==", "=", $url);
		$url = str_replace("=>", ">", $url);
		$url = str_replace("=<", "<", $url);
		$url = str_replace("=<>", "<>", $url);
if ($action == 'good_list_b2b'){
	if (isset($Name)||isset($Article)) 
		$url = str_replace("&group=$group", "", $url);
		//Fn::debugToLog('jqgrid3 проверка', "&group=$group");
}
if ($action == 'order_list_b2b'){
	$url .=	"&o.ClientID=".$_SESSION['ClientID'];
}
//Fn::debugToLog('jqgrid3 action', $action);
Fn::debugToLog('jqgrid3 url', $url);
//Fn::paramToLog();

		$stmt = $this->db->prepare("CALL shop.pr_jqgrid(?, @id, ?)");
		$stmt->bindParam(1, $action, PDO::PARAM_STR);
		$stmt->bindParam(2, $url, PDO::PARAM_STR);
		// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt))
			return false;
		$response = new stdClass();
		$response->records = 0;
		$response->page = 0;
		$response->total = 0;
		$r = 0;
		do {
			$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
			if ($rowset) {
				if ($r == 1) {
					$i = 0;
					foreach ($rowset as $row) {
						$response->records = $row['_rows_count'];
						$response->page = $row['_page'];
						$response->total = $row['_total_pages'];
						$i++;
					}
				} else {
					$i = 0;
					$colCount = $stmt->columnCount();
					foreach ($rowset as $row) {
						$response->rows[$i]['id'] = str_replace('.', '_', $row[0]);
						$response->rows[$i]['cell'] = array($row[$f1],
							$row[$f2],
							$row[$f3],
							$row[$f4],
							$row[$f5],
							$row[$f6],
							$row[$f7],
							$row[$f8],
							$row[$f9],
							$row[$f10],
							$row[$f11],
							$row[$f12],
							$row[$f13],
							$row[$f14],
							$row[$f15],
						);
						$i++;
					}
				}
			}
			$r++;
		} while ($stmt->nextRowset());

//Fn::DebugToLog("тест jqgrid3", json_encode($response));
		header("Content-type: application/json;charset=utf8");
		echo json_encode($response);
	}

//for select2
	public function select2() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
//Fn::paramToLog();
//Fn::debugToLog('QUERY_STRING', urldecode($_SERVER['QUERY_STRING']));
		//if ($action != 'unit') $type = $_SESSION['UserID'];
		//if ($action == 'point')	$type = $_SESSION['UserID'];
$name = null;
$type = 1;
		$stmt = $this->db->prepare("CALL shop.pr_select2(?, @id, ?, ?)");
		$stmt->bindParam(1, $action, PDO::PARAM_STR);
		$stmt->bindParam(2, $name, PDO::PARAM_STR);
		$stmt->bindParam(3, $type, PDO::PARAM_STR);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt))
			return false;
		$response = array();
		do {
			$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
			if ($rowset) {
				$i = 0;
				foreach ($rowset as $row) {
					$response[$i] = array('id' => $row[0], 'text' => $row[1]);
					$i++;
				}
			}
		} while ($stmt->nextRowset());
Fn::debugToLog("select2", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}
	public function select_search() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
		$type = 1;
		$stmt = $this->db->prepare("CALL shop.pr_select2(?, @id, ?, ?)");
		$stmt->bindParam(1, $action, PDO::PARAM_STR);
		$stmt->bindParam(2, $name, PDO::PARAM_STR);
		$stmt->bindParam(3, $type, PDO::PARAM_STR);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt))
			return false;
		$response = array();
		do {
			$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
			if ($rowset) {
				$i = 0;
				foreach ($rowset as $row) {
					$response[$i] = array('id' => $row[0], 'name' => $row[1]);
					$i++;
				}
			}
		} while ($stmt->nextRowset());
//Fn::debugToLog("", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}

//order
	public function order_edit(){
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
//Fn::paramToLog();
		if ($orderid == '' ) $orderid = $_SESSION['CurrentOrderID'];
		$response = new stdClass();
		$response->success = false;
		$response->message = "";
		$response->orderid = null;
//		$response->sql = "";
		if ($qty  == '') $qty = null;
		if ($info == '') $info = null;
		$stmt = $this->db->prepare("call pr_order(:action, @_id, :_ClientID, :_OrderID, :_GoodID, :_Qty, :_Info, :_Status, :_UserID, :_DeliveryAddress, :_Notes)");
		$stmt->bindParam(":action", $action);
		$stmt->bindParam(":_ClientID", $_SESSION['ClientID']);
		$stmt->bindParam(":_OrderID", $orderid);
		$stmt->bindParam(":_GoodID", $goodid);
		$stmt->bindParam(":_Qty", $qty);
		$stmt->bindParam(":_Info", $info);
		$stmt->bindParam(":_Status", $status);
		$stmt->bindParam(":_UserID", $_SESSION['UserID']);
		$stmt->bindParam(":_DeliveryAddress", $delivery);
		$stmt->bindParam(":_Notes", $notes);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) {
			$ar = $stmt->errorInfo();
			$response->success = false;
			$response->message = "Ошибка при изменении заказа!";
			//$response->sql = $ar[1] . ' ' . $ar[2];
		} else {
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				if ($rowset) {
					foreach ($rowset as $row) {
						$response->success = ($row[0] != 0);
						$response->message = $row[1];
						$response->orderid = $row['CurrentOrderID'];
						if ($row['CurrentOrderID']!=null) $_SESSION['CurrentOrderID'] = $row['CurrentOrderID'];
						break;
					}
				}
			} while ($stmt->nextRowset());
		}
//Fn::debugToLog("resp", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}
	public function order_info() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
//Fn::paramToLog();
		$response = new stdClass();
		$response->success = false;
		$response->message = "";
		$response->html = "";
		
//		$_SESSION['CurrentOrderID'] = 5;
		$action = 'order_info';
//
		$stmt = $this->db->prepare("call pr_order(:action, @_id, :_ClientID, :_OrderID, :_GoodID, :_Qty, :_Info, :_Status, :_UserID, :_DeliveryAddress, :_Notes)");
		$stmt->bindParam(":action", $action);
		$stmt->bindParam(":_ClientID", $_SESSION['ClientID']);
		$stmt->bindParam(":_OrderID", $_SESSION['CurrentOrderID']);
		$stmt->bindParam(":_GoodID", $goodid);
		$stmt->bindParam(":_Qty", $qty);
		$stmt->bindParam(":_Info", $info);
		$stmt->bindParam(":_Status", $status);
		$stmt->bindParam(":_UserID", $_SESSION['UserID']);
		$stmt->bindParam(":_DeliveryAddress", $delivery);
		$stmt->bindParam(":_Notes", $notes);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) {
			$ar = $stmt->errorInfo();
			$response->success = false;
			$response->message = "Ошибка при получении информации о заказе!";
		} else {
			$cnt = 1;
			$str = '';
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				$response->success = true;
				if ($cnt == 1) {
						$str .= '<table id="table_order" class="table table-striped table-bordered font11 minw300 maxw300" cellspacing="0"  width="100%">';
					foreach ($rowset as $row) {
						$str .= '<thead>
									<tr><th colspan=2>' . $row['Name'] . '</th></tr>
									<tr><th colspan=2>Заказ № ' . $row['OrderID'] . '</th></tr>
									<tr><th colspan=2>Статус: ' . (($row['Status']==0)?'предварительный':'в обработке') . '</th></tr>
								 </thead>';
					}
				}
				if ($cnt == 2) {
						$str .= '<thead><tr>
									<th class="w100 center">Название</th>
									<th class="w30  center">К-во</th></tr>
								 </thead><tbody>';
					foreach ($rowset as $row) {
						$str .= '<tr>
									<td class="TAL">' . $row['Name'] . '</td>
									<td class="TAR">' . $row['Quantity'] . '</td>
								 </tr>';
					}
					if ($stmt->rowCount() == 0) {
						$str .= '<tr><td colspan=2 class="TAC">В заказе нет товаров</td></tr>';
					}
					$str .= '</tbody>';
				}
				if ($cnt == 3) {
					foreach ($rowset as $row) {
						$str .= '<thead>
									<tr><th>Сумма скидки:</th><th class="TAR">' . $row['SumDiscount'] . '</th></tr>
									<tr><th>Сумма заказа:</th><th class="TAR">' . $row['Sum'] . '</th></tr>
								 </thead>';
					}
						$str .= '</table>';
				}
				$cnt++;
			} while ($stmt->nextRowset());
		}
		$response->html = $str;
//Fn::debugToLog("resp", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}
	public function order_info_full() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
//Fn::paramToLog();
		$response = new stdClass();
		$response->success = false;
		$response->message = "";
		$response->html = "";

		$action = 'order_info';
		if ($orderid == '') $orderid = $_SESSION['CurrentOrderID'];

		$stmt = $this->db->prepare("call pr_order(:action, @_id, :_ClientID, :_OrderID, :_GoodID, :_Qty, :_Info, :_Status, :_UserID, :_DeliveryAddress, :_Notes)");
		$stmt->bindParam(":action", $action);
		$stmt->bindParam(":_ClientID", $_SESSION['ClientID']);
		$stmt->bindParam(":_OrderID", $orderid);
		$stmt->bindParam(":_GoodID", $goodid);
		$stmt->bindParam(":_Qty", $qty);
		$stmt->bindParam(":_Info", $info);
		$stmt->bindParam(":_Status", $status);
		$stmt->bindParam(":_UserID", $_SESSION['UserID']);
		$stmt->bindParam(":_DeliveryAddress", $delivery);
		$stmt->bindParam(":_Notes", $notes);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) {
			$ar = $stmt->errorInfo();
			$response->success = false;
			$response->message = "Ошибка при получении информации о заказе!";
		} else {
			$cnt = 1;
			$str = '';
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				$response->success = true;
				if ($cnt == 1) {
					foreach ($rowset as $row) {
//										<h4 class="form-signin-heading center mt10 mb10 TAL floatL">Организация: '.$row['Name'].'</h3>
						$str .= '
								 <input id="orderid" type="hidden" value="' . $row['OrderID'] . '"/>';
						if (!$view)
						$str .= '
								 <div class="row">
									<div id="div_order_buttons" class = "col-md-12 col-xs-12 TAL hidden-print">
<button id="state"		type="button" class="btn btn-success	btn-sm minw150 mb5" title="Отправить заказ поставщику?"><span class="glyphicon glyphicon-ok mr5"></span>В обработку</button>
<button id="print"		type="button" class="btn btn-info		btn-sm minw150 mb5"><span class="glyphicon glyphicon-print mr5"></span>Печать заказа</button>
<button id="export"		type="button" class="btn btn-warning	btn-sm minw150 mb5"><span class="glyphicon glyphicon-export mr5"></span>Експорт в CSV</button>
<button id="delete"		type="button" class="btn btn-danger		btn-sm minw150 mb5"><span class="glyphicon glyphicon-trash mr5"></span>Удалить заказ</button>
<button id="good_add"	type="button" class="btn btn-primary	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>Добавить товар</button>
									</div>
								 </div>';
						$str .= '
								 <div class="row">
									<div class = "col-md-12 col-xs-12">
										<div class = "floatL">
											<div class="input-group input-group-sm w300">
											   <span class = "input-group-addon w130">Заказ №</span>
											   <span class = "input-group-addon form-control TAC">' . $row['OrderID'] . '</span>
											   <span class = "input-group-addon w32"></span>
											</div>
											<div class="input-group input-group-sm w300">
											   <span class = "input-group-addon w130">Статус:</span>
											   <span class = "input-group-addon form-control TAC">' . $row['State'] . '</span>
											   <span class = "input-group-addon w32"></span>
											</div>
										</div>
										<div class="floatL ml10">&nbsp</div>
										<div class="floatL">
										   <div class="input-group input-group-sm w500">
											  <span class = "input-group-addon w130">Адрес доставки:</span>
											  <input type = "text" class = "form-control" ' . ((!$view) ? '' : 'disabled') . ' autofocus value = "'.$row['DeliveryAddress'].'" onchange="good_edit(\'order_edit_delivery\',this,0,0,0,$(this).val(),0);">
											  <span class = "input-group-addon w32"></span>
										   </div>
										   <div class="input-group input-group-sm w500">
											  <span class = "input-group-addon w130">Примечание:</span>
											  <input type = "text" class = "form-control" ' . ((!$view) ? '' : 'disabled') . ' autofocus value = "'.$row['Notes'].'" onchange="good_edit(\'order_edit_notes\',this,0,0,0,0,$(this).val());">
											  <span class = "input-group-addon w32"></span>
										   </div>
										</div>
									</div>
								 </div>
								 ';
					}
				}
				if ($cnt == 2) {
					$str .= '<div class="panel panel-default mt10 mr5 0maxw1000">';
					$str .= '<table id="table_order" class="table table-striped table-bordered font12 minw400" cellspacing="0"  width="100%">';
					$str .= '<thead><tr>
									<th class="w100 center">Артикул</th>
									<th class="w300 center">Название</th>
									<th class="w100 center">Примечание</th>
									<th class="w50  center">К-во</th>
									<th class="w50  center">Прайс</th>
									<th class="w30  center">%</th>
									<th class="w50  center">Скидка</th>
									<th class="w50  center">Цена</th>
									<th class="w70  center">Сумма</th></tr>
								 </thead><tbody>';
					foreach ($rowset as $row) {
						$str .= '<tr>
									<td class="TAL">' . $row['Article'] . '</td>
									<td class="TAL">' . $row['Name'] . '</td>';
						if (!$view){
						$str .= '
									<td class="TAL">
										<input type="text" class="TAL editable inline-edit-cell" style="line-height:17px;width:100%;" min=0 onchange="good_edit(\'order_edit_good_info\',this,'. $row['GoodID'] .',null,$(this).val());" value="' . $row['Info'] . '">
									</td>
									<td class="TAC">
										<input type="number" class="TAR editable inline-edit-cell" style="line-height:17px;width:60%;min-width:40px;" min=0 onchange="good_edit(\'order_edit\',this,'. $row['GoodID'] .',$(this).val(),null);" value="' . $row['Quantity'] . '">
										<span class="ml5 mr5 glyphicon glyphicon-remove hidden-print" onclick="good_edit(\'order_edit\',$(this).prev(),'. $row['GoodID'] .',0);"></span>
									</td>';
						} else {
						$str .= '
									<td class="TAL w150">
										' . $row['Info'] . '
									</td>
									<td class="TAC w70">
										' . $row['Quantity'] . '
									</td>';
						}
						$str .= '
									<td class="TAR">' . $row['PriceBase'] . '</td>
									<td class="TAC">' . $row['DiscountPercent'] . '</td>
									<td class="TAR">' . $row['PriceDiscount'] . '</td>
									<td class="TAR">' . $row['Price'] . '</td>
									<td class="TAR">' . $row['Sum'] . '</td>
								 </tr>';
					}
					if ($stmt->rowCount() == 0){
						$str .= '<tr><td colspan=9 class="TAC">В заказе нет товаров</td></tr>';
					}
					$str .= '</tbody>';
				}
				if ($cnt == 3) {
					foreach ($rowset as $row) {
						$str .= '<tfoot>
									<tr><th colspan=8>Сумма скидки:</th><th class="TAR">' . $row['SumDiscount'] . '</th></tr>
									<tr><th colspan=8>Сумма заказа:</th><th class="TAR">' . $row['Sum'] . '</th></tr>
								 </tfoot>';
					}
					$str .= '</table></div>';
				}
				$cnt++;
			} while ($stmt->nextRowset());
		}
		$response->html = $str;
//Fn::debugToLog("resp", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}
	public function order_export_csv() {
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
//Fn::paramToLog();

//		$_SESSION['CurrentOrderID'] = 5;
		$action = 'order_info';
		$stmt = $this->db->prepare("call pr_order(:action, @_id, :_ClientID, :_OrderID, :_GoodID, :_Qty, :_Info, :_Status, :_UserID, :_DeliveryAddress, :_Notes)");
		$stmt->bindParam(":action", $action);
		$stmt->bindParam(":_ClientID", $_SESSION['ClientID']);
		$stmt->bindParam(":_OrderID", $_SESSION['CurrentOrderID']);
		$stmt->bindParam(":_GoodID", $goodid);
		$stmt->bindParam(":_Qty", $qty);
		$stmt->bindParam(":_Info", $info);
		$stmt->bindParam(":_Status", $status);
		$stmt->bindParam(":_UserID", $_SESSION['UserID']);
		$stmt->bindParam(":_DeliveryAddress", $delivery);
		$stmt->bindParam(":_Notes", $notes);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) {
			$ar = $stmt->errorInfo();
		} else {
			$cnt = 1;
			$str = '';
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				if ($cnt == 1) {
					foreach ($rowset as $row) {
						$str .= '"Client";"'.$row['Name']."\"\r\n";
						$str .= '"OrderID";"'.$row['OrderID']."\"\r\n";
						$str .= '"State";"'.$row['State']."\"\r\n";
						$str .= '"DT_create";"'.$row['DT_create']."\"\r\n";
						$str .= '"DT_modi";"'.$row['DT_modi']."\"\r\n";
						$str .= '"DT_close";"'.$row['DT_close']."\"\r\n";
						$str .= '"Delivery";"'.$row['Delivery']."\"\r\n";
						$str .= '"Notes";"'.$row['Notes']."\"\r\n";
//						$str .= '"Client";"OrderID";"State";"Delivery";"Notes"'."\r\n";
//						$str .= '"'.$row['Name'].'";"'.$row['OrderID'].'";"'.$row['State'].'";"' . $row['DeliveryAddress'] . '";"'.$row['Notes'].'"'."\r\n";
					}
				}
				if ($cnt == 2) {
					$str2 = '"GoodID";"Article";"Name";"Info";"Qty";"PriceBase";"DiscountPercent";"Discount";"Price";"Sum"'."\r\n";
					foreach ($rowset as $row) {
						$str2 .= '"'.$row['GoodID'].'";"'.$row['Article'].'";"'.$row['Name'].'";"'.$row['Info'].'";"'.$row['Quantity'].'";"'.$row['PriceBase'].'";"'.$row['DiscountPercent'].'";"'.$row['PriceDiscount'].'";"'.$row['Price'].'";"'.$row['Sum'].'"'."\r\n";
					}
				}
				if ($cnt == 3) {
					foreach ($rowset as $row) {
						$str .= '"Sum";"' . $row['Sum'] . "\"\r\n";
					}
					$str .= "\r\n";
				}
				$cnt++;
			} while ($stmt->nextRowset());
		}
		$str .= $str2;
		$str = iconv('UTF-8', 'CP1251', $str);
		
		$userFileName = "order_".$_SESSION['CurrentOrderID'].".csv";
		$path = 'php://output';
		header('Content-Description: File Transfer');
//		header('Content-Type: application/csv;charset=cp1251');
		header("Content-Disposition: attachment; filename=\"" . $userFileName . "\";");
		header('Content-Transfer-Encoding: binary');
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header('Content-Length: ' . strlen($str));
		file_put_contents($path, $str);
	}

//profile
	public function user_info($userVal) {
	if($userVal != $_SESSION['UserID']) return;
	foreach ($_REQUEST as $arg => $val)
		${$arg} = $val;
	if (isset($userVal))
		$userID = $userVal;
//Fn::paramToLog();
//Fn::debugToLog('QUERY_STRING', urldecode($_SERVER['QUERY_STRING']));
	$stmt = $this->db->prepare("CALL pr_user('info', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bindParam(1, $username, PDO::PARAM_STR);
	$stmt->bindParam(2, $userpass, PDO::PARAM_STR);
	$stmt->bindParam(3, $email, PDO::PARAM_STR);
	$stmt->bindParam(4, $fio, PDO::PARAM_STR);
	$stmt->bindParam(5, $post, PDO::PARAM_STR);
	$stmt->bindParam(6, $companyID, PDO::PARAM_STR);
	$stmt->bindParam(7, $company, PDO::PARAM_STR);
	$stmt->bindParam(8, $phone, PDO::PARAM_STR);
	$stmt->bindParam(9, $userID, PDO::PARAM_STR);
	$stmt->bindParam(10, $accesslevel, PDO::PARAM_STR);
	$stmt->bindParam(11, $storeID, PDO::PARAM_STR);
// вызов хранимой процедуры
	$stmt->execute();
	if (!Fn::checkErrorMySQLstmt($stmt))
		return false;
	$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
	foreach ($rowset as $row) {
		break; 
	}
//		Fn::debugToLog("row", json_encode($row));
	return $row;
}

	public function user_info_save(){
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
Fn::debugToLog('userID',$userID);
//		if($_SESSION['UserID'] != $userid) return;
		$response = new stdClass();
		$response->success = false;
		$response->message = "";
		$stmt = $this->db->prepare("CALL pr_user('save', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->bindParam(2, $userpass, PDO::PARAM_STR);
		$stmt->bindParam(3, $email, PDO::PARAM_STR);
		$stmt->bindParam(4, $fio, PDO::PARAM_STR);
		$stmt->bindParam(5, $post, PDO::PARAM_STR);
		$stmt->bindParam(6, $companyID, PDO::PARAM_STR);
		$stmt->bindParam(7, $company, PDO::PARAM_STR);
		$stmt->bindParam(8, $phone, PDO::PARAM_STR);
		$stmt->bindParam(9, $userID, PDO::PARAM_STR);
		$stmt->bindParam(10, $accesslevel, PDO::PARAM_STR);
		$stmt->bindParam(11, $storeID, PDO::PARAM_STR);
// вызов хранимой процедуры
		$stmt->execute();
		if (!Fn::checkErrorMySQLstmt($stmt)) {
			$ar = $stmt->errorInfo();
			$response->success = false;
			$response->message = "Ошибка при изменении данных!";
			//$response->sql = $ar[1] . ' ' . $ar[2];
		} else {
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				if ($rowset) {
					foreach ($rowset as $row) {
						$response->success = ($row[0] != 0);
						$response->message = $row[1];
						break;
					}
				}
			} while ($stmt->nextRowset());
		}
//Fn::debugToLog("resp", json_encode($response));
		header("Content-type: application/json;charset=utf-8");
		echo json_encode($response);
	}
}
