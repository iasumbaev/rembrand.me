<?php

require_once 'lib/XlsxWork.php';

if (isset($_POST)) {
    $currentDT = new DateTime();
    $currentDT = $currentDT->format('d-m-Y H:i:s');
    file_put_contents("logs.log", "\n" . $currentDT . ' SUCCESS: get POST request.', FILE_APPEND);
    $xlsx = new XlsxWork();
    $status = true;
    try {
        $xlsx->addData($_POST);
    } catch (Exception $e) {
        $currentDT = new DateTime();
        $currentDT = $currentDT->format('d-m-Y H:i:s');
        file_put_contents("logs.log", "\n" . $currentDT . ' ERROR: ' . $e, FILE_APPEND);
        $status = false;
    }
    if($status) {
        $xlsx->saveXlsx();
    }
}
