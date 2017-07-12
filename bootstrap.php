<?php
/**
* Bootstrap
*/

/* error reporting */

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header('X-Frame-Options: ALLOW-FROM SAMEORIGIN');

define('SERVER_ROOT', dirname(__FILE__));
define('USER_AGENT', $_SERVER['HTTP_USER_AGENT']);

date_default_timezone_set("Africa/Johannesburg");

// Include directories
function autoload_class($class_name) {
	
	$directories = array(
		'app/',
		'app/controllers/',
		'app/models/',
		'app/models/libraries/',
		'app/controllers/libraries/'

		);

	foreach ($directories as $directory) {
		$filename = $directory . $class_name . '.php';


		if (is_file($filename)) {
			require($filename);
			break;
		}
	}
}

spl_autoload_register('autoload_class');


/**
 * Parse the incoming request.
 */
$request = new Request();
if (isset($_SERVER['PATH_INFO'])) {
	$request->url_elements = explode('/', trim($_SERVER['PATH_INFO'], '/'));
}

$request->method = strtoupper($_SERVER['REQUEST_METHOD']);

switch ($request->method) {
	case 'GET':
	$request->parameters = $_GET;
	break;
	case 'POST':
	$request->parameters = $_POST;
	break;
	case 'PUT':
	parse_str(file_get_contents('php://input'), $request->parameters);
	break;
}

/**
 * Route the request.
 */


if (!empty($request->url_elements)) {
	$controller_name = ucfirst($request->url_elements[0]) . 'Controller';
	

	if (class_exists($controller_name)) {
		$controller     = new $controller_name;
		$action_name    = strtolower($request->method);
		$response_str   = call_user_func_array(array($controller, $action_name), array($request));
	}
	else {
		
		header('HTTP/1.1 404 Not Found');

		

		$response_str   = json_encode (array('success' => false, 'text'=> 'Unknown request: ' . $request->url_elements[0]));


	}
}
else {
	$response_str = json_encode (array('success' => false, 'text'=> 'Unknown request'));
}

/**
 * Send the response to the client.
 */
$response_obj = Response::create($response_str, $_SERVER['HTTP_ACCEPT']);
echo $response_obj->render();