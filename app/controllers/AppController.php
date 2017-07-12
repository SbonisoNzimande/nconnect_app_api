<?php
/**
 * App controller
 * 
 * @package 
 * @author  
 */
class AppController extends AppModel
{
	static public $server_name;
	static public $pass_hash;


	static public function get_all_people () {
		return parent::get_all_people_db ();
	}

	static public function get_user_by_name ($username) {
		return parent::get_user_by_name_db ($username);
	}

	static public function get_randass_products ($category_id) {
		return parent::get_randass_products_db ($category_id);
	}

	static public function get_pos_categories () {
		return parent::get_pos_categories_db ();
	}

	static public function get_pos_details () {
		return parent::get_pos_details_db ();
	}

	static public function get_rass_details () {
		return parent::get_rass_details_db ();
	}

	static public function insert_new_user ($Username, $Email, $Password) {
		return parent::insert_new_user_db ($Username, $Email, $Password);
	}

	static public function insert_new_person (
								$first_name,
								$last_name,
								$language,
								$dob,
								$mobile,
								$email
							) {
		return parent::insert_new_person_db (
					$first_name,
					$last_name,
					$language,
					$dob,
					$mobile,
					$email
				);
	}

	static public function get_responces_byrepid($survey_id, $rep_id) {
		// parent::set_utf8();
		return parent::get_responces_byrepid_db ($survey_id, $rep_id);
	}

	static public function insert_survey_responce ($survey_id, $store_id, $rep_id, $q_id, $q_num, $responce, $survey_type) {
		return parent::insert_survey_responce_db ($survey_id, $store_id, $rep_id, $q_id, $q_num, $responce, $survey_type);
	}

	static public function update_survey_responce ($survey_id, $store_id, $rep_id, $q_id, $q_num, $responce, $survey_type) {
		return parent::update_survey_responce_db ($survey_id, $store_id, $rep_id, $q_id, $q_num, $responce, $survey_type);
	}

	static public function get_responces_by_store_id($id, $store_id) {
		return parent::get_responces_by_store_id_db ($id, $store_id);
	}

	static public function get_responces ($survey_id, $stored_id, $rep_id, $q_num, $survey_type) {
		// parent::set_utf8();
		return parent::get_responces_db ($survey_id, $stored_id, $rep_id, $q_num, $survey_type);
	}

	static public function get_surveys() {
		// parent::set_utf8();
		return parent::get_surveys_db();
	}

	static public function get_adhocs() {
		// parent::set_utf8();
		return parent::get_adhocs_db();
	}

	static public function get_stores_information () {
		// parent::set_utf8();
		return parent::get_stores_information_db ();
	}

	static public function save_new_strikerate ($promo_id, $rep_id, $store_id, $number_bins, $number_godnola, $reason, $image = '') {
		return parent::save_new_strikerate_db ($promo_id, $rep_id, $store_id, $number_bins, $number_godnola, $reason, $image);
	}

	static public function save_new_pos ($rep_id, $store_id, $category_id, $category_inline, $poc_id, $image = '') {
		return parent::save_new_pos_db ($rep_id, $store_id, $category_id, $category_inline, $poc_id, $image);
	}

	static public function get_user_by_password ($password) {
		return parent::get_user_by_password_db ($password);
	}

	static public function insert_new_objective ($store_id, $rep_id, $activity, $smart, $strategy) {
		return parent::insert_new_objective_db ($store_id, $rep_id, $activity, $smart, $strategy);
	}

	static public function get_rep_by_repid ($rep_id) {
		return parent::get_rep_by_repid_db ($rep_id);
	}

	static public function get_store_calls ($rep_id) {
		return parent::get_store_calls_db ($rep_id);
	}

	static public function get_reps_promos ($rep_id){
		return parent::get_reps_promos_db ($rep_id);
	}

	static public function get_store_promos ($rep_id, $store_id){
		return parent::get_store_promos_db ($rep_id, $store_id);
	}

	static public function get_store_by_id ($store_id){
		return parent::get_store_by_id_db ($store_id);
	}

	static public function get_stores_weeday ($rep_id, $day_of_week){
		return parent::get_stores_weeday_db ($rep_id, $day_of_week);
	}

	static public function get_adhoc_responces_by_store_id ($survey_id, $store_id){
		return parent::get_adhoc_responces_by_store_id_db ($survey_id, $store_id);
	}

	static public function get_questions_bysurveyid ($survey_id) {
		return parent::get_questions_bysurveyid_db ($survey_id);
	}

	static public function get_questions_npd_bysurveyid ($survey_id) {
		return parent::get_questions_npd_bysurveyid_db ($survey_id);
	}

	static public function get_questions_adhoc_bysurveyid ($survey_id) {
		return parent::get_questions_adhoc_bysurveyid_db ($survey_id);
	}

	static public function get_location_by_id ($rep_id, $store_id, $today){
		return parent::get_location_by_id_db ($rep_id, $store_id, $today);
	}

	static public function get_last_saved_objective ($rep_id, $store_id){
		return parent::get_last_saved_objective_db ($rep_id, $store_id);
	}

	static public function get_location_checkout_by_id ($location_id, $today){
		return parent::get_location_checkout_by_id_db ($location_id, $today);
	}

	static public function get_location_by_locid ($location_id) {
		return parent::get_location_by_locid_db ($location_id);
	}

	static public function check_out_store ($location_id) {
		return parent::check_out_store_db ($location_id);
	}

	static public function insert_new_chekin ($rep_id, $store_id, $latitude, $longitude){
		return parent::insert_new_chekin_db ($rep_id, $store_id, $latitude, $longitude);
	}

	static public function get_open_promos (){
		return parent::get_open_promos_db ();
	}

	static public function get_store_location_this_week ($rep_id, $monday_date, $current_date) {
		return parent::get_store_location_this_week_db ($rep_id, $monday_date, $current_date);
	}


	/**
	 * Check if logged in
	 *
	 */
	static public function check_if_logged ($username) {
		
		$validate_return = array();
		$userinfo        = parent::get_user_by_name_db ($username);
		
		if (count($userinfo) == 1) { // Email exist
			
			
			foreach ($userinfo as $user) { // Get user details
				$user_id 		= $user['id'];
				$user_password 	= $user['password'];
				$user_email 	= $user['email'];
			}
			
			self::set_session_start();
			
			$login_strg   	= $_SESSION['login_strg'];
			$check_string 	= md5($user_email . '+' . $user_password . '+' . $user_id. '+' . $username);
			
			if ($login_strg === $check_string) {
				$validate_return = true;
			} else {
				
				$validate_return = false;
			}
		} else {

			$validate_return = false;

		}
		
		return $validate_return;
	}



	////////////////-------- VIP -----////////////////

	static public function get_money_value ($num) {

		return 'R' . number_format((double)$num, 0);
	}

	static public function get_money_value_cents ($num) {

		return 'R' . number_format((double)$num, 2);
	}

	static public function get_sqm_value ($num) {

		if (empty($num)) {
			return '';
		}else{
			return $num .'m<sup>2</sup>';
		}
	}

	static public function get_perc_value ($num) {

		if (empty($num)) {
			return '';
		}else{
			return $num .'%';
		}
	}

	static public function human_timing ($time) {

		$ftime 	= strtotime($time);
		$ftime 	= time() - $ftime; // to get the time since that moment

		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($ftime < $unit) continue;
			$numberOfUnits = floor($ftime / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}

	}

	static public function format_date($date) {
		return date("D jS \of M h:i A", strtotime($date));
	}

	static public function get_server_name () {
		return $_SERVER['SERVER_NAME'];
	}

	/**
	 * hash password
	 */
	static public function hash_password ($password) {
		
		$hash = hash_hmac('ripemd160', 'The ddf dsf d quicdsk brown fox sfjumped osdsdsd ssssver the lazy dog.', $password);
		
		return $hash;
	}

	/**
	 * Get view
	 */
	static public function get_view($view, $assigns = array()) {
		$page = new View_Model($view);
		
		// Anything needs to be passed
		if (count($assigns) > 0) {
			// Loop throught the list
			foreach ($assigns as $assignName => $assignValue) {
				// Pass to view
				$page->assign($assignName, $assignValue);
			}
		}
		
		// return $page;
	}

	/**
	 * Header view
	 */
	static public function get_header ($assigns = array()) {
		$view = self::get_view('Header', $assigns);
	}
	/**
	 * Footer view
	 */
	static public function get_footer ($assigns = array()) {
		return self::get_view('Footer', $assigns);
	}

	/**
	 * session start
	 */
	static public function set_session_start () {
		if (!isset($_SESSION))
			session_start();
		
	}

	/**
	 * redirect
	 *
	 */
	static public function redirect_to($url, $permanent = false) {
		if (headers_sent() === false) {
			header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
		}
		exit();
	}

	/**
	 * redirect
	 *
	 */
	static public function sanitise_string ($string) {
		return parent::clean_string ($string);
	}

	static public function array_remove_dublicates ($data, $key) {
		$_data 	= array();

		foreach ($data as $v) {
			if (isset($_data[$v[$key]])) {
			// found duplicate
				continue;
			}
		  // remember unique item
			$_data[$v[$key]] = $v;
		}
		// if you need a zero-based array, otheriwse work with $_data
		$data = array_values ($_data);
		return $data;
	}
	public function created_directory ($dir) { 
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
	}

	public function filter_by_value ($array, $index, $value){ 
		$newarray = array();
		if(is_array($array) && count($array)>0) { 
			foreach(array_keys($array) as $key){ 
				$temp[$key] = $array[$key][$index]; 
				 
				if ($temp[$key] == $value){ 
					$newarray[$key] = $array[$key]; 
				} 
			} 
		  } 
	  return $newarray; 
	}

	public function sort_by_value ($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}

	public function date_compare ($a, $b) {
		$t1 = strtotime($a['sort']);
		$t2 = strtotime($b['sort']);
		return $t1 - $t2;
	} 

	public function aasort (&$array, $key) {
		$sorter		= array();
		$ret 		= array();

		reset($array);

		foreach ($array as $ii => $va) {
			$sorter[$ii] = $va[$key];
		}

		asort($sorter);

		foreach ($sorter as $ii => $va) {
			$ret[$ii] = $array[$ii];
		}
		$array 		  =	$ret;

		return $ret;
	}  

	public function array_orderby () {
		$args = func_get_args ();
		$data = array_shift ($args);

		foreach($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach($data as $key => $row) $tmp[$key] = $row[$field];
				$args[$n] = $tmp;
			}
		}

		$args[] = & $data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}

	


	public function compare_dates ($a, $b) {

		$a = strtotime($a[0]);
		$b = strtotime($b[0]);

		if ($a == $b) {
			return 0;
		}
		return ($a < $b) ? -1 : 1;
	}



	public function prettyPrint( $json ) {

		$result 			= '';
		$level 				= 0;
		$in_quotes 			= false;
		$in_escape 			= false;
		$ends_line_level 	= NULL;
		$json_length 		= strlen( $json );

		for( $i = 0; $i < $json_length; $i++ ) {
			$char = $json[$i];
			$new_line_level = NULL;
			$post = "";
			if( $ends_line_level !== NULL ) {
				$new_line_level = $ends_line_level;
				$ends_line_level = NULL;
			}
			if ( $in_escape ) {
				$in_escape = false;
			} else if( $char === '"' ) {
				$in_quotes = !$in_quotes;
			} else if( ! $in_quotes ) {
				switch( $char ) {
					case '}': case ']':
						$level--;
						$ends_line_level = NULL;
						$new_line_level = $level;
						break;

					case '{': case '[':
						$level++;
					case ',':
						$ends_line_level = $level;
						break;

					case ':':
						$post = " ";
						break;

					case " ": case "\t": case "\n": case "\r":
						$char = "";
						$ends_line_level = $new_line_level;
						$new_line_level = NULL;
						break;
				}
			} else if ( $char === '\\' ) {
				$in_escape = true;
			}
			if( $new_line_level !== NULL ) {
				$result .= "\n".str_repeat( "\t", $new_line_level );
			}
			$result .= $char.$post;
		}

		return $result;
	}

	/**
	 * Validate fields
	 * 
	 * @param  int $valNum -  What to validate
	 * @param  string $value -  Form valuee
	 * @return array
	 */
	static public function validate_variables ($value, $valNum) {
			$return_array = array();
			$partten      = '';
			
			switch ($valNum) {
				case 0: // validate cell number
					$partten = '/^0[0-9]{9}$/'; // Cellphone parten
					
					break;
				case 1: // validate name surname
					$partten = '/^[aA-zZ ]{2,31}$/'; //
					
					break;
				
				case 2: // Street number
					$partten = '/^[0-9]{1,5}$/'; // Street number
					
					break;
				case 3: // Store name
					$partten = '/^[A-Za-z0-9 _.,\'~\-!@#\$%\^&\*\(\)]+/u';
					
					break;
				
				case 4: // Postal code
					$partten = '/^[0-9]{4}$/'; // Postal code
					
					break;
				case 5: // One Time Pin
					$partten = '/^0[0-9]{4,6}$/'; // One Time Pin
					
					break;
				case 6: // Block number
					$partten = '/^0[0-9]{1,5}$/';
					
					break;
				case 7: // Target
					$partten = '/^[0-9]{1-10}$/';
					
					break;
				case 8: // Username
					$partten = '/^[aA-zZ0-9]{2,40}$/'; //
					
					break;
				case 9: // Building number
					$partten = '/^[aA-zZ0-9 ]{2,30}$/'; //
					
					break;
				
				case 10: // Email
					$partten = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
					break;
				case 11: // Address
					$partten = '/[aA-zZ0-9,. ]{2,40}$/'; //
					break;
				case 12: // Date (03/03/2014)
					$partten = '/^(0[1-9]|[12][0-9]|3[01])[\-\/.](0[1-9]|1[012])[\-\/.](19|20)\d\d$/'; //
					break;
				case 13: // GPS coordinates
					$partten = '/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/'; //
					break;
				case 'date': // vate
					$partten = '/^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2}\$/'; //
					break;
				
				case 14: // yes/no
					$partten = '/^[aA-zZ]{2,3}$/'; //
					
					break;
				case 15: // Word
					$partten = '/^[\w-]+$/'; //
					
					break;
				case 16: // Word
					$partten = '/^[\w-]+$/'; //
					
					break;
				case 17: // Commer separate
					$partten = '/^([aA-zZ0-9 ]+)(,\s*[aA-zZ0-9 ]+)*$/'; //
					break;
				default: //
					break;
			}
			// echo $partten;
			
			
			if (preg_match($partten, $value)) { // Test cell if valid
				$return_array = true;
			} else {
				$return_array = false;
			}
			
			
			return $return_array;
		}



}