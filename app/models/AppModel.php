<?php
/**
 * @package  
 * @author   Sboniso Nzimande
 * @abstract
 */
abstract class AppModel 
{
	/* Connection variable */
	static public $mysqli;
	// static public $web_mysqli;
	static public $mssql;

	public function __construct() {
		self::$mysqli      = new PDODB;
		
		// self::$mssql       = new MsSqlDB;// Connect to a MsSql database

		self::change_timezone();
	}


	/**
	 * @param  
	 * @return 
	 */
	static public function get_all_people_db () {

		try{
			$statement 	= self::$mysqli->prepare("SELECT * FROM `people`");

			$statement->execute();

			$row 		= $statement->fetchAll(); 
			// var_dump($row);

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_user_by_name_db ($username) {

		try{
			$statement 	= self::$mysqli->prepare("SELECT * FROM users WHERE username = :username");
			$statement->execute(array(":username" => $username));

			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_store_by_id_db ($store_id) {

		static $statement = null;

		try{
			$query    	= "SELECT * FROM stores WHERE store_id = :store_id";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":store_id" => $store_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_pos_categories_db () {

		static $statement = null;

		try{
			$query    	= "SELECT * FROM poc_categories ORDER BY created";

			$statement 	= self::$mysqli->prepare($query);

			$statement->execute ();
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_pos_details_db () {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  c.`id` AS category_id,
							  l.`id` AS poc_id,
							  c.`category_name`,
							  l.`title` AS pos_title,
							  l.`description` AS pos_description,
							  l.`upload_image` AS pos_upload_image,
							  l.`assign_to`,
							  l.`assignee_id`,
							  l.`level_name`
							FROM
							  poc_categories AS c 
							  INNER JOIN `poc_list` AS l 
							    ON c.`id` = l.`category_id`";

							    // echo $query;

			$statement 	= self::$mysqli->prepare($query);

			$statement->execute ();
			

			
			$row 		= $statement->fetchAll(); 
			// var_dump($row);

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_rass_details_db () {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  c.`id` AS category_id,
							  l.`id` AS poc_id,
							  c.`category_name`,
							  l.`title` AS pos_title,
							  l.`description` AS pos_description,
							  l.`assign_to`,
							  l.`assignee_id`,
							  l.`level_name` 
							FROM
							  `rang_ass_categories` AS c 
							  INNER JOIN `rang_ass_list` AS l 
							    ON c.`id` = l.`category_id` ";

							    // echo $query;

			$statement 	= self::$mysqli->prepare($query);

			$statement->execute ();
			

			
			$row 		= $statement->fetchAll(); 
			// var_dump($row);

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_location_by_id_db ($rep_id, $store_id, $today) {

		static $statement = null;

		try{

			$query    	= "SELECT * FROM locations WHERE user_id = :rep_id AND store_id = :store_id AND FROM_UNIXTIME(checkIn, '%Y-%m-%d %H:%i') >= :today";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":rep_id" => $rep_id, ":store_id" => $store_id, ":today" => $today);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_responces_by_store_id_db ($survey_id, $store_id) {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  * 
							FROM
							  `survey_responces` 
							WHERE survey_id = :survey_id
								AND store_id  = :store_id;";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":survey_id" => $survey_id, ":store_id" => $store_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_responces_byrepid_db ($survey_id, $rep_id) {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  * 
							FROM
							  `survey_responces` 
							WHERE survey_id = :survey_id
								AND rep_id  = :rep_id;";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":survey_id" => $survey_id, ":rep_id" => $rep_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_randass_products_db ($category_id) {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  * 
							FROM
							  `rand_ass_products` 
							WHERE category_id = :category_id;";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":category_id" => $category_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_adhoc_responces_by_store_id_db ($survey_id, $store_id) {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  * 
							FROM
							  `adhoc_responces` 
							WHERE survey_id = :survey_id
								AND store_id  = :store_id;";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":survey_id" => $survey_id, ":store_id" => $store_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_responces_db ($survey_id, $store_id, $rep_id, $q_num, $survey_type) {

		static $statement = null;

		try{

			switch ($survey_type) {
				case 'surveys':
					$table_name 		= 'survey_responces';
					break;
				case 'npd':
					$table_name 		= 'npd_responces';
					break;
				case 'adhoc':
					$table_name 		= 'adhoc_responces';
					break;
				
				default:
					$table_name = '';
					break;
			}

			$query    	= "SELECT 
							  * 
							FROM
							  ".$table_name."
							WHERE survey_id = :survey_id
							  AND store_id = :store_id
							  AND rep_id = :rep_id
							  AND q_num = :q_num;";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":survey_id" => $survey_id, ":store_id" => $store_id, ":rep_id" => $rep_id, ":q_num" => $q_num);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function insert_survey_responce_db ($survey_id, $store_id, $rep_id, $q_id, $q_num, $responce, $survey_type) {

		static $statement = null;

		try{

			switch ($survey_type) {
				case 'surveys':
					$table_name 		= 'survey_responces';
					break;
				case 'npd':
					$table_name 		= 'npd_responces';
					break;
				case 'adhoc':
					$table_name 		= 'adhoc_responces';
					break;
				
				default:
					$table_name = '';
					break;
			}

			$query    	= "INSERT INTO ".$table_name." (
							  `survey_id`,
							  `store_id`,
							  `rep_id`,
							  `q_id`,
							  `q_num`,
							  `responce`
							) 
							VALUES
							  (
							    :survey_id,
							    :store_id,
							    :rep_id,
							    :q_id,
							    :q_num,
							    :responce
							  );";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (
								":survey_id" => $survey_id, 
								":store_id" => $store_id, 
								":rep_id" => $rep_id, 
								":q_id" => $q_id, 
								":q_num" => $q_num,
								":responce" => $responce,
								);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function update_survey_responce_db ($survey_id, $store_id, $rep_id, $q_id, $q_num, $responce, $survey_type) {

		static $statement = null;

		try{

			switch ($survey_type) {
				case 'surveys':
					$table_name 		= 'survey_responces';
					break;
				case 'npd':
					$table_name 		= 'npd_responces';
					break;
				case 'adhoc':
					$table_name 		= 'adhoc_responces';
					break;
				
				default:
					$table_name 		= '';
					break;
			}

			$query    	= "UPDATE 
							  	".$table_name."
							  SET
							  responce 		 = :responce
							WHERE survey_id  = :survey_id
							  AND store_id 	 = :store_id
							  AND rep_id 	 = :rep_id
							  AND q_id 		 = :q_id
							  AND q_num 	 = :q_num";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (
								":survey_id" => $survey_id, 
								":store_id" => $store_id, 
								":rep_id" => $rep_id, 
								":q_id" => $q_id, 
								":q_num" => $q_num,
								":responce" => $responce,
							);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_questions_bysurveyid_db ($survey_id) {

		static $statement = null;

		try{

			$query    	= "SELECT 
						  q.*,
						  s.`id` AS s_id,
						  s.`title`,
						  s.`description`,
						  s.`end_date`,
						  s.`start_date`,
						  s.`assignee_id`,
						  s.`assign_to`,
						  s.`level_name`,
						  s.`status`,
						  s.`created` 
						FROM
						  `survey_questions` AS q 
						  INNER JOIN `survey_list` AS s 
						    ON q.`survey_id` 	= s.`id` 
						WHERE q.`survey_id` 	= :survey_id
						ORDER BY CAST(q_num AS DECIMAL(10,2));";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":survey_id" => $survey_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_questions_npd_bysurveyid_db ($survey_id) {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  q.*,
							  s.`id` AS s_id,
							  s.`title`,
							  s.`description`,
							  s.`end_date`,
							  s.`start_date`,
							  s.`assignee_id`,
							  s.`assign_to`,
							  s.`level_name`,
							  s.`status`,
							  s.`created` 
							FROM
							  `npd_questions` AS q 
							  INNER JOIN `npd_list` AS s 
							    ON q.`survey_id` 	= s.`id` 
							WHERE q.`survey_id` 	= :survey_id
							ORDER BY CAST(q_num AS DECIMAL(10,2));";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":survey_id" => $survey_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_questions_adhoc_bysurveyid_db ($survey_id) {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  q.*,
							  s.`id` AS s_id,
							  s.`title`,
							  s.`description`,
							  s.`end_date`,
							  s.`start_date`,
							  s.`assignee_id`,
							  s.`assign_to`,
							  s.`level_name`,
							  s.`status`,
							  s.`created` 
							FROM
							  `adhoc_questions` AS q 
							  INNER JOIN `adhoc_list` AS s 
							    ON q.`survey_id` 	= s.`id` 
							WHERE q.`survey_id` 	= :survey_id
							ORDER BY CAST(q_num AS DECIMAL(10,2));";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":survey_id" => $survey_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_surveys_db () {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  *
							FROM
							  survey_list
							ORDER BY created DESC;";

			$statement 	= self::$mysqli->prepare($query);

			// $assoc 		= array (":rep_id" => $rep_id, ":store_id" => $store_id, ":today" => $today);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ();
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_adhocs_db () {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  *
							FROM
							  adhoc_list
							ORDER BY created DESC;";

			$statement 	= self::$mysqli->prepare($query);

			// $assoc 		= array (":rep_id" => $rep_id, ":store_id" => $store_id, ":today" => $today);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ();
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_stores_information_db () {

		static $statement = null;

		try{

			$query    	= "SELECT 
							  * 
							FROM
							  reps AS r 
							  INNER JOIN `rep_store` AS rs 
							    ON r.`rep_id` = rs.`rep_id` 
							  INNER JOIN `stores` AS s 
							    ON rs.`store_id` = s.`store_id`;";

			$statement 	= self::$mysqli->prepare($query);

			// $assoc 		= array (":rep_id" => $rep_id, ":store_id" => $store_id, ":today" => $today);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ();
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_last_saved_objective_db ($rep_id, $store_id) {

		static $statement = null;

		try{

			$query    	= "SELECT * FROM objectives WHERE store_id = :store_id AND user_id = :user_id ORDER BY date DESC  LIMIT 1";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":user_id" => $rep_id, ":store_id" => $store_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function insert_new_objective_db ($store_id, $rep_id, $activity, $smart, $strategy) {

		static $statement 	= null;

		try{
			$statement 		= self::$mysqli->prepare("INSERT INTO objectives (store_id, user_id, activity, checked, strategy) VALUES (:store_id, :user_id, :activity, :checked, :strategy)");
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$return 		= $statement->execute(
								array(
									":store_id" 	=> $store_id,
									":user_id" 		=> $rep_id,
									":activity" 	=> $activity,
									":checked" 		=> $smart,
									":strategy" 	=> $strategy
								));


			return $return;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function save_new_strikerate_db ($promo_id, $rep_id, $store_id, $no_of_bins, $no_of_gondolas, $reason_for_no, $image){

		static $statement 	= null;

		try{
			$statement 		= self::$mysqli->prepare("INSERT INTO promotion_strikerate (promo_id, store_id, user_id, images, no_of_bins, no_of_gondolas, reason_for_no) VALUES (:promo_id, :store_id, :rep_id, :images, :no_of_bins, :no_of_gondolas, :reason_for_no)");
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$return 		= $statement->execute(
								array(
									":promo_id" 		=> $promo_id,
									":store_id" 		=> $store_id,
									":rep_id" 			=> $rep_id,
									":images" 			=> $image,
									":no_of_bins" 		=> $no_of_bins,
									":no_of_gondolas" 	=> $no_of_gondolas,
									":reason_for_no" 	=> $reason_for_no
								));


			return $return;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function save_new_pos_db ($rep_id, $store_id, $category_id, $category_inline, $poc_id, $image){

		static $statement 	= null;

		try{
			$statement 		= self::$mysqli->prepare("INSERT INTO picture_of_success (
														  store_id,
														  rep_id,
														  photo_upload,
														  category_id,
														  category_inline
														) 
														VALUES
														  (
														    :store_id,
														    :rep_id,
														    :photo_upload,
														    :category_id,
														    :category_inline
														  )");
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$return 		= $statement->execute(
								array(
									":store_id" 		=> $store_id,
									":rep_id" 			=> $rep_id,
									":photo_upload" 	=> $image,
									":category_id" 		=> $category_id,
									":category_inline" 	=> $category_inline
								));


			return $return;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_location_checkout_by_id_db ($location_id, $today) {

		static $statement = null;

		try{

			$query    	= "SELECT * FROM locations WHERE location_id = :location_id AND FROM_UNIXTIME(checkOut, '%Y-%m-%d %H:%i') >= :today";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":location_id" => $location_id, ":today" => $today);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_location_by_locid_db ($location_id) {

		static $statement = null;

		try{

			$query    	= "SELECT * FROM locations WHERE location_id = :location_id";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":location_id" => $location_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

		
	}
	
	/**
	 * @param  
	 * @return 
	 */
	static public function get_user_by_password_db ($password) {

		try{
			$statement 	= self::$mysqli->prepare("SELECT * FROM users WHERE password = :password");
			$statement->execute(array(":password" => $password));

			$row 		= $statement->fetch(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_rep_by_repid_db ($rep_id) {

		static $statement = null;

		try{
			$statement 	= self::$mysqli->prepare("SELECT * FROM reps WHERE rep_id = :rep_id AND status = :status");

			$statement->execute(array(":rep_id" => $rep_id, ":status" => 'A'));

			$row 		= $statement->fetch(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

		
	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_store_calls_db ($rep_id) {

		static $statement = null;

		try{
			$statement 	= self::$mysqli->prepare("SELECT * FROM rep_store WHERE rep_id = :rep_id");

			$statement->execute(array(":rep_id" => $rep_id));

			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_store_location_this_week_db ($rep_id, $monday_date, $todays_date) {

		static $statement = null;

		try{
			$query    	= "SELECT * FROM locations WHERE user_id = :user_id AND FROM_UNIXTIME(checkOut, '%Y-%m-%d %H:%i') BETWEEN :monday_date AND :todays_date";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array(":user_id" => $rep_id, ":monday_date" => $monday_date , ":todays_date" => $todays_date );
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_stores_weeday_db ($rep_id, $day_of_week) {

		static $statement = null;

		try{
			$query    	= "SELECT 
							  rs.store_id,
							  st.storeName,
							  st.storeName3,
							  st.store_id,
							  st.storeAddress,
							  st.phoneNumber 
							FROM
							  rep_store AS rs 
							  INNER JOIN stores AS st 
							    ON rs.store_id = st.store_id 
							WHERE rs.rep_id = :rep_id
							  AND rs.callDay = :callDay ";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array(":rep_id" => $rep_id, ":callDay" => $day_of_week);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_reps_promos_db ($rep_id) {

		static $statement = null;

		try{
			$query    	= "SELECT 
								p.*,
								s.`store_id`,
								s.`date`,
								st.`storeName3` AS store_name,
								st.`storeName` AS store_name2,
								s.`no_of_bins` AS bin_placed,
								CONCAT(s.`date`, '-', `no_of_bins`) AS `order` 
							FROM
								`promotion_strikerate` AS s 
							INNER JOIN `stores` AS st 
							  ON st.store_id = s.`store_id` 
							INNER JOIN `store_promotions` AS p 
							  ON p.promo_id = s.`promo_id` 
							INNER JOIN reps AS r 
							  ON r.`rep_id` = s.`user_id` 
							WHERE p.end_date >= NOW() 
							AND p.start_date <= NOW() 
							AND r.`rep_id` = :rep_id
							ORDER BY p.`date_created` DESC;";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array(":rep_id" => $rep_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_store_promos_db ($rep_id, $store_id) {

		static $statement = null;

		try{
			$query    	= "SELECT 
								p.*,
								s.`store_id`,
								s.`date`,
								st.`storeName3` AS store_name,
								st.`storeName` AS store_name2,
								s.`no_of_bins` AS bin_placed,
								CONCAT(s.`date`, '-', `no_of_bins`) AS `order` 
							FROM
								`promotion_strikerate` AS s 
							INNER JOIN `stores` AS st 
							  ON st.store_id = s.`store_id` 
							INNER JOIN `store_promotions` AS p 
							  ON p.promo_id = s.`promo_id` 
							INNER JOIN reps AS r 
							  ON r.`rep_id` = s.`user_id` 
							WHERE p.end_date >= NOW() 
							AND p.start_date <= NOW() 
							AND r.`rep_id` = :rep_id
							AND st.`store_id` = :store_id
							GROUP BY p.`promo_id`
							ORDER BY p.`date_created` DESC;";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array(":rep_id" => $rep_id, ":store_id" => $store_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function get_open_promos_db () {

		static $statement = null;

		try{
			$query    	= "SELECT 
						  	*
							FROM
						  		store_promotions as p
							WHERE p.end_date >= NOW() 
								AND p.start_date <= NOW()
							ORDER BY date_created DESC;";

			$statement 	= self::$mysqli->prepare($query);

			// $assoc 		= array(":rep_id" => $rep_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute();
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}


	/**
	 * @param  
	 * @return 
	 */
	static public function insert_new_user_db ($Username, $Email, $Password) {

		try{
			$statement 	= self::$mysqli->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
			$return 	= $statement->execute(
								array(
									":username" => $Username,
									":email" => $Email,
									":password" => $Password
							));


			return $return;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function insert_new_chekin_db ($rep_id, $store_id, $latitude, $longitude) {

		try{
			$statement 	= self::$mysqli->prepare("INSERT INTO locations (store_id, user_id, lng, lat, checkIn) VALUES (:store_id, :user_id, :lng, :lat, :checkIn)");
			$return 	= $statement->execute(
								array(
									":store_id" => $store_id,
									":user_id" 	=> $rep_id,
									":lng" 		=> $latitude,
									":lat" 		=> $longitude,
									":checkIn" 	=> time()
								));


			return $return;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function check_out_store_db ($location_id) {
		static $statement = null;

		try{

			$query 		= "UPDATE locations SET checkOut = :checkout WHERE `location_id` = :location_id";

			$statement 	= self::$mysqli->prepare($query);

			$assoc 		= array (":checkout" => time(), ":location_id" => $location_id);
			// $exQuery=str_replace(array_keys($assoc), array_values($assoc), $query);
			// echo $exQuery;
			$statement->execute ($assoc);
			
			$row 		= $statement->fetchAll(); 

			return $row;
		}catch(PDOException $e) {
			return $e->getMessage();
		}

	}

	/**
	 * @param  
	 * @return 
	 */
	static public function insert_new_person_db (
								$first_name,
								$last_name,
								$language,
								$dob,
								$mobile,
								$email
							) {

		try{

			$query 		= "
							INSERT INTO people (
							  first_name,
							  surname,
							  mobile,
							  email,
							  language,
							  date_of_birth
							) 
							VALUES
							  (
							  :first_name, 
							  :surname, 
							  :mobile, 
							  :email, 
							  :language, 
							  :date_of_birth
							  );
							";


			$statement 	= self::$mysqli->prepare($query);
			$return 	= $statement->execute(
								array(
									":first_name" 		=> $first_name,
									":surname" 			=> $last_name,
									":mobile" 			=> $mobile,
									":email" 			=> $email,
									":language" 		=> $language,
									":date_of_birth" 	=> $dob
							));


			return $return;
		}catch(PDOException $e) {
    		return $e->getMessage();
		}

	}




	////////////////-------- VIP -----////////////////
	/**
	 * @param  
	 * @return 
	 */
	static public function change_timezone () {

		$query 		= "SET @@session.time_zone = '+02:00';";

		$stmt   	= self::$mysqli->query($query) or die('Failed to prepare: ' . self::$mysqli->error());

		return $stmt;
	}

	/**
	 * Escape string
	 * 
	 * @param  $string
	 * @return string
	 */
	static public function clean_string ($string) {
		return self::$mysqli->quote ($string);
		// return $string;
	}

	/**
	 * Fomat query results to an array
	 * 
	 * @param  $salesCode 
	 * @return boolen
	 */
	static public function fetch_array_mssql ($result) {
		$results = array();
		$count   = 0;
		if (!$result) {
			return 'Error: ' . self::$mysqli->error();
		}else{
			/* fetch value */
			while($row = self::$mssql->fetch_array($result)) {
				// Push results in array
				array_push($results, $row);
				$count++;
			}
			return $results;
		}

	}

	/**
	 * Fetch Assoc
	 * 
	 * @param  $salesCode 
	 * @return boolen
	 */
	static public function fetch_assoc_arr ($result) {
		$results = array();
		$count   = 0;

		if (!$result) {
			printf("Error: %s\n", self::$mysqli->error());
			exit();
		} else {
			/* fetch value */
			while($row = $result->fetch_array (MYSQLI_ASSOC)){
				// Push results in array
				array_push($results, $row);
				$count++;
			}
			return $results;
		}

	}

}