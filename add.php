<?php
    $server = 'localhost';
    $username = 'cloudasim';
    $password = 'cloudasim';
    $dbname = 'cloudasim';
    $db = new mysqli($server, $username, $password, $dbname);
    // connect to db
    if ($db->connect_error) {
        $message = $db->connect_error;
    }

    // set variables from form elements
    $fullname = $_POST["fullname"];
    $emailadd = $_POST["emailadd"];
    $phone = $_POST["phonenum"];
    $message = $_POST["message"];
    $senton = $_POST["senton"];

    $sql = "INSERT INTO feedback (name, email, phone, message, senton) VALUES ('$fullname', '$emailadd', '$phone', '$message', '$senton')";
    if($db->query($sql) === TRUE){
        echo "success";
    }
    if($db->error){
        echo "<br>" . $db->error;
    }
?>