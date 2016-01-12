<?php
class Controller_Main extends Controller {
	function action_index() {
		$this->view->generate('view_main.php', 'view_template.php');
	}
	function action_test() {
		$this->view->generate('view_test.php', 'view_template.php');
	}
	function action_login() {
		$this->view->generate('view_login.php', 'view_template.php');
	}
	function action_cabinet() {
		$this->view->generate('view_cabinet.php', 'view_template.php');
	}
	function action_cabinet_E4() {
		$this->view->generate('view_cabinet_E4.php', 'view_template.php');
	}
	function action_cabinet_A2() {
		$this->view->generate('view_cabinet_A2.php', 'view_template.php');
	}
	function action_cabinet_A5() {
		$this->view->generate('view_cabinet_A5.php', 'view_template.php');
	}
	
	function action_catalog() {
		$this->view->generate('view_catalog.php', 'view_template.php');
	}
	function action_orders() {
		$this->view->generate('view_orders.php', 'view_template.php');
	}

	function action_cabinet_A0_test() {
		$this->view->generate('view_cabinet_A0_test.php', 'view_template.php');
	}
	function action_cabinet_A1() {
		$this->view->generate('view_cabinet_A1.php', 'view_template.php');
	}
	function action_table() {
		$this->view->generate('view_table.php', 'view_template.php');
	}
	function action_tree() {
		$this->view->generate('view_tree.php', 'view_template.php');
	}
}
?>
