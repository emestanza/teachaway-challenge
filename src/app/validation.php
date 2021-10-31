<?php
require __DIR__ .'/../exceptions/ValidationException.php';

function validate($args){
    $v = new Valitron\Validator($args);
    $v->rule('required', 'name');
    $v->rule('in', 'type', ['vehicle', 'starship']);

    if(!$v->validate()) {
        throw new ValidationException($v->errors());
    } 
}