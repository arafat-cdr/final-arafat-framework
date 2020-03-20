<?php
class CoreConnection{

    public $db_host = DB_HOST;
    public $db_user = DB_USER;
    public $db_pass = DB_PASS;
    public $db_name = DB_NAME;
    public $connection;

    private static $con_instance = false;

    # prevent Creating Object
    private function __construct(){

    }

    # singleton
    public static function init(){
        # Singleton Design ...
        if(!self::$con_instance){
            self::$con_instance = new self;
        }

        return self::$con_instance;
    }

    public function db_connect()
    {
        // Create connection
        self::$con_instance = new mysqli($this->db_host, $this->db_user, $this->db_pass);
        mysqli_query(self::$con_instance,"SET CHARACTER_SET_CLIENT='utf8'");

        mysqli_query(self::$con_instance,"SET CHARACTER_SET_RESULTS='utf8'");

        mysqli_query(self::$con_instance,"SET CHARACTER_SET_CONNECTION='utf8'");

        // Check connection
        if (self::$con_instance->connect_error)
        {
            die("Connection failed: " . self::$con_instance->connect_error);
        }

        $db_select = mysqli_select_db(self::$con_instance,$this->db_name);

        if($db_select)
        {
            // echo "Connected successfully";
            return self::$con_instance;
        }
        else
        {
            die("Connection failed: " . self::$con_instance->connect_error);
        }
    }

}

