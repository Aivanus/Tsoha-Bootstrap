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

  $routes->post('/user/destroy', 'check_logged_in', function(){
    UserController::deleteAccount();
  });

  //$routes->get('/register', function() {
  	//HelloWorldController::register();
  //});




  $routes->get('/books', function() {
    BookController::listBooks();
  });

  $routes->get('/book/:id', function($id) {
    BookController::showBook($id);
  });

  $routes->get('/mybook', 'check_logged_in', function() {
    BookController::readingList();
  });

  $routes->post('/mybook', 'check_logged_in',function(){
    BookController::store();
  });

  $routes->post('/mybook/destroy/:id', 'check_logged_in',function($id){
    BookController::remove_from_list($id);
  });

  $routes->post('/mybook/status/:id', 'check_logged_in',function($id){
    BookController::changeStatus($id);
  });

  $routes->get('/mybook/add_book', 'check_logged_in',function() {
    BookController::addBook();
  });






  $routes->get('/myreviews', 'check_logged_in', function() {
    ReviewController::myReviews();
  });

  $routes->post('/review', 'check_logged_in',function(){
    ReviewController::store();
  });

  $routes->post('/review/edit/:id', 'check_logged_in',function(){
    ReviewController::update();
  });

  $routes->post('/review/:id/destroy', 'check_logged_in',function($id){
    ReviewController::deleteReview($id);
  });

  $routes->get('/review/edit/:id', 'check_logged_in',function($id){
    ReviewController::editReview($id);
  });

  $routes->get('/review/list/:id', function($id) {
    ReviewController::reviewList($id);
  });    

  $routes->get('/review/new/:id', 'check_logged_in',function($id) {
    ReviewController::newReview($id);
  }); 

  $routes->get('/review/read/:id', function($id) {
    ReviewController::showReview($id);
  });

   