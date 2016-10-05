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
	function action_catalog_down() {
		$this->view->generate('view_catalog_down.php', 'view_template.php');
	}

	function action_orders() {
		$this->view->generate('view_orders.php', 'view_template.php');
	}
	function action_sales() {
		$this->view->generate('view_sales.php', 'view_template.php');
	}
	
	function action_price() {
		$this->view->generate('view_price.php', 'view_template.php');
	}
	function action_profile() {
		$this->view->generate('view_profile.php', 'view_template.php');
	}

	function action_feedback() {
		$this->view->generate('view_feedback.php', 'view_template.php');
	}

}
?>
