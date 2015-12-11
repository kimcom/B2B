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
	
	public function action_404() {
		$this->view->generate('view_template_404.php', 'view_template.php');
	}
}
