<?php
class loaderHook{
    private static $instance = false;
    public $metas = array();
    public $styles = array();
    public $header_scripts = array();
    public $inject_after_body_tag = array();
    public $footer_scripts = array();
    public $css_stack = NULL;
    public $js_stack = NULL;


    # Prevent creating object
    # We are using singleton Principle
    # This is our construtor function
    private function __construct(){
        # code belong to Constructor Goes Here
    }

    # Singleton Pattern
    public static function init(){
        if( !self::$instance ){
            self::$instance = new self;
        }

        return self::$instance;
    }
    private function process_priority_base_data( &$array_var, $priority, $array_data ){

        if( array_key_exists($priority, $array_var) ){

            # we need again chek if 0 is set
            if(isset($array_var[$priority][0])){
                # already it is our formate just push the array
                array_push($array_var[$priority], $array_data);
            }else{
                # it is not our formate ..
                # it is need to formate only for the 2nd entry

                $old_value = $array_var[$priority];
                $array_var[$priority] = array();
                array_push($array_var[$priority], $old_value);
                array_push($array_var[$priority], $array_data);
            }
        }else{
            $array_var[$priority] = $array_data;
        }
    }

    # This will help to print all the information we Need
    private function print_loader( &$loader_var, $print_name ){
         if( $loader_var ){
             foreach( $loader_var as $key => $val ){
                 if( isset($val[0]) ){
                     foreach ($val as $kk => $vv) {
                         echo $vv[$print_name]."\n";
                     }
                 } else{
                     echo $val[$print_name]."\n";
                 }
             }
         }
    }


    # We will store all the metas as array key
    public function set_metas($name, $priority = 10){
        $array_data = [
            'name' => $name,
            'priority' => $priority,
        ];
        # process the data
        $this->process_priority_base_data($this->metas, $priority, $array_data);
   }

    public function get_metas(){
        $this->print_loader($this->metas, 'name');
    }

    public function set_style($name, $src, $priority = 10){
        $array_data = [
            'name' => $name,
            'src' => $src,
            'priority' => $priority,
        ];
        # process the data
        $this->process_priority_base_data($this->styles, $priority, $array_data);
    }

    public function get_styles(){
        $this->print_loader($this->styles, 'src');
    }

    public function set_header_script($name, $src, $priority = 10){
        $array_data = [
            'name' => $name,
            'src' => $src,
            'priority' => $priority,
        ];
        # process the data
        $this->process_priority_base_data($this->header_scripts, $priority, $array_data);
    }

    public function get_header_scripts(){
        $this->print_loader($this->header_scripts, 'src');
    }

    public function set_inject_after_body_tag($name, $src, $priority = 10){
        $array_data = [
            'name' => $name,
            'src' => $src,
            'priority' => $priority,
        ];
        # process the data
        $this->process_priority_base_data($this->inject_after_body_tag, $priority, $array_data);
    }

    public function get_inject_after_body_tag(){
        $this->print_loader($this->inject_after_body_tag, 'src');
    }

    public function set_footer_script($name, $src, $priority = 10){
        $array_data = [
            'name' => $name,
            'src' => $src,
            'priority' => $priority,
        ];
        # process the data
        $this->process_priority_base_data($this->footer_scripts, $priority, $array_data);
    }

    public function get_footer_scripts(){
        $this->print_loader($this->footer_scripts, 'src');
    }

    public function set_css_stack($data_to_print){
        $this->css_stack = $data_to_print;
    }

    public function get_css_stack(){
        echo $this->css_stack;
    }
    public function set_js_stack($data_to_print){
        $this->js_stack = $data_to_print;
    }

    public function get_js_stack(){
        echo $this->js_stack;
    }

} # end of The Class

# here we apply the Adapter Pattern
# Return the loader
function loader(){
    return loaderHook::init();
}

/*=============================================
=           How To Use it Example             =
=============================================*/

/*loader()->set_footer_script('main-css', "http://localhost/arafat-php-framework/style.css");
loader()->set_footer_script('seconnd-css',"http://localhost/arafat-php-framework/rtl.css");
loader()->set_footer_script('jquery', "http://localhost/arafat-php-framework/abc.css", 11);
loader()->set_footer_script("theme-css", "http://localhost/arafat-php-framework/theme.css");
loader()->set_footer_script("admin", "http://localhost/arafat-php-framework/admin.css",12);
loader()->set_footer_script("front", "http://localhost/arafat-php-framework/abc.css/front.css",12);
loader()->set_footer_script("online", "http://localhost/arafat-php-framework/online.css",12);
loader()->set_footer_script("off","http://localhost/arafat-php-framework/off.css");
loader()->set_footer_script("get", "http://localhost/arafat-php-framework/get.css");
loader()->set_footer_script("post" ,"http://localhost/arafat-php-framework/post.css");
loader()->set_footer_script("put", "http://localhost/arafat-php-framework/put.css");
loader()->set_footer_script("patch",  "http://localhost/arafat-php-framework/patch.css");
loader()->set_footer_script("about", "http://localhost/arafat-php-framework/about.css");
loader()->set_footer_script("final", "http://localhost/arafat-php-framework/final.css");

pr(loader()->footer_scripts);

loader()->get_footer_scripts();*/

/*=====  End of Section comment block  ======*/