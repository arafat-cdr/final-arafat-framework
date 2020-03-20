<?php

Route::group(['middleware' => ['AuthMiddleware@index'],'prefix' => 'backend'], function() {
    Route::get("/", "TestController@index", "home");
    Route::get("/test", "TestController@index", "home2");
    Route::get("/test/abc/{id}/{name}", "TestController@index", "testRouteName");
});

Route::group(['middleware' => ['AuthMiddleware@index', 'AuthMiddleware@check'], 'prefix' => 'prefix-seo'], function() {

    Route::page("/", function(){
        echo "You are in prefix";
        pr(route("aaa"));
       /* pr(core_crud());
        pr(core_crud()->dbSelect("policy"));*/
        // pr($coreCrud);

        header("location:".route("journal"));
        exit();
    }, 'prefix');

    Route::get("/aaa/bbb/ccc", "TestController@index", "journal");

    Route::page("/aaa",function(){
        $data2 = array();
        view("website/home-view.php", compact('data2'));
    }, "aaa3");

    Route::page("/aaa/bbb",function(){
        view("admin/admin.php");
        // echo "I am A pGE rOUTE";
    }, "aaa");




});

Route::get("/", "TestController@index", "homesss");
Route::get("/page/abc/{id}/{action}", "TestController@index", "testRouteName2");
Route::get("/post/abc/{id}/{name}", "TestController@index", "testRouteName3");
Route::get("/api/abc/{id}/{slug}", "TestController@index", "testRouteName4");
Route::get("/call/my-page/", "TestController@index", "testRouteName5");

Route::get("/admin", "AdminController@index", "admin");



# For Not Found Url
Route::notFound(function(){
    /*$obj = new TestController();
    $obj->not_found();*/

    echo "not found msg here";
});