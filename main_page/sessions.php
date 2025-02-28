<?php
    
    session_start();
    $name = $_SESSION['name'];

    //session check
    if ($name == null){
        header("location: http://localhost/alumnitalk/NoSession.php");
    }

    //session timeout (45 minutes)
    if ($_SESSION['time'] + 45 * 60 < time()){
        session_destroy();
        header("location: http://localhost/alumnitalk/NoSession.php");
    }
?>