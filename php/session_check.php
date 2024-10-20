<?php
session_set_cookie_params(['lifetime' => 86400, 'httponly'=> true]);

session_start();


if(isset($_SERVER['REQUEST_METHOD'] == 'POST')){
    if($_SESSION['user_type'])
}





?>