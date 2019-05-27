<?php

require_once 'lib/XlsxWork.php';

if (isset($_POST)) {
    file_put_contents("logs.log", "\nSUCCESS: get POST request.", FILE_APPEND);
    $xlsx = new XlsxWork();
    $xlsx->createNewXlsx();
    $xlsx->addData($_POST);
    $xlsx->saveXlsx();
}


