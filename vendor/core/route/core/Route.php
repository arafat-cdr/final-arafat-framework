<?php
class Route{
    public static $route_names = array();
    public static $url_to_match = array();
    public static $not_found = array();
    public static $prefix = NULL;
    public static $middleware_class_obj_arr = array();
    public static $middleware_method_arr = array();

    # Here is the Constructor Class
    private function __construct(){
        # Prevent creatig object
    }

    /**
     * @ Set the middleware and Prefix
     * @ return void
     */

    private static function set_middleware_with_prefix($prefix, array $middleware_class_obj_arr, array $middleware_method_arr)
    {
        self::$prefix = $prefix;
        self::$middleware_class_obj_arr = $middleware_class_obj_arr;
        self::$middleware_method_arr = $middleware_method_arr;
    }

    /**
     * @ unSet the middleware and Prefix
     * @ return void
     */

    private static function unset_middleware_with_prefix(){
        self::$prefix = NULL;
        self::$middleware_class_obj_arr = array();
        self::$middleware_method_arr = array();
    }

    public static function group(array $group, $callback_name){

        # Storing all the class and Method in a Array
        self::$middleware_class_obj_arr = array();
        self::$middleware_method_arr = array();
        self::$prefix = NULL;

        # Checking the Middleware
        if( array_key_exists("middleware", $group) ){

            foreach ( $group["middleware"] as $middleware_class_method) {
                $class_method = explode("@", $middleware_class_method);
                # if it is calleable
                if( is_callable( $class_method[0], $class_method[1] ) ){
                    // all middleware are static methods
                    //$class_method[0]::$class_method[1]();
                    array_push(self::$middleware_class_obj_arr, $class_method[0]);
                    array_push(self::$middleware_method_arr, $class_method[1]);

                }else{
                    throw new Exception('Middleware Static Method Is not Callable');
                }

            }
        }

        # Checking the Prefix Here ...
        if( array_key_exists("prefix", $group) ){
            self::$prefix = $group["prefix"];
        }
        self::set_middleware_with_prefix(self::$prefix, self::$middleware_class_obj_arr, self::$middleware_method_arr);
        call_user_func( $callback_name );
        self::unset_middleware_with_prefix();
    }

    public static function get( $url, $action, $name )
    {
        if($_SERVER["REQUEST_METHOD"] !== "GET"){
            self::route_error("GET");
        }
        # Handle the Get Request ....
        self::handle_http_request( $url, $action, $name );
    }

    public static function post( $url, $action, $name )
    {
        if($_SERVER["REQUEST_METHOD"] !== "POST"){
            self::route_error("POST");
        }
        # Handle the Get Request ....
        self::handle_http_request( $url, $action, $name );
    }

    public static function any( $url, $action, $name )
    {
        if( !in_array( $_SERVER["REQUEST_METHOD"], array("GET", "POST") ) ){
            self::route_error("GET OR POST");
        }
        # Handle the Get Request ....
        self::handle_http_request( $url, $action, $name );
    }

    public static function route_error($error){
        throw new Exception("Your Request is Not valid ! Expecting a {$error} Method");
    }

    public static function get_url_metadata($params){
        # seperatting the callable url with its parameters
        $param_arr = explode("/{", $params);
        $url_to_match = trim(array_shift($param_arr), "/");
        $number_of_parameter = 0;
        if($param_arr){
            $number_of_parameter = @count($param_arr);
        }
        return array(
            "url_to_match" => $url_to_match,
            "number_of_parameter" => $number_of_parameter,
        );
    }

    private static function handle_action($action){
        $class_method = explode("@", $action);
        # if it is calleable
        $class_object = new $class_method[0];
        if( is_callable( array( $class_object,  $class_method[1]) ) ){

            $dynamic = array(
                "class_obj_is" => $class_object,
                "method"       => $class_method[1],
            );

            return $dynamic;
        }else{
            throw new Exception('Action Error ! Class or Method Is not Exist ');
        }
    }

    private static function handle_http_request($url, $action, $name)
    {

        if ( array_key_exists($name, self::$route_names) ){
            throw new Exception("Route Name Already Exist . Please change the Name <b style='color: red;'>{$name}</b> To a different One");
        } else {
            $url_meta_data = self::get_url_metadata($url);
            $url_to_match = NULL;
            # checking if prefix exist or not
            if( self::$prefix ){
                $prefix = trim(self::$prefix, "/");
                $url_to_match = APP_URL."/".$prefix."/".$url_meta_data['url_to_match'];

                # inside Route::group for Base Path -> / in the end
                # There may exist a / Remove it
                $url_to_match = trim($url_to_match, "/");

            }else{
                $url_to_match = APP_URL."/".$url_meta_data['url_to_match'];
            }

            # Set The Array For Getting All the info Using Route Name
            self::$route_names[$name] = array(
                'name' => $name,
                'url' => $url_to_match,
                'number_of_parameter' => $url_meta_data['number_of_parameter'],
                'parameter' => trim(str_replace($url_meta_data['url_to_match']."/", "", $url), "/"),
                'action' => self::handle_action($action),
                'middleware' => array(
                    "class_obj_is" => self::$middleware_class_obj_arr,
                    "method"       => self::$middleware_method_arr,
                ),
            );

            # Set The Another For Getting the Info using Matching Url
            self::$url_to_match[$url_to_match] = self::$route_names[$name];
        }
    }


    public static function page($url, $func, $name)
    {

        if ( array_key_exists($name, self::$route_names) ){
            throw new Exception("Route Name Already Exist . Please change the Name <b style='color: red;'>{$name}</b> To a different One");
        } else {
            $url_meta_data = self::get_url_metadata($url);
            $url_to_match = NULL;
            # checking if prefix exist or not
            if( self::$prefix ){
                $prefix = trim(self::$prefix, "/");
                $url_to_match = APP_URL."/".$prefix."/".$url_meta_data['url_to_match'];

                # inside Route::group for Base Path -> / in the end
                # There may exist a / Remove it
                $url_to_match = trim($url_to_match, "/");

            }else{
                $url_to_match = APP_URL."/".$url_meta_data['url_to_match'];
            }

            # Set The Array For Getting All the info Using Route Name
            self::$route_names[$name] = array(
                'name' => $name,
                'url' => $url_to_match,
                'number_of_parameter' => $url_meta_data['number_of_parameter'],
                'parameter' => trim(str_replace($url_meta_data['url_to_match']."/", "", $url), "/"),
                'action' => "page",
                'func' => $func,
                'middleware' => array(
                    "class_obj_is" => self::$middleware_class_obj_arr,
                    "method"       => self::$middleware_method_arr,
                ),
            );

            # Set The Another For Getting the Info using Matching Url
            self::$url_to_match[$url_to_match] = self::$route_names[$name];
        }

    }


    public static function notFound($func){
        // call the first element of not_found
        self::$not_found = array(
            'not_found' => $func,
        );
    }

    # Get The Route Using Route Name
    public static function route( $name ){
        # pr(self::$route_names);
        if(isset(self::$route_names[$name])){
            return self::$route_names[$name]["url"];
        }else{
            echo "<p style='color:red;'>Route Name:->{ {$name} } Not Found</p>";
            error_trace();
        }
    }

} # End of Route Class

# Wrtite a Route Helper Function
function route($name){
    return Route::route($name);
}