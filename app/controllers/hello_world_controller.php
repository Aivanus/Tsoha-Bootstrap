<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function register(){
      View::make('suunnitelmat/register.html');
    }

    public static function reading_list(){
      View::make('suunnitelmat/reading_list.html');
    }

    public static function add_book(){
      View::make('suunnitelmat/add_book.html');
    }
  }
