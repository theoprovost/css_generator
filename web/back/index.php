<?php
// require_once './php/css_generator.php';

if (!empty($_POST)) {
    $folder = $_FILES["upload"]; // upload[] ?

    ob_start();
    echo sys_get_temp_dir();

    $inst = [
        'recursive' => isset($_POST["recursive"]) ? isset($_POST["recursive"]) : NULL, 
        'img_name' => isset($_POST["img_name"]) ? isset($_POST["img_name"]) : 'sprite.png',
        'sheet_name' => isset($_POST["sheet_name"]) ? isset($_POST["sheet_name"]) : 'style.css',
        'size' => isset($_POST["size"]) ? isset($_POST["size"]) : NULL,
        'columns' => isset($_POST["columns"]) ? isset($_POST["columns"]) : NULL,
        'padding' => isset($_POST["padding"]) ? isset($_POST["padding"]) : NULL,
    ];

    // main($folder, $inst);
    print_r($inst);
    print_r($_GET);
    print_r($_GET["test"]);
    print_r($_FILES["upload"]);
    
    error_log(ob_get_clean(), 4);

    if (is_string($process)) {
        header('HTTP/1.1' . ' ' . 200 . ' ' . "$process");
        echo "All good";
    } else {
        header('HTTP/1.1' . ' ' . 500 . ' ' . ':(');
    }
};