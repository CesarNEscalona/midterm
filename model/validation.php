<?php

/*
 * Validation for the Midterm proj
 */

// user name cannot be empty
function validName($name){
    return !empty($name);
}

// user must select at least one cupcake flavor
function validOptions($options){
    return !empty($options);
}