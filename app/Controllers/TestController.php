<?php
class TestController extends BaseController{
    public function index($one = NULL, $two = NULL){
        echo "I am form Controller my params are {$one}, {$two}";
        $data = array("hello", "here", "there");
        $data2 = array("tigher", "lion", "horse");

        // view("website/home-view.php", compact('data') );
        // or
        // view("website/home-view.php", array("name" => $data) );

        view("website/home-view.php", compact('data2') );
    }

    public function not_found(){
        echo "<br/> I think you are lost here </br/>";
    }
}

