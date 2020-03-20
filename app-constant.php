<?php

# Set the Vars
$controllers = "/app/Controllers";
$models = "/app/Models";
$middleware = "/app/Middlewares";
$bootstrap = "/bootstrap";
$config = "/config";
$database = "/database";
$plugins =  "/plugins";
$public = "/public";
$resources = "/resources";
$views = $resources."/views";
$storage = "/storage";
$third_parties = "/vendor/thirdParties";
$core = "/vendor/core";
$route = "/route";

# All Path Constant
define("APP_PATH", __DIR__);
define("CONTROLLER_PATH", APP_PATH.$controllers);
define("MODEL_PATH", APP_PATH.$models);
define("MIDDLEWARE_PATH", APP_PATH.$middleware);
define("BOOTSTRAP_PATH", APP_PATH.$bootstrap);
define("CONFIG_PATH", APP_PATH.$config);
define("DATABASE_PATH", APP_PATH.$database);
define("PLUGINS_PATH", APP_PATH.$plugins);
define("PUBLIC_PATH", APP_PATH.$public);
define("RESOURCES_PATH", APP_PATH.$resources);
define("VIEW_PATH", APP_PATH.$views);
define("STORAGE_PATH", APP_PATH.$storage);
define("THIRD_PARTIES_PATH", APP_PATH.$third_parties);
define("CORE_PATH", APP_PATH.$core);
define("ROUTE_PATH", APP_PATH.$route);


#-----------------------------------------------
#
# The megic for Dynamic Getting the Base Url ...
#
#-----------------------------------------------

# Return the Full Running Url
function current_url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

# if running root then return false
# else return the Subfolder
function app_on(){
    $root = $_SERVER['DOCUMENT_ROOT'];
    $filePath = dirname(__FILE__);
    if ($root == $filePath) {
        return; // installed in the root
    } else {
        $subfolder = str_replace($root."/", "", $filePath);
        return $subfolder;  // installed in a subfolder or subdomain
    }
}

# Parse url is a native php function
# This is a Great Function :D

$urls = parse_url(current_url());
$app_running_on = app_on();
$app_url = NULL;
if($app_running_on){
    $app_url = $urls["scheme"]."://".$urls["host"]."/".$app_running_on;
}else{
    $app_url = $urls["scheme"]."://".$urls["host"];
}

# Additional Support to my App
# if we visit our app using
# base_url/index.php in this case
# $_SERVER['PATH_INFO'] is giving error
# So set it a value

if(!isset($_SERVER['PATH_INFO'])){
    # for initial it is the root
    # We make think it as index.php

    $_SERVER['PATH_INFO'] = "/";
}

function route_url( $return_as_array = false ){

    $route_url = $_SERVER['PATH_INFO'];

    # Because we will handle / or index.php in
    # Route so we need to Check it /
    if( strlen($_SERVER['PATH_INFO']) > 1 ) {
        $route_url = trim($_SERVER['PATH_INFO'], "/");
    }

    if($return_as_array){
        return explode("/", $route_url);
    }
    return $route_url;
}

function route_url_last(){
    return basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}
# End Additional Support .....

#-----------------------------------------------
#
# End The megic for Dynamic Getting the Base Url ...
#
#-----------------------------------------------


# Here we set the Constant for URL..
define("APP_URL", $app_url);
define("CONTROLLER_URL", APP_URL.$controllers);
define("MODEL_URL", APP_URL.$models);
define("MIDDLEWARE_URL", APP_URL.$middleware);
define("BOOTSTRAP_URL", APP_URL.$bootstrap);
define("CONFIG_URL", APP_URL.$config);
define("DATABASE_URL", APP_URL.$database);
define("PLUGINS_URL", APP_URL.$plugins);
define("PUBLIC_URL", APP_URL.$public);
define("RESOURCES_URL", APP_URL.$resources);
define("VIEW_URL", APP_URL.$views);
define("STORAGE_URL", APP_URL.$storage);
define("THIRD_PARTIES_URL", APP_URL.$third_parties);
define("CORE_URL", APP_URL.$core);
define("ROUTE_URL", APP_URL.$route);


