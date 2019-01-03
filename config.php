<?php
/**
 * Created by IntelliJ IDEA.
 * User: ayber
 * Date: 27 Kas 2018
 * Time: 14:01
 */
   define('DB_SERVER', 'dijkstra.ug.bcc.bilkent.edu.tr');
   define('DB_USERNAME', 'xxxx');
   define('DB_PASSWORD', 'xxxx');
   define('DB_DATABASE', 'ayberktecimer');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if (!$db) {
    die("patladık hocam. " . mysqli_connect_error());
}
echo "Connected successfully";
?>

