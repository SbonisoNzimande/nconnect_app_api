<?php
/**
 * PeopleManagement controller
 * 
 * @package 
 * @author  
 */
class PeopleManagementController
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
		 $subRequest = (isset($request->url_elements[1])) ? $request->url_elements[1] : '';

		// What dashboard request
		switch ($subRequest) {
			case 'GetAllPeople': 
				
				$people          = self::getting_people();
				return json_encode($people);
			break;
			default:
				
				self::get_page ();
				break;
		}
		
	}// End get


	
	/**
	 * POST Request
	 *
	 * @param  
	 * @return 
	 */
	public function post ($request) {
		$subRequest = (isset($request->url_elements[1])) ? $request->url_elements[1] : '';

		switch ($subRequest) {
			case 'CreatePerson': 
				$first_name     = $request->parameters['first_name'];
				$last_name      = $request->parameters['last_name'];
				$language     	= $request->parameters['language'];
				$dob    		= $request->parameters['dob'];
				$mobile    		= $request->parameters['mobile'];
				$email    		= $request->parameters['email'];


				$insert         = self::validate_person(
									$first_name,
									$last_name,
									$language,
									$dob,
									$mobile,
									$email
								);
				return json_encode($insert);
			break;
			case 'LoginUser': // Do login
				$username    = $request->parameters['username'];
				$password 	 = $request->parameters['password'];

				$login    	 = self::validate_login ($username, $password);
				
				return json_encode($login);

			break;
		}

	}


	static public function get_page (){

		self::$app_controller->set_session_start();

		// var_dump($_SESSION);
		$username 	= $_SESSION['username'];

		if (self::$app_controller->check_if_logged ($username)) {// Check if logged in

			$user_id		= $_SESSION['user_id'];
			$email			= $_SESSION['email'];

			$pass 			= array(
								'username'  => $username, 
								'email' 	 => $email,
								'page_title' => 'People Management',
								'page'		 => 'people_managemenr'
								);

			self::$app_controller->get_header ($pass);
			self::$app_controller->get_view ('Asidemenu', $pass);
			self::$app_controller->get_view ('PeopleManagement', $pass);
			self::$app_controller->get_footer ($pass);
			exit();

		}else{

			self::$app_controller->redirect_to ('Login');
		}

		

	}


	/**
	 * 
	 *
	 */
	
	static protected function getting_people () {
		$people = self::$app_controller->get_all_people ();

		// var_dump($people);

		return $people;
	}


	/**
	 * 
	 *
	 */
	
	static protected function validate_person(
									$first_name,
									$last_name,
									$language,
									$dob,
									$mobile,
									$email
								) {

		if(!self::$app_controller->validate_variables($first_name, 3)){
			return array('status'=>false, 'text'=>'Invalid Firstname');
		}

		if(!self::$app_controller->validate_variables($last_name, 3)){
			return array('status'=>false, 'text'=>'Invalid Lastname');
		}
		

		if(!self::$app_controller->validate_variables($language, 3)){
			return array('status'=>false, 'text'=>'Invalid Language');
		}

		// validate email
		if(!self::$app_controller->validate_variables($email, 10)){
			return array('status'=>false, 'text'=>'Invalid Email');
		}


		$insert 	 = self::$app_controller->insert_new_person (
								$first_name,
								$last_name,
								$language,
								$dob,
								$mobile,
								$email
							);

		if (is_string($insert)) {
			return array('status'=>false, 'text'=>$insert);
		}

		if ($insert) {
			return array('status'=>true, 'text'=>'Successfully Inserted');
		}else{
			return array('status'=>false, 'text'=>'Failed To Insert ' . $insert);
		}
		

	}
}