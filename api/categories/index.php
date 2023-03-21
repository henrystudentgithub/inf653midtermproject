<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    //Getting URL that is being passed
    $uri = $_SERVER['REQUEST_URI'];

    //$idPassed = parse_url($uri, PHP_URL_QUERY);

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }


    if ($method === 'GET') {
        //checking URL if it has a query statement like id=1
        if (parse_url($uri, PHP_URL_QUERY)){
            require('get_one.php');
        } else {
            require('get_all.php');
        }
    }

    else if ($method === 'POST') {
        require('create_one.php');
    }

    else if ($method === 'PUT') {
        require('update_one.php');
    }

    else if ($method === 'DELETE') {
        require('delete_one.php');
    }
?>
