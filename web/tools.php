<?php

/**
 * Return FALSE if a filed is ok, otherwise return reason of invalidation
 */
function form_field_is_invalid($key){
    switch ($key) {
        case 'Name':

            if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])>0 && strlen($_REQUEST[$key])<3) {
                $_REQUEST[$key] = '';
                return 'the value is not correct';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])){
                return 'the value is empty';
            }
            else return false;
        case 'ID':
            if (isset($_REQUEST[$key]) &&  !is_numeric($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
                $_REQUEST[$key] = '';
                return 'the value is not numeric';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])){
                return 'the value is empty';
            }
            else return false;
        case 'Address':
            if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])>0 && strlen($_REQUEST[$key])<4) {
                $_REQUEST[$key] = '';
                return 'the value is not correct';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])) {
                return 'the value is empty';
            }
            else return false;
        case 'Type':
            if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])>0 && strlen($_REQUEST[$key])<2) {
                $_REQUEST[$key] = '';
                return 'the value is not correct';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])){
                return 'the value is empty';
            }
            else return false;
        case 'Source':
            if (isset($_REQUEST[$key]) && strlen($_REQUEST[$key])>0 && strlen($_REQUEST[$key])<5) {
                $_REQUEST[$key] = '';
                return 'the value is not correct';
            }
            elseif (isset($_REQUEST[$key]) && empty($_REQUEST[$key])){
                return 'the value is empty';
            }
            else return false;

        default:
            return false;
    }
}

function isset_form() {
    return isset($_REQUEST['Name']);
}

