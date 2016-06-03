<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
  	HelloWorldController::login();
  });

  $routes->get('/register', function() {
  	HelloWorldController::register();
  });

  $routes->get('/mybook', function() {
    BookController::readingList();
  });

  $routes->post('/mybook', function(){
    BookController::store();
  });

  $routes->get('/mybook/add_book', function() {
    BookController::addBook();
  });

  $routes->get('/book/:id', function($id) {
    BookController::showBook($id);
  });

  $routes->post('/review', function(){
    ReviewController::store();
  });

  $routes->get('/review/list/:id', function($id) {
    ReviewController::reviewList($id);
  });    

  $routes->get('/review/new/:id', function($id) {
    ReviewController::newReview($id);
  });    