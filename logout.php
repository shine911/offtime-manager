<?php
    include 'class/DatabaseController.php';
    $canbo = new CanBo("cb002", "alql","qui", md5("qui"),"2");
    echo $canbo->create();
    DatabaseController::create($canbo);
