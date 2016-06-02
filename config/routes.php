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

  $routes->get('/reading_list', function() {
    BookController::index();
  });

  $routes->get('/add_book', function() {
    HelloWorldController::add_book();
  });