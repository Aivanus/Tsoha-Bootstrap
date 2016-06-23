<?php
 
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('index.html');
    }
    
    // Testaussivu
    public static function sandbox(){

    }
  }
