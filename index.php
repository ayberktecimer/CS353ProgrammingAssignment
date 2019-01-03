<?php
/**
 * Created by IntelliJ IDEA.
 * User: ayber
 * Date: 28 Kas 2018
 * Time: 18:14
 */
include("config.php");
session_start();

$username = "";
$password = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $username = mysqli_real_escape_string($db,$_POST['username']);
    $password = mysqli_real_escape_string($db,$_POST['password']);
    $sql = "SELECT sname, sid FROM student WHERE sname = ? and sid = ?";
    if($stmt = mysqli_prepare($db, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $entered_username, $entered_password);

        $entered_username = $username;
        $entered_password = $password;

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $username, $turned_pw);

                if(mysqli_stmt_fetch($stmt)){
                    if($turned_pw == $password){
                        session_start();
                        $_SESSION['sname'] = $username;
                        $_SESSION['sid'] = $password;
                        header("location: welcome.php");
                    }
                }
            }else{
                echo "<script type='text/javascript'>alert('Invalid Username or Password.');</script>";
            }

        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
?>
<html>

<head>
    <title>Login Page</title>

    <style type = "text/css">
        body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
        }
        label {
            font-weight:bold;
            width:100px;
            font-size:14px;
        }
        .box {
            border:#666666 solid 1px;
        }
    </style>

</head>

<body bgcolor = "#FFFFFF">

<div align = "center">
    <div style = "width:300px; border: solid 1px #333333; " align = "left">
        <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>

        <div style = "margin:30px">

            <form action = "" method = "POST">
                <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                <label>Password  :</label><input type = "text" name = "password" class = "box" /><br/><br />
                <input type = "submit" value = " Submit "/><br />
            </form>
        </div>

    </div>

</div>

</body>
</html>