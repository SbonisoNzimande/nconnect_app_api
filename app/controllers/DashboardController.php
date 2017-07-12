<?php
/**
 * Dashboard controller
 * 
 * @package 
 * @author  
 */
class DashboardController
{
	static public $app_controller;

	public function __construct() {
		self::$app_controller = new AppController();
	}

	/**
	 * GET Request
	 *
	 * @param  
	 * @return 
	 */
	public function get($request) {
		// Capture subrequest
		$subRequest		= (isset($request->url_elements[1])) ? self::$app_controller->sanitise_string ($request->url_elements[1]) : '';

		// What dashboard request
		switch ($subRequest) {
			
			default:
				
				self::get_dashboard ();
				break;
		}
		
	}// End get


	static public function get_dashboard (){

		self::$app_controller->set_session_start();

		// var_dump($_SESSION);
		$username 	= $_SESSION['username'];

		if (self::$app_controller->check_if_logged ($username)) {// Check if logged in

			$user_id		= $_SESSION['user_id'];
			$email			= $_SESSION['email'];

			$pass 			= array(
								'username'  => $username, 
								'email' 	 => $email,
								'page_title' => 'Dashboard',
								'page'		 => 'dashboard'
								);

			self::$app_controller->get_header ($pass);
			self::$app_controller->get_view ('Asidemenu', $pass);
			self::$app_controller->get_view ('Dashboard', $pass);
			self::$app_controller->get_footer ($pass);
			exit();

		}else{

			self::$app_controller->redirect_to ('Login');
		}

		

	}
}