<?php
class Controller_Main extends Controller {
	function action_index() {
		$this->view->generate('view_history.php', 'view_template.php');
	}
	function action_helper() {
		$this->view->generate('view_helper_controls.php', 'view_template.php');
	}
	function action_catalog() {
		$this->view->generate('view_catalog.php', 'view_template.php');
	}
	function action_orders() {
		$this->view->generate('view_orders.php', 'view_template.php');
	}
	
	function action_profile() {
		$this->view->generate('view_profile.php', 'view_template.php');
	}

}
?>
