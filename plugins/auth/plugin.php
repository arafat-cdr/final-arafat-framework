<?php
# This is the plugin autoload File
function auth_info(){
    return array(
        "name" => "auth plugin",
        "version" => "1.0",
        "description" => "provide Auth Support",
        "author" => "arafat",
        "is_active_plugin" => false,
    );
}
add_action("all_plugins", "auth_info");
# Do all the task in seperate files and at the end autoload it
global $coreCrud;
// pr($coreCrud);

class Auth{

    public static function auth_from_start($action_url = false){
        //$action = PLUGINS_URL."/auth/plugin.php";
        $action = current_url();
        if($action_url){
            $action = $action_url;
        }
        echo "<form action='".$action."' method='POST'>";
    }

    public static function auth_form_end(){
        echo "</form>";

        # Handle the Form Data
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                global $coreCrud;
                pr($_POST);
            }
        # Handle the data end
    }

    public static function auth_form_email($extra_data = ''){
        echo "<input type='text' name='email'".$extra_data." >";
    }
    public static function auth_form_password($extra_data = ''){
        echo "<input type='password' name='password'".$extra_data." >";
    }
    public static function auth_form_submit($extra_data = ''){
        echo "<input type='submit' name='auth_submit'".$extra_data." >";
    }
}