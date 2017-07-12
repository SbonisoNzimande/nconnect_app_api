<?php
/**
 * Login controller
 * 
 * @package 
 * @author  
 */
class APIController extends AppModel
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
				case 'GetRepInfo': 
						$rep_id         = $request->parameters['rep_id'];
					break;

				case 'GetDashboardInfo': 
					$rep_id         = $request->parameters['rep_id'];
					$rep_data   	= self::get_rep_data(
										$rep_id
									);

					return json_encode ($rep_data);
				break;

				case 'GetWeekdayStoreInfo': 
					$rep_id         = $request->parameters['rep_id'];
					$day_of_week    = $request->parameters['day_of_week'];
					$rep_data   	= self::get_call_stores_data(
										$rep_id,
										$day_of_week
									);

					// get_stores_weeday ($rep_id, $day_of_week)

					return json_encode ($rep_data);
				break;

				case 'CheckIfCheckedIn': 
					$rep_id         = $request->parameters['rep_id'];
					$store_id    	= $request->parameters['store_id'];
					$is_checked   	= self::store_is_checked(
										$rep_id,
										$store_id
									);

					// get_stores_weeday ($rep_id, $day_of_week)

					return json_encode ($is_checked);
				break;

				case 'CheckIfCheckedOut': 
					$location_id    = $request->parameters['location_id'];
					$is_checked   	= self::store_is_checkedout(
										$location_id
									);

					return json_encode ($is_checked);
				break;

				case 'GetLastSavedObjective': 
					$rep_id         = $request->parameters ['rep_id'];
					$store_id    	= $request->parameters ['store_id'];
					$objective   	= self::check_last_saved_objective(
										$rep_id,
										$store_id
									);

					return json_encode ($objective);
				break;

				case 'GetStorePromos': 
					$rep_id 		= $request->parameters ['rep_id'];
					$store_id    	= $request->parameters ['store_id'];
					$promos   		= self::validate_get_store_promos(
										$rep_id,
										$store_id
									);

					return json_encode ($promos);
				break;

				case 'GetAllSurveys': 
					$rep_id 		= $request->parameters ['rep_id'];
					$store_id    	= $request->parameters ['store_id'];
					$promos   		= self::validate_get_surveys(
										$rep_id,
										$store_id
									);

					return json_encode ($promos);
				break;
				case 'GetPOSCategories': 
				
					$categories   		= self::$app_controller->get_pos_categories();

					return json_encode ($categories);
				break;

				case 'GetCategoryProducts': 
					$category_id 		= $request->parameters ['category_id'];

					$categories   		= self::validate_get_product_list (
												$category_id
										   );

					return json_encode ($categories);
				break;

				case 'GetPOSDetails': 
					$store_id 			= $request->parameters ['store_id'];
					$categories   		= self::validate_get_pos_details (
												$store_id
										   );

					return json_encode ($categories);
				break;

				case 'GetRASSDetails': 
					$store_id 			= $request->parameters ['store_id'];
					$categories   		= self::validate_get_rass_details (
												$store_id
										   );

					return json_encode ($categories);
				break;

				case 'GetQuestionsBySurveyID': 
					$survey_id 		= $request->parameters ['survey_id'];
					$survey_type    = $request->parameters ['survey_type'];

					$promos   		= self::validate_get_survey_questions (
										$survey_id,
										$survey_type
									);

					return json_encode ($promos);
				break;
				default:

					return json_encode (array('success' => false, 'text'=> 'invalid request'));
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
			$subRequest  			= (isset($request->url_elements[1])) ? $request->url_elements[1] : '';


			switch ($subRequest) {
				case 'RepLogin': 
					$rep_id         = $request->parameters ['rep_id'];
					$password       = $request->parameters ['password'];

					$login_fun   	= self::validate_login(
										$rep_id,
										$password
									);

					return json_encode($login_fun);
				break;

				case 'CheckinStore': 
					$rep_id         = $request->parameters ['rep_id'];
					$store_id       = $request->parameters ['store_id'];
					$latitude       = $request->parameters ['latitude'];
					$longitude      = $request->parameters ['longitude'];

					$check   	= self::validate_checkin(
										$rep_id,
										$store_id,
										$latitude,
										$longitude
									);

					return json_encode($check);
				break;

				case 'CheckOutStore': 
					$location_id 	= $request->parameters ['location_id'];
					

					$check   		= self::validate_checkout(
										$location_id
									);

					return json_encode($check);
				break;
				case 'SaveObjective': 
				
					$params 		= json_decode (file_get_contents('php://input'),true);

					
					

					$check   		= self::validate_objective(
										$params
									);

					return json_encode($check);
				break;

				case 'SaveStrikeRate': 
					// var_dump($_FILES);
					// die();
					$params 		= json_decode (file_get_contents('php://input'),true);

					// var_dump($request->parameters);
					// die();

					$check   		= self::validate_strikerate_noimage(
										$params
									);

					return json_encode($check);
				break;

				case 'SavePictureOfSuccess': 
					$params 		= json_decode (file_get_contents('php://input'),true);


					$check   		= self::validate_picture_of_success(
										$params
									);

					return json_encode($check);
				break;

				case 'SaveSurveyForm': 
					$params 		= json_decode (file_get_contents('php://input'),true);

					// var_dump($request->parameters);
					// die();

					$check   		= self::validate_survey_submit(
										$params
									);

					return json_encode($check);
				break;
				case 'UploadStrikeRate': 
					$promo_name 	= $request->parameters ['promo_name'];
					$promo_id 		= $request->parameters ['promo_id'];
					$store_id 		= $request->parameters ['store_id'];
					$rep_id 		= $request->parameters ['rep_id'];
					$bin_placed 	= $request->parameters ['bin_placed'];
					$number_bins 	= $request->parameters ['number_bins'];
					$number_godnola = $request->parameters ['number_godnola'];
					$reason 		= $request->parameters ['reason'];
					$first 			= $request->parameters ['first'];
					$last 			= $request->parameters ['last'];
					$file_upload 	= false;

					if (isset($_FILES['file'])) {// Test if file upload
						$file_upload = $_FILES['file'];
					}

					$check   		 = self::validate_strikerate(
										$file_upload,
										$promo_name,
										$promo_id,
										$store_id,
										$rep_id,
										$bin_placed,
										$number_bins,
										$number_godnol,
										$reason,
										$first,
										$last
									 );

					return json_encode($check);
				break;

				case 'UploadSurveyImage': 
					$rep_id 			= $request->parameters ['rep_id'];
					$survey_id 			= $request->parameters ['survey_id'];
					$store_id 			= $request->parameters ['store_id'];
					$survey_type 		= $request->parameters ['survey_type'];
					$question_number 	= $request->parameters ['question_number'];
					
					$file_upload 		= false;

					if (isset($_FILES['file'])) {// Test if file upload
						$file_upload = $_FILES['file'];
					}

					$check   		 = self::validate_survey_upload(
										$file_upload,
										$rep_id,
										$survey_id,
										$store_id,
										$survey_type,
										$question_number
									 );

					return json_encode($check);
				break;

				case 'UploadPOSImage': 
					$rep_id 			= $request->parameters ['rep_id'];
					$store_id 			= $request->parameters ['store_id'];
					$poc_id 			= $request->parameters ['poc_id'];
					$category_id		= $request->parameters ['category_id'];
					
					$file_upload 		= false;

					if (isset($_FILES['file'])) {// Test if file upload
						$file_upload 	= $_FILES['file'];
					}

					$check   		 	= self::validate_pos_upload (
											$file_upload,
											$poc_id,
											$category_id,
											$rep_id,
											$store_id
									 	);

					return json_encode($check);
				break;
				default:

					return json_encode (array('success' => false, 'text'=> 'Invalid Post Request'));
					break;
			}

		}

		/**
		 * 
		 *
		 */
		
		static protected function get_rep_data (
										$rep_id
								) {


			$rep_exist 		= self::$app_controller->get_rep_by_repid ($rep_id);


			$monday_date 	= date('Y-m-d',time()+( 1 - date('w'))*24*3600);
			$current_date	= date('Y-m-d H:i');
			$return_data 	= array();

			$monday_date  	= $monday_date . ' 00:00';

			// die(var_dump($monday_date));

			$return_arr 	= array();


			if ($rep_exist === false) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist');
			}

			$week_calls 		= self::$app_controller->get_store_calls ($rep_id);
			$call_target 		= count ($week_calls);
			if (!is_array($week_calls)) {
				$call_target 	= 0;
			}


			$done_calls 		= self::$app_controller->get_store_location_this_week ($rep_id, $monday_date, $current_date);
			$check_current 		= count ($done_calls);

			if (!is_array($done_calls)) {
				$check_current 	= 0;
			}

			$target_week 		= round(($check_current / $call_target) * 100, 0);

			$rep_promos 		= self::$app_controller->get_reps_promos ($rep_id);
			$promos_list 		= self::$app_controller->get_open_promos();

			// var_dump($promos_list);

			foreach ($promos_list as $pl) {
				
				$overal_bins = $pl['number_of_bins'];
				$promo_name  = ucwords(strtolower($pl['promo_description']));
				$promo_id 	 = $pl['promo_id'];

				$promos_last = self::$app_controller->filter_by_value ($rep_promos, 'promo_id', $promo_id);
				
				$total_bins  = 0;
				$store_uids	 = array();
				foreach ($promos_last as $p) {
					$no_of_bins  = $p['bin_placed'];

					$store_name  = (!empty($p['store_name']))
												? $p['store_name'] : 
												  $p['store_name2'];
					$overal_bins = $p['number_of_bins'];

					// -- get unique store -- //
					if(!in_array($p['store_id'], $store_uids)) {
					    $total_bins += $no_of_bins;
					}

					$store_uids[]	= $p['store_id'];

				}


				if (!$overal_bins == 0) {
					$percentage  	= round(($total_bins/$overal_bins) * 100, 2);
				}else{
					$percentage 	= 0;
				}


				$return_arr[] = array(
					'overal_bins' => $overal_bins,
					'total_bins'  => $total_bins,
					'promo_name'  => $promo_name,
					'store_name'  => $store_name,
					'percentage'  => $percentage,
					'promo_id'    => $promo_id

				);

				
			}

			// die(var_dump($target_week));

			$return_data 		= array('target_week' => $target_week, 'promo_info' => $return_arr);

			return $return_data;
		}

		/**
		 * 
		 *
		 */
		
		static protected function get_call_stores_data(
										$rep_id,
										$day_of_week
									) {


			$rep_exist 			= self::$app_controller->get_rep_by_repid ($rep_id);

			if ($rep_exist === false) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist');
			}

			$stores 			= self::$app_controller->get_stores_weeday ($rep_id, $day_of_week);
			$return_array 		= array();

			foreach ($stores as $s) {
				$return_array[]	= array(
						'store_address' => $s['storeAddress'],
						'store_name' 	=> (!empty($s['storeName3']))?$s['storeName3']:$s['storeName'],
						'store_id' 		=> $s['store_id'],
						'phone_number' 	=> $s['phoneNumber']
					);
			}

			// die(var_dump($stores));

			return $return_array;
		}


		/**
		 * 
		 *
		 */
		
		static protected function store_is_checked(
										$rep_id,
										$store_id
									) {


			$rep_exist 			= self::$app_controller->get_rep_by_repid ($rep_id);

			if ($rep_exist === false) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist');
			}

			$store_exist 		= self::$app_controller->get_store_by_id ($store_id);

			if ($store_exist === false) {
				return array('success'=>false, 'text'=>'Store Does\'t exist');
			}

			$today 				= date('Y-m-d 00:00');

			$checkins 			= self::$app_controller->get_location_by_id ($rep_id, $store_id, $today);

			$return_array 		= array();

			if (count($checkins) > 0 && is_array($checkins)) {
				return array('success'=>true, 'checkid_id'=>$checkins[0]['location_id']);
			}else{
				return array('success'=>false, 'text'=>'Not Checked In');
			}

		}

		/**
		 * 
		 *
		 */
		
		static protected function check_last_saved_objective (
										$rep_id,
										$store_id
									) {


			$rep_exist 			= self::$app_controller->get_rep_by_repid ($rep_id);

			if ($rep_exist === false) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist');
			}

			$store_exist 		= self::$app_controller->get_store_by_id ($store_id);

			if ($store_exist === false) {
				return array('success'=>false, 'text'=>'Store Does\'t exist');
			}

			$object 			= self::$app_controller->get_last_saved_objective ($rep_id, $store_id);

			if (!is_array($object) && count($object) == 0) {
				return array('success'=>false, 'text'=>'No Objectives Found');
			}

			$return_array 		= array();

			foreach ($object as $o) {
				$return_array 	= array(
									'success'		=> true,
									'objective_id' 	=> $o['objective_id'],
									'store_id' 		=> $o['store_id'],
									'rep_id' 		=> $o['user_id'],
									'activity' 		=> $o['activity'],
									'checked' 		=> $o['checked'],
									'strategy' 		=> $o['strategy'],
									'date' 			=> $o['date']
								);
			}

			if (count($return_array) > 0 && is_array($return_array)) {
				return $return_array;
			}else{
				return array('success'=>false, 'text'=>'No Objectives Found');
			}

		}


		/**
		 * 
		 *
		 */
		
		static protected function validate_get_store_promos (
										$rep_id,
										$store_id
									) {


			$rep_exist 			= self::$app_controller->get_rep_by_repid ($rep_id);

			if ($rep_exist === false) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist');
			}

			$store_exist 		= self::$app_controller->get_store_by_id ($store_id);

			if ($store_exist === false) {
				return array('success'=>false, 'text'=>'Store Does\'t exist');
			}

			$object 			= self::$app_controller->get_store_promos ($rep_id, $store_id);

			if (!is_array($object) || count($object) == 0) {
				return array('success'=>false, 'text'=>'No Promotions Found');
			}
			
			$return_array['success'] 		= true;

			foreach ($object as $o) {
				$return_array['data'][] 	= array(
									'promo_id' 			=> $o['promo_id'],
									'promo_description' => ucwords(strtolower($o['promo_description'])),
									'start_date' 		=> $o['start_date'],
									'end_date' 			=> $o['end_date'],
									'number_of_bins' 	=> $o['number_of_bins'],
									'inland_bins' 		=> $o['inland_bins'],
									'east_region_bins' 	=> $o['east_region_bins'],
									'eastern_cape_bins' => $o['eastern_cape_bins'],
									'south_region_bins' => $o['south_region_bins'],
									'botswana_bins' 	=> $o['botswana_bins'],
									'date_created' 		=> $o['date_created'],
									'store_id' 			=> $o['store_id'],
									
								);
			}

			if (count($return_array) > 0 && is_array($return_array)) {
				return $return_array;
			}else{
				return array('success'=>false, 'text'=>'No Promotions Found');
			}

		}


		/**
		 * 
		 *
		 */
		
		static protected function validate_get_survey_questions(
										$survey_id,
										$survey_type
									) {

			$return_array 	=  array();
			switch ($survey_type) {
				case 'surveys':
					$surveys 		= self::$app_controller->get_questions_bysurveyid ($survey_id);
					break;
				case 'npd':
					$surveys 		= self::$app_controller->get_questions_npd_bysurveyid ($survey_id);
					break;
				case 'adhoc':
					$surveys 		= self::$app_controller->get_questions_adhoc_bysurveyid ($survey_id);
					break;
				
				
			}

			foreach ($surveys as $s) {

				$return_array[] = array(
					'q_id' => $s['id'],
					'survey_id' => $s['survey_id'],
					'q_num' => $s['q_num'],
					'q_text' => $s['q_text'],
					'q_options' => explode( ',', $s['q_options'] ),
					'q_type' => $s['q_type']
				);

			}
			
			return $return_array;

		}




		/**
		 * 
		 *
		 */
		
		static protected function validate_get_surveys (
										$rep_id,
										$store_id
									) {


			$rep_exist 			= self::$app_controller->get_rep_by_repid ($rep_id);

			if ($rep_exist === false) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist');
			}

			$store_exist 		= self::$app_controller->get_store_by_id ($store_id);

			if ($store_exist === false) {
				return array('success'=>false, 'text'=>'Store Does\'t exist');
			}

			$surveys 			= self::get_survey_list ($store_id, $rep_id);
			$npd_surveys 		= self::get_npd_survey_list ($store_id);
			$adhoc_surveys 		= self::get_adhoc_survey_list ($store_id, $rep_id);
			
			
			$return_array['success'] 				= true;

			$return_array['data']['surveys'] 		= $surveys;
			$return_array['data']['npd_surveys'] 	= $npd_surveys;
			$return_array['data']['adhoc_surveys'] 	= $adhoc_surveys;

			if (count($return_array) > 0 && is_array($return_array)) {
				return $return_array;
			}else{
				return array('success'=>false, 'text'=>'No Promotions Found');
			}

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_get_pos_details (
										$store_id
									) {


			$store_exist 		= self::$app_controller->get_store_by_id ($store_id);
			$poss 				=  array();


			if (count($store_exist) == 0) {
				return array('success'=>false, 'text'=>'Store Does\'t exist');
			}

			$store_list   			= self::$app_controller->get_stores_information ();
			$pos_list 				= self::$app_controller->get_pos_details ();


			$find_store_filtered 	= self::$app_controller->filter_by_value ($store_list, 'store_id', $store_id);

			// die(var_dump($pos_list));

			foreach ($pos_list as $sl) {

				$assignee_id    = $sl['assignee_id'];
				$level_name     = strtolower($sl['level_name']);
				$pos_id 		= $sl['id'];
				$pos_title   	= $sl['title'];
				$description    = $sl['description'];
				$category_id    = $sl['category_id'];
				$upload_image   = $sl['upload_image'];

				$assignee_array = explode(',', $assignee_id);


				foreach ($assignee_array as $ass) {
			  	
				    foreach ($find_store_filtered as $fs) {
						$fstore_id = $fs[$level_name];

						if ($ass == $fstore_id) {
							$poss[] = $sl;
				    	}
				    }


				}
			}
			$return = array();
			foreach ($poss as $p) {
				$return[] = array(
						"category_id"=> $p["category_id"],
						"poc_id"=> $p["poc_id"],
						"category_name"=> $p["category_name"],
						"pos_title"=> $p["pos_title"],
						"pos_description"=> $p["pos_description"],
						"pos_upload_image"=> 'http://admin.nconnectapp.co.za/files/PictureOfSuccess/' . $p["pos_upload_image"],
						"assign_to"=> $p["assign_to"],
						"assignee_id"=> $p["assignee_id"],
						"level_name"=> $p["level_name"]
					); 
			}
			
			
			
			$return_array['success'] 	= true;

			$return_array['data']		= $return;
			if (count($return_array) > 0 && is_array($return_array)) {
				return $return_array;
			}else{
				return array('success'=>false, 'text'=>'No Promotions Found');
			}

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_get_rass_details (
										$store_id
									) {


			$store_exist 		= self::$app_controller->get_store_by_id ($store_id);
			$poss 				=  array();


			if (count($store_exist) == 0) {
				return array('success'=>false, 'text'=>'Store Does\'t exist');
			}

			$store_list   			= self::$app_controller->get_stores_information ();
			$pos_list 				= self::$app_controller->get_rass_details ();


			$find_store_filtered 	= self::$app_controller->filter_by_value ($store_list, 'store_id', $store_id);

			// die(var_dump($pos_list));

			foreach ($pos_list as $sl) {

				$assignee_id    = $sl['assignee_id'];
				$level_name     = strtolower($sl['level_name']);
				$pos_id 		= $sl['id'];
				$pos_title   	= $sl['title'];
				$description    = $sl['description'];
				$category_id    = $sl['category_id'];

				$assignee_array = explode(',', $assignee_id);


				foreach ($assignee_array as $ass) {
			  	
				    foreach ($find_store_filtered as $fs) {
						$fstore_id = $fs[$level_name];

						if ($ass == $fstore_id) {
							$poss[] = $sl;
				    	}
				    }


				}
			}
			$return = array();
			foreach ($poss as $p) {
				$return[] = array(
						"category_id"=> $p["category_id"],
						"poc_id"=> $p["poc_id"],
						"category_name"=> $p["category_name"],
						"pos_title"=> $p["pos_title"],
						"pos_description"=> $p["pos_description"],
						"assign_to"=> $p["assign_to"],
						"assignee_id"=> $p["assignee_id"],
						"level_name"=> $p["level_name"]
					); 
			}
			
			
			
			$return_array['success'] 	= true;

			$return_array['data']		= $return;
			if (count($return_array) > 0 && is_array($return_array)) {
				return $return_array;
			}else{
				return array('success'=>false, 'text'=>'No Promotions Found');
			}

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_get_product_list (
												$category_id
										   ) {


			$products 				= self::$app_controller->get_randass_products ($category_id);
			$return_array 		 	=  array();


			if (count($products) == 0) {
				return array('success'=>false, 'text'=>'Products Not Found');
			}

			
			$return = array();
			foreach ($products as $p) {
				$return[] = array(
						"product_name"=> $p["product_name"],
						"product_id"=> $p["product_id"],
						"description"=> $p["description"],
						"created"=> $p["created"],
						"sku"=> $p["sku"]
					); 
			}
			
			
			$return_array['success'] 	= true;

			$return_array['data']		= $return;
			if (count($return_array) > 0 && is_array($return_array)) {
				return $return_array;
			}else{
				return array('success'=>false, 'text'=>'No Products Found');
			}

		}


		/**
		 * @param
		 * @return
		 */
		static public function get_adhoc_survey_list ($store_id, $rep_id) {

			$return_array 	=  array();
			$surveys 		=  array();

			$store_list   	= self::$app_controller->get_stores_information ();
			$survey_list    = self::$app_controller->get_adhocs ();

			// $surveys 		= self::$app_controller->get_survey_list_by_store ($store_id);

			// var_dump($store_list);
			$find_store_filtered 	= self::$app_controller->filter_by_value ($store_list, 'store_id', $store_id);

			foreach ($survey_list as $sl) {

			  $assignee_id    = $sl['assignee_id'];
			  $level_name     = strtolower($sl['level_name']);
			  $survey_id      = $sl['id'];
			  $survey_title   = $sl['title'];
			  $description    = $sl['description'];

			  $assignee_array = explode(',', $assignee_id);


			  foreach ($assignee_array as $ass) {
			    
			    foreach ($find_store_filtered as $fs) {
			    	$fstore_id = $fs[$level_name];


			    	if ($ass == $fstore_id) {
						$surveys[] = $sl;
			    	}
			    }
			  }
			}


			

			foreach ($surveys as $s) {

				$now 			= strtotime(date('d-m-Y'));
				$id 			= $s['id'];
				$title 			= $s['title'];
				$description 	= $s['description'];
				$start_date 	= $s['start_date'];
				$end_date 		= $s['end_date'];
				$assign_to 		= $s['assign_to'];
				$assignee_id 	= $s['assignee_id'];
				$level_name 	= $s['level_name'];
				$status 		= $s['status'];
				$created 		= $s['created'];

				$start_date_f 	= str_replace('/', '-', $start_date);
				$end_date_f		= str_replace('/', '-', $end_date);

				$start			= strtotime($start_date_f);
				$end 			= strtotime($end_date_f);

				// var_dump($start_date_f);
				// var_dump($now);
				// die();

				$responces 		= self::$app_controller->get_adhoc_responces_by_store_id ($id, $store_id);


				if (count($responces) === 0) {


					if($start <= $now AND $end >= $now) {
					    $return_array[] = array(
					    	'id' => $id,
					    	'title' => $title,
					    	'description' => $description,
					    	'start_date' => $start_date,
					    	'end_date' => $end_date,
					    	'assign_to' => $assign_to,
					    	'assignee_id' => $assignee_id,
					    	'level_name' => $level_name,
					    	'status' => $status,
					    	'created' => $created
				    	);
					}
					// die(var_dump(date()));
				}else{
					$show_survey = false;
					foreach ($responces as $r) {
						$q_num 		= $r['q_num'];
						$responce   = strtolower($r['responce']);

						if ($responce == 'no') {
							$show_survey = true;
						}
					}

					if ($show_survey) {
						if($start <= $now AND $end >= $now) {
						    $return_array[] = array(
						    	'id' => $id,
						    	'title' => $title,
						    	'description' => $description,
						    	'start_date' => $start_date,
						    	'end_date' => $end_date,
						    	'assign_to' => $assign_to,
						    	'assignee_id' => $assignee_id,
						    	'level_name' => $level_name,
						    	'status' => $status,
						    	'created' => $created
					    	);
						}
					}
				}

			}

			return self::$app_controller->array_remove_dublicates ($return_array, 'id');
		}


		/**
		 * @param
		 * @return
		 */
		static public function get_npd_survey_list ($store_id) {

			$return_array 	=  array();
			$surveys 	=  array();

			$store_list   	= self::$app_controller->get_stores_information ();
			$survey_list    = self::$app_controller->get_surveys ();

			// $surveys 		= self::$app_controller->get_survey_list_by_store ($store_id);

			// var_dump($store_list);
			// die();

			foreach ($survey_list as $s) {

			  $assignee_id    = $s['assignee_id'];
			  $level_name     = $s['level_name'];
			  $survey_id      = $s['id'];
			  $survey_title   = $s['title'];
			  $description    = $s['description'];

			  $assignee_array = explode(',', $assignee_id);

			  // Get
			  $find_store_filtered 	= self::$app_controller->filter_by_value ($store_list, 'store_id', $store_id);

			  // die(var_dump($find_store_filtered));

			  foreach ($assignee_array as $ass) {
			    $find_store = self::$app_controller->filter_by_value ($find_store_filtered, strtolower($level_name), $ass);

			    // // print_r($level_name);
			    

			    if (count($find_store) > 0) {
			    	// die(var_dump($find_store));
			      $surveys[] = $s;
			    }



			    
			  }

			}
			

			foreach ($surveys as $s) {

				$now 			= strtotime(date('d-m-Y'));
				$id 			= $s['id'];
				$title 			= $s['title'];
				$description 	= $s['description'];
				$start_date 	= $s['start_date'];
				$end_date 		= $s['end_date'];
				$assign_to 		= $s['assign_to'];
				$assignee_id 	= $s['assignee_id'];
				$level_name 	= $s['level_name'];
				$status 		= $s['status'];
				$created 		= $s['created'];

				$start_date_f 	= str_replace('/', '-', $start_date);
				$end_date_f		= str_replace('/', '-', $end_date);

				$start			= strtotime($start_date_f);
				$end 			= strtotime($end_date_f);
				// die(var_dump($start));

				// $responces 		= self::$app_controller->get_responces_bysurveyid($id);
				$responces 		= self::$app_controller->get_responces_byrepid($id, $rep_id);

				if (count($responces) === 0) {

					if($start <= $now && $end >= $now) {
					    $return_array[] = array(
					    	'id' => $id,
					    	'title' => $title,
					    	'description' => $description,
					    	'start_date' => $start_date,
					    	'end_date' => $end_date,
					    	'assign_to' => $assign_to,
					    	'assignee_id' => $assignee_id,
					    	'level_name' => $level_name,
					    	'status' => $status,
					    	'created' => $created
					    	);
					}
				}

			}


			return $return_array;
		}


		/**
		 * @param
		 * @return
		 */
		static public function get_survey_list ($store_id, $rep_id) {

			$return_array 	=  array();
			$surveys 		=  array();

			$store_list   	= self::$app_controller->get_stores_information ();
			$survey_list    = self::$app_controller->get_surveys ();

			// $surveys 		= self::$app_controller->get_survey_list_by_store ($store_id);

			// get store infomration
			$find_store_filtered 	= self::$app_controller->filter_by_value ($store_list, 'store_id', $store_id);



			foreach ($survey_list as $sl) {

			  $assignee_id    = $sl['assignee_id'];
			  $level_name     = strtolower($sl['level_name']);
			  $survey_id      = $sl['id'];
			  $survey_title   = $sl['title'];
			  $description    = $sl['description'];

			  $assignee_array = explode(',', $assignee_id);

			  // Get
			  


			  foreach ($assignee_array as $ass) {
			  	
			    foreach ($find_store_filtered as $fs) {
			    	# code...
			    	$fstore_id = $fs[$level_name];

			    	if ($ass == $fstore_id) {
						$surveys[] = $sl;
			    	}
			    }


			    // if (count($find_store) > 0) {
			    //   $surveys[] = $s;
			    // }
			  }
			}


			
			foreach ($surveys as $s) {
				
				$now 			= strtotime(date('d-m-Y'));
				$id 			= $s['id'];
				$title 			= $s['title'];
				$description 	= $s['description'];
				$start_date 	= $s['start_date'];
				$end_date 		= $s['end_date'];
				$assign_to 		= $s['assign_to'];
				$assignee_id 	= $s['assignee_id'];
				$level_name 	= $s['level_name'];
				$status 		= $s['status'];
				$created 		= $s['created'];

				$start_date_f 	= str_replace('/', '-', $start_date);
				$end_date_f		= str_replace('/', '-', $end_date);

				$start			= strtotime($start_date_f);
				$end 			= strtotime($end_date_f);
				// die(var_dump($start));

				// $responces 		= self::$app_controller->get_responces_bysurveyid($id);
				// $responces 		= self::$app_controller->get_responces_byrepid($id, $rep_id);
				$responces 		= self::$app_controller->get_responces_by_store_id ($id, $store_id);

				// if ($id == 12) {
				// 	die(var_dump($responces));
				// }

					
				// if (count($responces) === 0) {


					if($start <= $now && $end >= $now) {
					    $return_array[] = array(
					    	'id' => $id,
					    	'title' => $title,
					    	'description' => $description,
					    	'start_date' => $start_date,
					    	'end_date' => $end_date,
					    	'assign_to' => $assign_to,
					    	'assignee_id' => $assignee_id,
					    	'level_name' => $level_name,
					    	'status' => $status,
					    	'created' => $created
					    	);
					}
				// }

			}


			return self::$app_controller->array_remove_dublicates ($return_array, 'id');
		}

		/**
		 * 
		 *
		 */
		
		static protected function store_is_checkedout(
										$location_id
									) {


			$loc_exist 		= self::$app_controller->get_location_by_locid ($location_id);

			if ($loc_exist === false) {
				return array('success'=>false, 'text'=>'Did Not CheckOut');
			}


			$today 				= date('Y-m-d 00:00');

			$checkouts 			= self::$app_controller->get_location_checkout_by_id ($location_id, $today);

			$return_array 		= array();

			if (count($checkouts) > 0 && is_array($checkouts)) {
				return array('success'=>true, 'checkid_id'=>$checkouts[0]['location_id']);
			}else{
				return array('success'=>false, 'text'=>'Not Checked Out');
			}

		}



		/**
		 * 
		 *
		 */
		
		static protected function validate_objective(
										$params
									) {


			extract($params, EXTR_PREFIX_SAME, "wddx");

			$smart_string = array();
			

			// validate username
			if(empty($activity)){
				return array('success'=>false, 'text'=>'Invalid Activity');
			}

			// validate username
			if(empty($strategy)){
				return array('success'=>false, 'text'=>'Invalid Strategy');
			}


			$rep_exist 	= self::$app_controller->get_rep_by_repid ($rep_id);

			if ($s === true) {
				$smart_string[] = 's';
			}
			if ($m === true) {
				$smart_string[] = 'm';
			}

			if ($a === true) {
				$smart_string[] = 'a';
			}

			if ($r === true) {
				$smart_string[] = 'r';
			}

			if ($t === true) {
				$smart_string[] = 't';
			}

			// validate query error
			if (count($rep_exist) < 1) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist' . $rep_id);
			}

			$save 		= self::$app_controller->insert_new_objective ($store_id, $rep_id, $activity, implode(',', $smart_string), $strategy);

			if ($save === true) {
				return array('success'=>true, 'text' => 'Successfuly Saved');
			}else{
				return array('success'=>false, 'text' => 'Error, ' .$save);
			}
			

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_strikerate_noimage(
										$params
									) {


			// die(var_dump($params));
			extract($params, EXTR_PREFIX_SAME, "wddx");

			$smart_string = array();
			
			$rep_exist 	= self::$app_controller->get_rep_by_repid ($rep_id);
			// validate query error
			if (count($rep_exist) < 1) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist' . $rep_exist);
			}

			if (empty($bin_placed)) {
				return array('success'=>false, 'text'=>'Have you Placed any Bins?');
			}

			if (empty($promo_id)) {
				return array('success'=>false, 'text'=>'Please Select Promotion');
			}

			if (empty($store_id)) {
				return array('success'=>false, 'text'=>'Invalid Store');
			}


			if ($bin_placed === 'no') {
				if (empty($reason)) {
					return array('success'=>false, 'text'=>'Reason?');
				}
			}

			$image_string 	= rtrim($images, ",");


			$save 			= self::$app_controller->save_new_strikerate ($promo_id, $rep_id, $store_id, $number_bins, $number_godnola, $reason, $image_string);

			if ($save === true) {
				return array('success'=>true, 'text' => 'Successfuly Saved');
			}else{
				return array('success'=>false, 'text' => 'Error, ' .$save);
			}
			

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_picture_of_success(
										$params
									) {


			// die(var_dump($params));
			extract($params, EXTR_PREFIX_SAME, "wddx");

			$smart_string 	= array();
			
			$rep_exist 		= self::$app_controller->get_rep_by_repid ($rep_id);
			// validate query error
			if (count($rep_exist) < 1) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist' . $rep_exist);
			}

			if (empty($category_inline)) {
				return array('success'=>false, 'text'=>'Is the category in line with the picture of success?');
			}

			if (empty($store_id)) {
				return array('success'=>false, 'text'=>'Invalid Store');
			}

			if ($category_inline == 'yes') {
				if (empty($image_names)) {
					return array('success'=>false, 'text'=>'Please Upload Image');
				}
			}


			$image_string 	= rtrim($image_names, ",");


			$save 			= self::$app_controller->save_new_pos ($rep_id, $store_id, $category_id, $category_inline, $poc_id, $image_string);

			if ($save === true) {
				return array('success'=>true, 'text' => 'Successfuly Saved');
			}else{
				return array('success'=>false, 'text' => 'Error, ' .$save);
			}
			

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_survey_submit(
										$params
									) {


			// die(var_dump(json_encode($params)));
			extract($params, EXTR_PREFIX_SAME, "wddx");

			// $smart_string = array();
			
			$rep_exist 	= self::$app_controller->get_rep_by_repid ($rep_id);
			// validate query error
			if (count($rep_exist) < 1) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist' . $rep_exist);
			}

			if (empty($store_id)) {
				return array('success'=>false, 'text'=>'Invalid Store');
			}

			if (!isset($survey_id)) {
				return array('success'=>false, 'text'=> 'Invalid Survey ID');
			}

			if (!isset($survey_type)) {
				return array('success'=>false, 'text'=> 'Invalid Survey Type');
			}


			//*** get surevy questions ***/
			switch ($survey_type) {
				case 'surveys':
					$surveys 		= self::$app_controller->get_questions_bysurveyid ($survey_id);
					break;
				case 'npd':
					$surveys 		= self::$app_controller->get_questions_npd_bysurveyid ($survey_id);
					break;
				case 'adhoc':
					$surveys 		= self::$app_controller->get_questions_adhoc_bysurveyid ($survey_id);
					break;
				
				default:
					return array('success'=>false, 'text'=>'No Survey Questions Found');
					break;
			}

			// die(var_dump($surveys));



			foreach ($surveys as $s) {


				$q_num 		= $s['q_num'];
				$q_id 		= $s['id'];
				$q_name		= 'question' . $q_num;
				$q_type 	= $s['q_type'];

				$options 	= explode( ',', $s['q_options'] );

				



				if (empty($$q_name) OR 
					!isset($$q_name)
				) {
					if ($q_type == 'checkbox') {
						$resp_str = array();
						foreach ($options as $count => $option) {
							if ($params[$q_name.'['.$option.']']) {
								$resp_str[] = $option;
							}
						}

						if (empty($resp_str)) {
							$errors   .= 'Please answer question ' .$q_num. '<br />';
						}else{
							$responce = implode(',', $resp_str);
						}

						$save_array[] = array(
							'survey_id'	=> $survey_id,
							'store_id'	=> $store_id,
							'rep_id'	=> $rep_id,
							'q_id'		=> $q_id,
							'q_num'		=> $q_num,
							'responce'	=> $responce
							);

						
					}else{
						$errors   .= 'Please answer question ' .$q_num. '<br />';
					}

					
				}else{

					$responce  = $$q_name;

					if ($q_type == 'checkbox') {// Checkbox
						$resp_str = array();
						foreach ($options as $count => $option) {
							if ($params[$q_name.'['.$count.']']) {
								$resp_str[] = $option;
							}
						}

						$responce = implode(',', $resp_str);
							
					}else{
						$responce  = $$q_name;
					}
						
					$save_array[] = array(
						'survey_id'	=> $survey_id,
						'store_id'	=> $store_id,
						'rep_id'	=> $rep_id,
						'q_id'		=> $q_id,
						'q_num'		=> $q_num,
						'responce'	=> $responce
						);
						
					
				}

			}

			if (!empty($errors)) {
				$return_array 		= array('status' => false, 'text' => $errors);
			}else{



				foreach ($save_array as $sa) {
					$survey_id 		= $sa['survey_id'];
					$store_id 		= $sa['store_id'];
					$rep_id 		= $sa['rep_id'];
					$q_num 			= $sa['q_num'];
					$q_id 			= $sa['q_id'];
					$responce 		= $sa['responce'];

					// Test if already answered
					$responces_arr 	= self::$app_controller->get_responces ($survey_id, $store_id, $rep_id, $q_num, $survey_type);

					// var_dump($responces_arr);
					// die();

					if (count($responces_arr) === 0) {// not answered yet
						$save 	= self::$app_controller->insert_survey_responce ($survey_id, $store_id, $rep_id, $q_id, $q_num, $responce, $survey_type);
					}else{
						$save 	= self::$app_controller->update_survey_responce ($survey_id, $store_id, $rep_id, $q_id, $q_num, $responce, $survey_type);
					}
					
				}

				$return_array 	= array('success'=>true, 'text' => 'Successfuly Saved');
			}

			return $return_array;

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_strikerate(
										$file_upload,
										$promo_name,
										$promo_id,
										$store_id,
										$rep_id,
										$bin_placed,
										$number_bins,
										$number_godnol,
										$reason,
										$first,
										$last
									 ) {

			


			
			$image_name					= 'strikerate-id';
			$dir 						= '../admin.nconnectapp.co.za/images/testimages/';

			// $images 			= preg_grep('/^strikerate-id-143656805/i', scandir($dir));
			// $files 				= preg_grep('/^strikerate-id-143656805*', scandir($dir));

			// die(var_dump($images));
			

			$rep_exist 			= self::$app_controller->get_rep_by_repid ($rep_id);
			// validate query error
			if (count($rep_exist) < 1) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist' . $rep_exist);
			}

			$rand_id = rand();

			if (!empty($file_upload)) {
				// Get filename.
				$temp 		 	= explode(".", $file_upload["name"]);
				// Generate new random name.
				$name 			= $image_name .'-'. $rand_id .'-'. time().'.'.$temp[1];
				$find_names 	= $image_name .'-'. $rand_id .'-';
				$upload 		= move_uploaded_file ($file_upload["tmp_name"], getcwd(). '/' .$dir .'/'. $name);
				
			}else{
				return array('success'=>false, 'text' => 'Failed to upload');
			}
			
			if ($upload) {
				return array('success'=>true, 'text' => 'Image Uploaded', 'image_name' => $name);
			}else{
				return array('success'=>false, 'text' => 'Error, ' .$upload);
			}
			

			
			

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_survey_upload(
										$file_upload,
										$rep_id,
										$survey_id,
										$store_id,
										$survey_type,
										$question_number
									 ) {

			

			if (!isset($survey_id)) {
				return array('success'=>false, 'text'=> 'Invalid Survey ID');
			}

			if (!isset($survey_type)) {
				return array('success'=>false, 'text'=> 'Invalid Survey Type');
			}

			$survey_type_name 			= $survey_type .'s';
			$dir 						= '../admin.nconnectapp.co.za/files/' .$survey_type_name .'/'. $survey_id .'/';
			self::$app_controller->created_directory ($dir);

			// $images 			= preg_grep('/^strikerate-id-143656805/i', scandir($dir));
			// $files 				= preg_grep('/^strikerate-id-143656805*', scandir($dir));

			// die(var_dump($images));
			

			$rep_exist 			= self::$app_controller->get_rep_by_repid ($rep_id);
			// validate query error
			if (count($rep_exist) < 1) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist' . $rep_exist);
			}


			if (!empty($file_upload)) {
				// Get filename.
				$temp 		 	= explode(".", $file_upload["name"]);
				$ext 			= $temp[1];
				$image_name 	= $question_number .'_'. $survey_id .'_'.$store_id.'_'.$rep_id.'.'.$ext;

				$upload 		= move_uploaded_file ($file_upload["tmp_name"], getcwd(). '/' .$dir .'/'. $image_name);
				
			}else{
				return array('success'=>false, 'text' => 'Failed to upload');
			}
			
			if ($upload) {
				return array('success'=>true, 'text' => 'Image Uploaded', 'image_name' => $image_name);
			}else{
				return array('success'=>false, 'text' => 'Error, ' .$upload);
			}
			
		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_pos_upload(
											$file_upload,
											$poc_id,
											$category_id,
											$rep_id,
											$store_id
									 	) {

			

			$rep_exist 			= self::$app_controller->get_rep_by_repid ($rep_id);
			// validate query error
			if (count($rep_exist) < 1) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist' . $rep_exist);
			}

			$dir 				= '../admin.nconnectapp.co.za/files/PictureOfSuccess/';


			if (!empty($file_upload)) {
				// Get filename.
				$temp 		 	= explode(".", $file_upload["name"]);
				$ext 			= $temp[1];
				$image_name 	= $temp[0] .'_'. $poc_id .'_'.$category_id .'_'.$store_id.'_'.$rep_id.'_'. time().'.'.$ext;

				$upload 		= move_uploaded_file ($file_upload["tmp_name"], getcwd(). '/' .$dir .'/'. $image_name);
				
			}else{
				return array('success' => false, 'text' => 'Failed to upload');
			}
			
			if ($upload) {
				return array('success'=>true, 'text' => 'Image Uploaded', 'image_name' => $image_name);
			}else{
				return array('success'=>false, 'text' => 'Error, ' .$upload);
			}
			
		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_login (
										$rep_id,
										$password
								) {

			// validate username
			if(empty($rep_id)){
				return array('success'=>false, 'text'=>'Invalid Rep ID or Password');
			}

			// validate username
			if(empty($password)){
				return array('success'=>false, 'text'=>'Invalid Rep ID or Password');
			}


			$rep_exist = self::$app_controller->get_rep_by_repid ($rep_id);

			// validate query error

			// die(var_dump($rep_exist['password']));

			if ($rep_exist === false) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist');
			}

			$db_password  	= $rep_exist['password'];
			$rep_name  		= $rep_exist['repName'];
			$token			= md5($rep_id.$rep_name.$db_password);


			// validate password //
			if ($db_password !== $password) {
				return array('success'=>false, 'text'=>'Invalid Rep ID or Password!');
			}

	
			return array('success'=>true, 're_id'=>$rep_id, 'rep_name'=>$rep_name, 'token'=>$token);
			

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_checkin(
										$rep_id,
										$store_id,
										$latitude,
										$longitude
									) {

			// validate username
			if(empty($rep_id)){
				return array('success'=>false, 'text'=>'Invalid Rep ID or Password');
			}

			// validate username
			if(empty($store_id)){
				return array('success'=>false, 'text'=>'Invalid StoreID');
			}

			if(empty($latitude)){
				return array('success'=>false, 'text'=>'Invalid Latitude');
			}

			if(empty($longitude)){
				return array('success'=>false, 'text'=>'Invalid Longitude');
			}


			$rep_exist 		= self::$app_controller->get_rep_by_repid ($rep_id);

			// validate query error

			if ($rep_exist === false) {
				return array('success'=>false, 'text'=>'Rep Does\'t exist');
			}

			$chekin 		= self::$app_controller->insert_new_chekin ($rep_id, $store_id, $latitude, $longitude);

			if (!$chekin) {
				return array('success'=>false, 'text'=>'Error Inserting Checkin');
			}

	
			return array('success'=>true, 're_id'=>$rep_id, 'store_id'=>$store_id);
			

		}

		/**
		 * 
		 *
		 */
		
		static protected function validate_checkout(
										$location_id
									) {

			// validate username
			if(empty($location_id)){
				return array('success'=>false, 'text'=>'Did Not Check In');
			}


			$loc_exist 		= self::$app_controller->get_location_by_locid ($location_id);

			// validate query error

			if ($loc_exist === false) {
				return array('success'=>false, 'text'=>'Did Not Check In');
			}

			$chekout 		= self::$app_controller->check_out_store ($location_id);

			if (!$chekout) {
				return array('success'=>false, 'text'=>'Error Checkout');
			}

	
			return array('success'=>true, 'location_id'=>$location_id);
			

		}


		/**
		 * 
		 *
		 */
		
		static protected function validate_login2 ($username, $password) {

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
				return array('status'=>false, 'texts'=>$user_exist);
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

