<?php
/**
***********************************************
|| This File is Use to Run The Url
|| It is Check the Route And
|| Called The Associate Array
|| If the Route Accept Parameter
|| Then It pass the Required Parameter
***********************************************
*/
$middleware_class_obj = array();

$route_urls = route_url(true);
// pr($route_urls);
$url_to_append = APP_URL;
$is_url_exist_in_route = false;
$callable_routes = array();

foreach($route_urls as $key => $current_url_is) {

     $url_to_append .= "/".$current_url_is;
     // echo "<br/>$url_to_append</br>";
     # unset the array Because We will use
     # The rest of the Value as Parameter
     unset($route_urls[$key]);


     #echo $url_to_append;
     if( array_key_exists( $url_to_append , Route::$url_to_match ) ){

        $is_url_exist_in_route = true;
        $parameters = implode($route_urls, ",");

        # calling the class using method...
        # Now we need to Check if it has a Attach a Middleware
        global $middleware_class_obj;
        $middleware_class_obj = Route::$url_to_match[$url_to_append]['middleware']['class_obj_is'];
        $middleware_class_obj = Route::$url_to_match[$url_to_append]['middleware'];
        // pr($middleware_class_obj);

        # Check if it is Page Route OR Simple MVC Route
        if(Route::$url_to_match[$url_to_append]['action'] == "page"){
            if( is_callable(Route::$url_to_match[$url_to_append]['func']) ){
                array_push($callable_routes, array("is_class_obj" => 0, "func" => Route::$url_to_match[$url_to_append]['func']));

                # end the loop because what we need we have That
                # let's Go Home For a Party :D
            }else{
                print("<p style='color:red;'>Error Page Route Not Callable...</p>");
                error_trace();
            }
        }else{
            $obj_name = Route::$url_to_match[$url_to_append]['action']['class_obj_is'];
            $method_name =  Route::$url_to_match[$url_to_append]['action']['method'];

            # Chek is Callable ...
            if( is_callable( array( $obj_name, $method_name ) ) ){

                array_push($callable_routes, array("is_class_obj" => 1, "obj" => $obj_name, "method" => $method_name, "parameter" => $parameters));

                # end the loop because what we need we have That
                # let's Go Home For a Party :D

            }
        }
     }
}

function if_middleware_exist_call_it(){
    global $middleware_class_obj;
    # if Middleware is Set We will call it before the
    # Controller Method Call
    if( $middleware_class_obj ){
        #pr($middleware_class_obj);
        foreach ($middleware_class_obj["class_obj_is"] as $m_key => $m_val){

           $obj = $m_val;
           $method = $middleware_class_obj["method"][$m_key];

           # Call the Middleware Static Method Here
           $obj::$method();
        }
    }
}

/**********************************************
**********************************************
** Here We will call the Current Route ....
** We are calling the last Callable Route...
** Why ?? If we call 1st/then 2nd / then 3rd
** There is a issue of Concurrent call
** multiple route So in-order to Fix that
** We will call the last Route 1st / then
** 2nd last and so On
** This is the Right Way ....
** Peace
** By arafat
** Arafat.dml@gmail.com
**********************************************
**********************************************
**
*/

// pr($callable_routes);

# Calling The End ....

if( $callable_routes ) {
    $end = end($callable_routes);

    if($end["is_class_obj"]){
        $obj = $end["obj"];
        $method = $end["method"];
        $parameter = $end["parameter"];
        # call it ....
        # Before All we Need To Call the Middleware
        if_middleware_exist_call_it();

        $obj->$method($parameter);
    }else{
        # Before All we Need To Call the Middleware
        if_middleware_exist_call_it();
        call_user_func( $end["func"] );
    }
}


# end of calling end ---------


# Working for the Not Found URL..
if($is_url_exist_in_route == false){
   $fun =  Route::$not_found['not_found'];
   call_user_func($fun);
}