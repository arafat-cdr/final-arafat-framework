<?php
/*
**************************************************
** Autoload Order
** 1) Autoload the Config files
** 2) Autoload the Helpers
** 3) Autoload the ThirdParties files
** 4) Autoload the cores
** 5) Autoload the Plugins
** 6) Autoload the Routes
****************************************************
*/

require(__DIR__."/../app-constant.php");

function p($data){
    echo "<pre style='background: black; color:green; font-size: 25px;'>";
    print_r($data);
    echo "</pre>";
}

function lp($auto_loading_files){
    foreach ($auto_loading_files as $require_file) {
        require($require_file);
        // p($require_file);
    }
}

# dynamic loading the config files
$res = glob(CONFIG_PATH."/*.php");
lp($res);

# Dynamic loading the helpers
$res = glob(CORE_PATH."/helpers/*.php");
lp($res);

# Dynamic loading the third parities autoload.php
$res = glob(THIRD_PARTIES_PATH."/*/autoload.php");
lp($res);

# Dynamic loading core Mail files
$res = glob(CORE_PATH."/mail/*.php");
lp($res);

# Dynamic loading core dbConnectors files
$res = glob(CORE_PATH."/dbConnectors/*.php");
lp($res);

# Dynamic loading core crud files
$res = glob(CORE_PATH."/crud/*.php");
lp($res);

# Dynamic Loading CoreMigrations Files..
$res = glob(CORE_PATH."/databaseMigration/*.php");;
lp($res);

# Dynamic Loading Migrations Files..
$res = glob(DATABASE_PATH."/*.php");
lp($res);

# Dynamic loading core ViewSupport Files files
$res = glob(CORE_PATH."/views/*.php");
lp($res);

# Dynamic loading the Hooks files
$res = glob(CORE_PATH."/hooks/*.php");
lp($res);

# Dynamic loading the Plugins files
$res = glob(PLUGINS_PATH."/*/plugin.php");
lp($res);


# Dynamic Loading the Middleware
$res = glob(MIDDLEWARE_PATH."/*/*.php");
lp($res);

# Dynamic Loading the Controller
$res = glob(MODEL_PATH."/*.php");
lp($res);

# Dynamic Loading the Controller
$res = glob(CONTROLLER_PATH."/*.php");
lp($res);


# Dynamic loading core Route files It Support the Route Features
$res = glob(CORE_PATH."/route/*/*.php");
lp($res);

# Dynamic loading the route files
$res = glob(ROUTE_PATH."/*.php");
lp($res);

# Dynamic loading core Route files For Running the Route
$res = glob(CORE_PATH."/route/*.php");
lp($res);
