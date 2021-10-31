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

function validatePutForSet($args){
    $v = new Valitron\Validator($args);
    $v->rule('required', 'quantity');
    $v->rule('required', 'id');
    $v->rule('integer', 'quantity', true);
    $v->rule('min', 'quantity', 1);
    $v->rule('integer', 'id', true);
    $v->rule('min', 'id', 1);
    $v->rule('in', 'type', ['vehicle', 'starship']);

    if(!$v->validate()) {
        throw new ValidationException($v->errors());
    } 
}