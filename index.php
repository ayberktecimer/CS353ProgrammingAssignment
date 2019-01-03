<?php
/**
 * Created by IntelliJ IDEA.
 * User: ayberk
 * Date: 28 Kas 2018
 * Time: 18:14
 */

//config inclusion session starts
include("config.php");
session_start();

//defining necessary variables
$username = "";
$password = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $username = mysqli_real_escape_string($db,$_POST['username']);
    $password = mysqli_real_escape_string($db,$_POST['password']);

    //sql query for checking inputs and finding corresponding student
    $sql = "SELECT sname, sid FROM student WHERE sname = ? and sid = ?";
    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $entered_username, $entered_password);

        //set parameters
        $entered_username = $username;
        $entered_password = $password;

        //executing the statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            //checking if sid and sname is true
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $username, $turned_pw);

                if(mysqli_stmt_fetch($stmt)){
                    if($turned_pw == $password){
                        //inputs are correct session is starting
                        session_start();
                        $_SESSION['sname'] = $username;
                        $_SESSION['sid'] = $password;
                        header("location: welcome.php");
                    }
                }
            }else{
                //wrong input
                echo "<script type='text/javascript'>alert('Invalid Username or Password.');</script>";
            }

        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        #centerwrapper { text-align: center; margin-bottom: 10px; }
        #centerdiv { display: inline-block; }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-inverse bg-primary navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h4 class="navbar-text">Summer Internship Application</h4>
            </div>
        </div>
    </nav>
    <div id="centerwrapper">
        <div id="centerdiv">
            <br><br>
            <h2>Login to Internship System</h2>
            <p>Please enter your username and password to login.</p>
            <form id="loginForm" action="" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" id="username">

                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" id="password">

                </div>
                <div class="form-group">
                    <input onclick="checkEmptyAndLogin()" class="btn btn-primary" value="Login">
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    function checkEmptyAndLogin() {
        var usernameVal = document.getElementById("username").value;
        var passwordVal = document.getElementById("password").value;
        if (usernameVal === "" || passwordVal === "") {
            alert("Make sure to fill all fields!");
        }
        else {
            var form = document.getElementById("loginForm").submit();
        }
    }
</script>
</body>
</html>