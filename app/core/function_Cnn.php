<?php
class Cnn {
	private $db = null;
	public function __construct() {
		try {
			$this->db = new PDO('mysql:host=localhost;dbname=' . $_SESSION['dbname'] . ';port=' . $_SESSION['server_port'], $_SESSION['server_user'], $_SESSION['server_pass'], array(1006));
		} catch (PDOException $e) {
			Fn::errorToLog("PDO error!: ", $e->getMessage());
			die();
		}
	}
//controller login
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
					$result = $row['Userpass'];
					break;
				}
			}
//Fn::debugToLog("rowset", json_encode($rowset));
		} while ($stmt->nextRowset());
		return $result;











//	if (!$r)
//			return false;
//		if ($stmt->rowCount() == 0)
//			return false;
////Fn::debugToLog("login", json_encode($r));
//		if ($r[AccessLevel] == -1) {
//			$_SESSION['error_msg'] = "<h4 class='center list-group-item list-group-item-danger'>"
//					. "ВНИМАНИЕ!<br><small>Вы не активировали Ваш аккаунт!<br>"
//					. "Вход в систему возможен только после активации!</small></h4>";
//			return false;
//		}
//		$_SESSION['UserID'] = $r[UserID];
//		$_SESSION['UserName'] = $r[UserName];
//		$_SESSION['UserEMail'] = $r[EMail];
//		$_SESSION['UserPost'] = $r[Position];
//		$_SESSION['ClientID'] = $r[ClientID];
//		$_SESSION['ClientName'] = $r[ClientName];
//		$_SESSION['CompanyName'] = $r[CompanyName];
//		$_SESSION['AccessLevel'] = $r[AccessLevel];
//		$_SESSION['access'] = true;
//		$_SESSION['error_msg'] = "";
//		return true;
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
			$response->message = "Ошибка восстановления доступа к системе!";
			$response->sql = $ar[1] . ' ' . $ar[2];
		} else {
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				if ($rowset) {
					foreach ($rowset as $row) {
						$response->success = ($row[0] != false);
						$response->message = $row[2];
						$response->sql  = $row[2];
						$fio  = $row['FIO'];
						$user = $row[0];
						$pass = $row[1];
						break;
					}
				}
			} while ($stmt->nextRowset());
		}
//Fn::debugToLog("resp", json_encode($response));
		if ($response->success){
//оправляем сообщение пользователю
$subject = 'Восстановление пароля для доступа к информационной системе ' . $_SESSION['company'];
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
		foreach ($_REQUEST as $arg => $val)
			${$arg} = $val;
		$response = new stdClass();
		if (md5($captcha) != $_SESSION['randomnr2']) {
			$response->success = false;
			$response->message = "Неверный проверочный код!";
			$response->sql = "";
			header("Content-type: application/json;charset=utf-8");
			echo json_encode($response);
			return;
		}
//Fn::paramToLog();
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
			$response->sql = $ar[1] . ' ' . $ar[2];
		} else {
			do {
				$rowset = $stmt->fetchAll(PDO::FETCH_BOTH);
				if ($rowset) {
					foreach ($rowset as $row) {
						$response->success = ($row[0] != 0);
						$response->message = $row[1];
						$response->sql = $row[1];
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
