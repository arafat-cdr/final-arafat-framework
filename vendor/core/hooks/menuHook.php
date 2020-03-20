<?php

class menuHook{
    private static $instance = false;

    # for Menus
    private $admin_primary_menu = array();
    private $admin_secondary_menu = array();
    private $front_primary_menu = array();
    private $front_secondary_menu = array();
    private $front_footer_menu = array();

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

    private function handle_menu_data( &$menu_data, $data ){
        if( !isset( $menu_data ) ){
            $menu_data = array();
            array_push( $menu_data,  $data );
        }else{
            array_push( $menu_data,  $data );
        }
    }

    private function get_menu_slug( $slug ){
        $slug = trim($slug);
        $slug = str_replace(" ", "_", $slug);
        $slug = strtolower($slug);

        return $slug;
    }

    private function sort_the_menu( &$menu ){
        foreach($menu as $k => $v){
            if($k == 0){
                ksort( $menu[$k] );
            }else{
                foreach($v as $kk => $vv){
                    ksort( $menu[$k][$kk] );
                }
            }
        }
    }

    # deep 0 | 1 | 2 | 3
    private function process_menu( &$menu, $deep = 0, $name, $url = false, $position = 20, $slug = false, $parent = "parent_slug" )
    {
        if($slug === false){
            $slug = $this->get_menu_slug($name);
        }else{
            $slug = $this->get_menu_slug($slug);
        }
        $menu_data = array(
            "name" => $name,
            "slug" => $slug,
            "url" => $url,
            "position" => $position,
        );

        if( $deep == 0 ){
            # main menu
            $this->handle_menu_data($menu[0][$position], $menu_data);
        }else if( $deep == 1 ){
            # child menu position is 1
            $this->handle_menu_data($menu[1][$parent][$position], $menu_data);
        }else if( $deep == 2 ){
            # child menu position is 2
            $this->handle_menu_data($menu[2][$parent][$position], $menu_data);
        }else if( $deep == 3 ){
            # child menu position 3
            $this->handle_menu_data($menu[3][$parent][$position], $menu_data);
        }
    }


    private function get_parent_menu(&$parent_menu)
    {

        # First We need to Short the menu
        # Then We Wil Get it ............
        $this->sort_the_menu($parent_menu);
        // pr($parent_menu);

        # Here we start Processing Our Data..
        foreach ($parent_menu as $k => $v) {
            # For Parent Menu
            echo "<ul>";
            if($k == 0){
                foreach ($v as $kk => $vv) {
                    foreach ($vv as $kkk => $vvv) {
                        $name = $vvv["name"];
                        $slug = $vvv["slug"];
                        $url = $vvv["url"];
                        $position = $vvv["position"];

                        # Printing the Menu
                        echo "<li>";
                        echo "$name";
                        # Here We Need To call the Child Menu...
                        $first_child_menu = $this->get_child_menu($parent_menu[1][$slug]);
                        // pr($first_child_menu);

                        # Gettinng the first_child menu
                        if($first_child_menu){
                            echo "<ul>";
                            foreach ($first_child_menu as $fck => $fcv) {
                                $fc_name = $fcv["name"];
                                $fc_slug = $fcv["slug"];
                                $fc_url = $fcv["url"];
                                $fc_position = $fcv["position"];
                                $second_child_menu = $this->get_child_menu($parent_menu[2][$fc_slug]);

                                # Printing the 1st Child menu ...
                                echo "<li>";
                                echo "$fc_name";
                                # Getting the Second Child ...
                                if( $second_child_menu ){
                                    echo "<ul>";
                                    foreach ($second_child_menu as $sck => $scv) {
                                        $sc_name = $scv["name"];
                                        $sc_slug = $scv["slug"];
                                        $sc_url = $scv["url"];
                                        $sc_position = $scv["position"];

                                        # Printing the Second Child Menu ....
                                        echo "<li>";
                                        echo "$sc_name";

                                        $third_child_menu = $this->get_child_menu($parent_menu[3][$sc_slug]);

                                        # Getting Third Child Menu
                                        if( $third_child_menu ){
                                            echo "<ul>";
                                            foreach( $third_child_menu as $tsk => $tcv){
                                                $tc_name = $tcv["name"];
                                                $tc_slug = $tcv["slug"];
                                                $tc_url = $tcv["url"];
                                                $tc_position = $tcv["position"];

                                                # Printg the thied Child Menu
                                                echo "<li>";
                                                echo "$tc_name";
                                                echo "</li>";
                                            }
                                        echo "</ul>";
                                        }
                                    echo "</li>";
                                    }
                                echo "</ul>";
                                }
                            echo "</li>";
                            }
                        echo "</ul>";
                        }
                    echo "</li>";
                    }
                }
            }
            echo "</ul>";
        }
    }

    private function get_child_menu(&$child_menu){
        # finding it's child
        $child_menu_array = array();
        if(isset($child_menu)){
            foreach ($child_menu as $child_k => $child_v) {
                foreach($child_v as $child_kk => $child_vv){
                    # Writing a New Child Menu...
                    array_push($child_menu_array, $child_vv);
                }
            }
        }
        return $child_menu_array;
    }

    public function set_admin_primary_menu( $deep = 0, $name, $url = false, $position = 20, $slug = false, $parent = "parent_slug" )
    {
        $this->process_menu( $this->admin_primary_menu, $deep, $name, $url, $position, $slug, $parent );
    }

    public function get_admin_primary_menu()
    {
        $this->get_parent_menu( $this->admin_primary_menu );
    }

    public function set_admin_secondary_menu( $deep = 0, $name, $url = false, $position = 20, $slug = false, $parent = "parent_slug")
    {
        $this->process_menu( $this->admin_secondary_menu, $deep, $name, $url, $position, $slug, $parent );
    }

    public function get_admin_secondary_menu()
    {
        $this->get_parent_menu( $this->admin_secondary_menu );
    }

    public function set_front_primary_menu($deep = 0, $name, $url = false, $position = 20, $slug = false, $parent = "parent_slug")
    {
        $this->process_menu( $this->front_primary_menu, $deep, $name, $url, $position, $slug, $parent );
    }

    public function get_front_primary_menu()
    {
        $this->get_parent_menu( $this->front_primary_menu );
    }

    public function set_front_secondary_menu( $deep = 0, $name, $url = false, $position = 20, $slug = false, $parent = "parent_slug" )
    {
        $this->process_menu( $this->front_secondary_menu, $deep, $name, $url, $position, $slug, $parent );
    }

    public function get_front_secondary_menu()
    {
        $this->get_parent_menu( $this->front_secondary_menu );
    }

    public function set_front_footer_menu( $deep = 0, $name, $url = false, $position = 20, $slug = false, $parent = "parent_slug" )
    {
        $this->process_menu( $this->front_footer_menu, $deep, $name, $url, $position, $slug, $parent );
    }

    public function get_front_footer_menu()
    {
        $this->get_parent_menu( $this->front_footer_menu );
    }

}

# here we apply the Adapter Pattern
# Return the loader
function menu_loader(){
    return menuHook::init();
}

#--------------------------------------------------------------------------------
#          ---------------------- How To use Example ------------------------
#---------------------------------------------------------------------------------

/*menu_loader()->set_admin_primary_menu( 0,"Home", "home.php", 2, "home");
menu_loader()->set_admin_primary_menu( 0, "About", "about.php", 2, 0, "about");
menu_loader()->set_admin_primary_menu( 0, "order", "order.php", 22, "order");
menu_loader()->set_admin_primary_menu( 0, "menu1", "menu1.php", 15, "menu");
menu_loader()->set_admin_primary_menu( 0, "menu1", "menu1.php", 15, "menu1");
menu_loader()->set_admin_primary_menu( 0, "menu1", "menu1.php", 15, "menu1");
menu_loader()->set_admin_primary_menu( 0, "menu1", "menu1.php", 15, "menu1");
menu_loader()->set_admin_primary_menu( 0, "menu1", "menu1.php", 15, "menu1");
menu_loader()->set_admin_primary_menu( 0, "first", "first.php", 10, "first1");

menu_loader()->set_admin_primary_menu( 1, "order2", "order2.php", 15, false, "home");
menu_loader()->set_admin_primary_menu( 1, "contact", "contact.php", 20, false, "home");
menu_loader()->set_admin_primary_menu( 1, "service", "service.php", 20, "service", "home");
menu_loader()->set_admin_primary_menu( 1, "menu1", "menu1.php", 15, false, "home");
menu_loader()->set_admin_primary_menu( 1, "menu1", "menu1.php", 15, false, "home");
menu_loader()->set_admin_primary_menu( 1, "menu1", "menu1.php", 15, false, "home");
menu_loader()->set_admin_primary_menu( 1, "menu1", "menu1.php", 15, false, "home");
menu_loader()->set_admin_primary_menu( 1, "menu1", "menu1.php", 15, false, "home");


menu_loader()->set_admin_primary_menu( 2, "testt", "testt.php", 20, false, "service");
menu_loader()->set_admin_primary_menu( 2, "contact", "contact.php", 20, false, "service");
menu_loader()->set_admin_primary_menu( 2, "service", "service.php", 20, "service", "service");

menu_loader()->set_admin_primary_menu( 3, "service", "service.php", 20, false, "service");
menu_loader()->set_admin_primary_menu( 3, "service", "service.php", 20, false, "service");
menu_loader()->set_admin_primary_menu( 3, "service", "service.php", 20, "service", "service");


# Get the  Menu ..

menu_loader()->get_admin_primary_menu();
pr(menu_loader());*/