<?php
class Controller_Login extends Controller {
	function action_index() {
		$this->view->generate('view_login.php', 'view_template.php');
	}
	function action_logon() {
//		$_SESSION['access'] = false;
//		$_SESSION['access'] = true;
		$realm = 'B2B';
		if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
			header('HTTP/1.1 401 Unauthorized');
			header('WWW-Authenticate: Digest realm="' . $realm . '",qop="auth",nonce="' . md5(uniqid()) . '",opaque="' . md5($realm) . '"');
			die('Ошибка авторизации!');
		}
		$data = $this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST']);
		$users = array();
		$cnn = new Cnn();
		$res = $cnn->user_find($data['username']);
		if($res==false){
			unset($_SESSION['UserID']);
			unset($_SESSION['UserName']);
			unset($_SESSION['UserEMail']);
			unset($_SESSION['UserPost']);
			unset($_SESSION['ClientID']);
			unset($_SESSION['ClientName']);
			unset($_SESSION['access']);
			unset($_SESSION['AccessLevel']);
			unset($_SESSION['CurrentOrderID']);
//			echo 'Пользователь: "'. $data['username'].'" не зарегистрирован в системе!';
Fn::debugToLog("logon", "Incorrect username:" . $data['username']);
			die('Ошибка авторизации!<br><br>Вы ввели неправильное имя пользователя!');
		}else{
			$users = array($data['username'] => $res);
		}
// analyze the PHP_AUTH_DIGEST variable
		if (!($data = $this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
				!isset($users[$data['username']])){
			unset($_SESSION['UserID']);
			unset($_SESSION['UserName']);
			unset($_SESSION['UserEMail']);
			unset($_SESSION['UserPost']);
			unset($_SESSION['ClientID']);
			unset($_SESSION['ClientName']);
			unset($_SESSION['access']);
			unset($_SESSION['AccessLevel']);
			unset($_SESSION['CurrentOrderID']);
Fn::debugToLog("logon", "Incorrect username:".$data['username']);
			die('Ошибка авторизации!<br><br>Вы ввели неправильное имя пользователя!');
		}
// generate the valid response
		$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
		$A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $data['uri']);
		$valid_response = md5($A1 . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] . ':' . $data['qop'] . ':' . $A2);

		if ($data['response'] != $valid_response){
			unset($_SESSION['UserID']);
			unset($_SESSION['UserName']);
			unset($_SESSION['UserEMail']);
			unset($_SESSION['UserPost']);
			unset($_SESSION['ClientID']);
			unset($_SESSION['ClientName']);
			unset($_SESSION['access']);
			unset($_SESSION['AccessLevel']);
			unset($_SESSION['CurrentOrderID']);
Fn::debugToLog("logon", "Bad response! user:".$data['username']." send:".$data['response'].' valid:'.$valid_response);
			die('Ошибка авторизации!<br><br>Вы ввели неправильный пароль!');
		}
// ok, valid username & password
		$_SESSION['access'] = true;
Fn::debugToLog("logon", "user:".$data['username'].' доступ разрешен!');
//Fn::debugToLog("$_SESSION", json_encode($_SESSION));
		die('success');
	}
	function action_logout() {
		unset($_SESSION['banners1']);
		unset($_SESSION['banners2']);
		
		unset($_SESSION['sitename']);
		unset($_SESSION['titlename']);
		unset($_SESSION['company']);
		unset($_SESSION['dbname']);
		unset($_SESSION['siteEmail']);
		unset($_SESSION['adminEmail']);
		unset($_SESSION['UserID']);
		unset($_SESSION['UserName']);
		unset($_SESSION['UserEMail']);
		unset($_SESSION['UserPost']);
		unset($_SESSION['ClientID']);
		unset($_SESSION['ClientName']);
		unset($_SESSION['access']);
		unset($_SESSION['AccessLevel']);
		unset($_SESSION['CurrentOrderID']);
		Fn::redirectToController("");
	}
	function action_forgot() {
		$cnn = new Cnn();
		$cnn->user_find_by_email();
	}
	function action_register() {
		$cnn = new Cnn();
		$cnn->user_register();
	}
	function action_sendmail() {
		$cnn = new Cnn();
		$cnn->user_sendmail();
	}

//function to parse the http auth header
	function http_digest_parse($txt) {
		// protect against missing data
		$needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
		$data = array();

		$keys = implode('|', array_keys($needed_parts));
		preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);
//	Fn::debugToLog("matches", json_encode($matches));

		foreach ($matches as $m) {
			$data[$m[1]] = $m[3] ? $m[3] : $m[4];
			unset($needed_parts[$m[1]]);
		}

		return $needed_parts ? false : $data;
	}
}
?>
