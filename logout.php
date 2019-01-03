<?php
/**
 * Created by IntelliJ IDEA.
 * User: ayberk
 * Date: 29 Kas 2018
 * Time: 23:34
 */


session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
echo "<script LANGUAGE='JavaScript'>
          window.alert('Logging out...');
          window.location.href='index.php';
       </script>";

exit;
?>