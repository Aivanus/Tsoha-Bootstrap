<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  //$routes->get('/register', function() {
  	//HelloWorldController::register();
  //});

  $routes->get('/mybook', function() {
    BookController::readingList();
  });

  $routes->post('/mybook', function(){
    BookController::store();
  });

  $routes->post('/mybook/destroy/:id', function($id){
    BookController::remove_from_list($id);
  });

  $routes->get('/mybook/add_book', function() {
    BookController::addBook();
  });

  $routes->get('/book/:id', function($id) {
    BookController::showBook($id);
  });

  $routes->get('/myreviews', function() {
    ReviewController::myReviews();
  });

  $routes->post('/review', function(){
    ReviewController::store();
  });

  $routes->post('/review/edit/:id', function($id){
    ReviewController::update($id);
  });

  $routes->get('/review/edit/:id', function($id){
    ReviewController::editReview($id);
  });

  $routes->get('/review/list/:id', function($id) {
    ReviewController::reviewList($id);
  });    

  $routes->get('/review/new/:id', function($id) {
    ReviewController::newReview($id);
  }); 

  $routes->get('/login', function(){
    UserController::login();
  });

  $routes->post('/login', function(){
    UserController::handle_login();
  });  

   