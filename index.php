<?php 

require "Message.php";

// $message = new Message();

$message = array(
    'empty' => array(
        'email' => 'rentrez un mail !'
    ), 
    'invalid' => array(
        'email' => 'L\'addresse email que vous avez saisie est refusée : format invalide'
    )
);

$message = json_encode($message, JSON_PRETTY_PRINT);

echo '<pre>';

echo $message;

echo '</pre>';