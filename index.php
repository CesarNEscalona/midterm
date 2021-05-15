<?php

// This is my controller for the Midterm project

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload file
require_once ('vendor/autoload.php');
require_once('model/data-layer.php');

// Start a session
session_start();

// Instantiate Fat-Fre
$f3 = Base::instance();

// Define default route
$f3->route('GET /', function(){

    // Display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /survey', function($f3){
    // Reinitialize the session array
    $_SESSION = array();

    // initialize variables to store user input
    $userOptions = array();
    $userName = "";

    //If the form has been submitted, grab the data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userName = $_POST['name'];
    }

    //Get the options from the Model and send them to the View
    $f3->set('options', getOptions());

    // Add the data to the hive
    $f3->set('userOptions', $userOptions);
    $f3->set('userName', $userName);

    // Display the home page
    $view = new Template();
    echo $view->render('views/survey.html');
});

// Run Fat-Free
$f3->run();