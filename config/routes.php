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
    BookController::add_book();
  });