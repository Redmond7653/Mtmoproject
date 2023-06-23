<?php
    echo 'Напишіть свої дані';
    include 'tools_old.php';
    include 'template/_header.html';




//    var_export($_REQUEST);
//    var_export($_REQUEST['test1']);


    if (!isset_form()) {
        // a form does not exist
        $form['Name'] = '';
        $form['Address'] = '';
        $form['ID'] = '';
        $form['Type'] = '';
        $form['Source'] = '';
    }
    else {
        // the form was sent
        $key = 'Name';
        $form[$key] = $_REQUEST[$key];
        $key = 'ID';
        $form[$key] = $_REQUEST[$key];
        $key = 'Address';
        $form[$key] = $_REQUEST[$key];
        $key = 'Type';
        $form[$key] = $_REQUEST[$key];
        $key = 'Source';
        $form[$key] = $_REQUEST[$key];

    }

include 'template/main_page_form.htm';

include 'template/_footer.html';
