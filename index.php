<?php

// This is my controller for the Midterm project

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the files that are needed for page to work
require_once ('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validation.php');

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

// Define next page
$f3->route('GET|POST /survey', function($f3){
    // Reinitialize the session array
    $_SESSION = array();

    // initialize variables to store user input
    $userOptions = array();
    $userName = "";

    //If the form has been submitted, grab the data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // catch what the user types in for name
        $userName = $_POST['name'];
        // check if the name is valid or not
        if (validName($_POST['name'])) {
            // if the name is valid, save it from the session
            $_SESSION['name'] = $_POST['name'];
        } else {
            // make sure to have a <check> and <span> in the html for this
            $f3->set('errors["name"]', 'Please enter a valid name');
        }

        // if options are selected when the form is submitted...
        if (!empty($_POST['options'])) {
            // Catch what the user selects
            $userOptions = $_POST['options'];
            // Check if the options are valid or not
            if (validOptions($userOptions)) {
                // if the options are valid, save them to our variable
                $_SESSION['options'] = $userOptions;
            }
        }
        else {
            // if the options are empty and/or not valid, display an error
            $f3->set('errors["options"]', 'You must select at least one option');
        }

        //If the error array is empty, redirect to summary page
        if (empty($f3->get('errors'))) {
            // Redirect
            header('location: summary');
        }
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