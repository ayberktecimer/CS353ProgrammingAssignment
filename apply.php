<?php
/**
 * Created by IntelliJ IDEA.
 * User: ayber
 * Date: 29 Kas 2018
 * Time: 09:50
 */
include("config.php");
session_start();

echo "Apply: ".$_SESSION['sname'];
?>