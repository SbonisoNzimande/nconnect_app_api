<?php
/**
 * Login controller
 * 
 * @package 
 * @author  
 */
class LoginController extends AppModel
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
			$callback   = (isset($request->parameters['callback'])) ? $request->parameters['callback'] : '';
			
			
			switch ($subRequest) {
				
				default:

					// self::$app_controller->get_view('Header', array('page_title' => 'Login'));
					self::$app_controller->get_view('Login');
					self::$app_controller->get_view('Footer');
					exit();
					break;
			}
				
			
		}

		/**
		 * POST Request
		 *
		 * @param  
		 * @return 
		 */
		public function post ($request) {
			$subRequest = (isset($request->url_elements[1])) ? $request->url_elements[1] : '';

			switch ($subRequest) {
				case 'RegisterUser': 
					$Username     = $request->parameters['Username'];
					$Email        = $request->parameters['Email'];
					$Password     = $request->parameters['Password'];
					$Password2    = $request->parameters['Password2'];


					$reg          = self::validate_registation(
										$Username,
										$Email,
										$Password,
										$Password2
									);
					return json_encode($reg);
				break;
				case 'LoginUser': // Do login
					$username    = $request->parameters['username'];
					$password 	 = $request->parameters['password'];

					$login    	 = self::validate_login ($username, $password);
					
					return json_encode($login);

				break;
			}

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_registation ($Username,
										$Email,
										$Password,
										$Password2) {

			// validate username
			if(!self::$app_controller->validate_variables($Username, 3)){
				return array('status'=>false, 'text'=>'Invalid Username');
			}

			// validate email
			if(!self::$app_controller->validate_variables($Email, 10)){
				return array('status'=>false, 'text'=>'Invalid Email');
			}

			// validate password
			if(!self::$app_controller->validate_variables($Password, 3)){
				return array('status'=>false, 'text'=>'Invalid Password');
			}
			// validate password
			if(!self::$app_controller->validate_variables($Password2, 3)){
				return array('status'=>false, 'text'=>'Invalid Password');
			}

			if ($Password !== $Password2) {
				return array('status'=>false, 'text'=>'Passwords Do Not Match');
			}

			$user_exist = self::$app_controller->get_user_by_name ($Username);

			// validate query error

			if (is_string($user_exist)) {
				return array('status'=>false, 'text'=>$user_exist);
			}

			if ($user_exist) {
				return array('status'=>false, 'text'=>'Username Is Taken');
			}

			$db_password = self::$app_controller->hash_password($Password);

			$insert 	 = self::$app_controller->insert_new_user ($Username, $Email, $db_password);

			if (is_string($insert)) {
				return array('status'=>false, 'text'=>$insert);
			}

			if ($insert) {
				return array('status'=>true, 'text'=>'Success');
			}else{
				return array('status'=>false, 'text'=>'Failed To Insert ' . $insert);
			}
			

		}


		/**
		 * 
		 *
		 */
		
		static protected function validate_login ($username, $password) {

			// validate username
			if(!self::$app_controller->validate_variables($username, 3)){
				return array('status'=>false, 'text'=>'Invalid Username');
			}

			// validate password
			if(!self::$app_controller->validate_variables($password, 3)){
				return array('status'=>false, 'text'=>'Invalid Password');
			}
			

			$user_exist = self::$app_controller->get_user_by_name ($username);

			// validate query error

			if (is_string($user_exist)) {
				return array('status'=>false, 'text'=>$user_exist);
			}

			if (count($user_exist) == 1){

				$input_password = self::$app_controller->hash_password($password);

				foreach ($user_exist as $usr) {
					$user_id 		= $usr['id'];
					$user_password 	= $usr['password'];
					$user_email 	= $usr['email'];
				}
				

				// test passwords
                if ($input_password === $user_password) {

                	self::$app_controller->set_session_start(); // start session

                	// sessions //
                	$_SESSION['login_strg']     = md5($user_email . '+' . $user_password . '+' . $user_id . '+' . $username);
                    $_SESSION['user_id']     	= $user_id;
                    $_SESSION['email']          = $user_email;
                    $_SESSION['username']       = $username;

                    $redirect_to 				= 'Dashboard#/main';

                    return array('status'=>true, 'text'=>'Success', 'redirect_to'=>$redirect_to);
                }else{
                	return array('status'=>false, 'text'=>'Invalid username or password1');
                }

			}else{
				// die(var_dump($user_exist));
				return array('status'=>false, 'text'=>'Invalid username or password');
			}

			// if (!$user_exist) {
			// 	return array('status'=>false, 'text'=>'Invalid username or password');
			// }

			// die(var_dump($user_exist));

			

			// $password_exist = self::$app_controller->get_user_by_password ($db_password);

			// $insert 	 = self::$app_controller->insert_new_user ($Username, $Email, $db_password);

			// if (is_string($insert)) {
			// 	return array('status'=>false, 'text'=>$insert);
			// }

			// if ($insert) {
			// 	return array('status'=>true, 'text'=>'Success');
			// }else{
			// 	return array('status'=>false, 'text'=>'Failed To Insert ' . $insert);
			// }
			

		}
}

