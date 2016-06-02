<?php
 
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('suunnitelmat/homepage.html');
    }
   
    public static function sandbox(){
      $bird = Book::find(1);
      $books = Book::all();
      Kint::dump($books);
      Kint::dump($bird);
      $oneMyBook = MyBook::find(1);
      $allMyBooks = MyBook::all();
      Kint::dump($oneMyBook);
      Kint::dump($allMyBooks);
      $oneReader = Reader::find(1);
      $allReaders = Reader::all();
      Kint::dump($oneReader);
      Kint::dump($allReaders);
      $oneReview = Review::find(1);
      $allReviews = Review::all();
      Kint::dump($oneReview);
      Kint::dump($allReviews);

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
