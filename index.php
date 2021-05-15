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
        $_SESSION['name'] = $_POST['name'];
        // $userName = $_POST['name'];

        if (!empty($_POST['options'])) {
            // Get user input and assign it to the variable
            $userOptions = $_POST['options'];
            //If options are valid
            $_SESSION['options'] = $userOptions;
        }
        header('location: summary');
    }

    //Get the options from the Model and send them to the View
    $f3->set('options', getOptions());

    // Add the data to the hive
    $f3->set('userOptions', $userOptions);
    $f3->set('userName', $userName);

    // Display the survey page
    $view = new Template();
    echo $view->render('views/survey.html');
});

$f3->route('GET /summary', function () {

    //Display the summary
    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run Fat-Free
$f3->run();