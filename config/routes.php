<?php

  function check_logged_in(){
    BaseController::check_logged_in();
  }

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });




  $routes->get('/login', function(){
    UserController::login();
  });

  $routes->post('/login', function(){
    UserController::handle_login();
  });

  $routes->post('/logout', function(){
    UserController::logout();
  });

  $routes->get('/register', function(){
    UserController::register();
  });

  $routes->post('/register', function(){
    UserController::createUser();
  });

  $routes->get('/user_list', function(){
    UserController::userList();
  });

  $routes->get('/user_page', 'check_logged_in', function(){
    UserController::userPage();
  });

  $routes->get('/account', 'check_logged_in', function(){
    UserController::account();
  });

  $routes->post('/account', 'check_logged_in', function(){
    UserController::changePassword();
  });

  //$routes->get('/register', function() {
  	//HelloWorldController::register();
  //});




  $routes->get('/books', function() {
    BookController::listBooks();
  });

  $routes->get('/mybook', 'check_logged_in', function() {
    BookController::readingList();
  });

  $routes->post('/mybook', function(){
    BookController::store();
  });

  $routes->post('/mybook/destroy/:id', function($id){
    BookController::remove_from_list($id);
  });

  $routes->post('/mybook/status/:id', function($id){
    BookController::changeStatus($id);
  });

  $routes->get('/mybook/add_book', function() {
    BookController::addBook();
  });

  $routes->get('/book/:id', function($id) {
    BookController::showBook($id);
  });




  $routes->get('/myreviews', 'check_logged_in', function() {
    ReviewController::myReviews();
  });

  $routes->post('/review', function(){
    ReviewController::store();
  });

  $routes->post('/review/edit/:id', function(){
    ReviewController::update();
  });

  $routes->post('/review/:id/destroy', function($id){
    ReviewController::deleteReview($id);
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

  $routes->get('/review/read/:id', function($id) {
    ReviewController::showReview($id);
  });

   