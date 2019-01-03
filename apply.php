<?php
/**
 * Created by IntelliJ IDEA.
 * User: ayberk
 * Date: 29 Kas 2018
 * Time: 09:50
 */

//inclusion config.php
include("config.php");
session_start();

//sql query for selecting number of application of logged student
$query = "SELECT COUNT(*) AS cnt FROM apply WHERE sid =" . $_SESSION['sid'];
$result = mysqli_query($db, $query);

if (!$result) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}
$row = mysqli_fetch_array($result);
$input_success = true;
$num_of_application = $row['cnt'];
//if number of application is 3 do not allow to apply more
if($num_of_application == 3){
    //printing error message
    $input_success = false;
    echo "<script LANGUAGE='JavaScript'>
          window.alert('You already have applied for 3 internships');
          window.location.href='welcome.php';
       </script>";
    //header("location: welcome.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_success = true;
    $given_cid = $_POST['cid'];
    $student_id = $_SESSION['sid'];
    // checking whether input is proper format in other words checking unexpected input
    $wrong_input = "SELECT COUNT(*) AS cnt  FROM company WHERE cid='$given_cid'";

    // executing query
    $result = mysqli_query($db, $wrong_input);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    // checking whether is there corresponding company with given input else print error message
    $cnt = mysqli_fetch_array($result)['cnt'];
    if($cnt == 0){
        $input_success = false;
        echo "<script LANGUAGE='JavaScript'>
            window.alert('Wrong input there is no such company exists.');
            window.location.href = 'apply.php'; 
        </script>";
    }


    // sql query for checking whether student tries to add company which is already in applications.

    $already_applied_query = "SELECT COUNT(*) as cnt FROM apply WHERE sid IN (SELECT sid FROM apply WHERE cid ='$given_cid' AND sid ='$student_id')";
    $result = mysqli_query($db,$already_applied_query);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $row = mysqli_fetch_array($result);
    $application_count = $row['cnt'];
    if($application_count >= 1){
        $input_success = false;
        echo "<script LANGUAGE='JavaScript'>
            window.alert('You have already applied to this company.');
            window.location.href = 'apply.php'; 
        </script>";
    }


    // checking whether quota is available for given company
    $quota_error_query = "SELECT quota FROM company WHERE cid='$given_cid'";
    $result = mysqli_query($db,$quota_error_query);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $row = mysqli_fetch_array($result);
    $quota_count = $row['quota'];

    if($quota_count == 0){
        $input_success = false;
        echo "<script LANGUAGE='JavaScript'>
            window.alert('There is no available quota for this company.');
            window.location.href = 'apply.php'; 
        </script>";
    }
    if($input_success == true){
        // if everything is good up to now. Inserting the application in database
        $updating_quota_of_company_table_query = "UPDATE company SET quota = quota -1 WHERE cid = '$given_cid'";
        $result = mysqli_query($db,$updating_quota_of_company_table_query);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }

        $insert_application_query= "INSERT INTO apply VALUES ('$student_id','$given_cid')";
        $result = mysqli_query($db,$insert_application_query);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }else{
            echo "<script LANGUAGE='JavaScript'>
            window.alert('Application is successfully added redirecting to welcome page');
            window.location.href = 'welcome.php'; 
        </script>";
        }
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Accounts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        p { margin-bottom: 10px; }
        th, td { padding: 5px; text-align: left; }
        #centerwrapper { text-align: center; margin-bottom: 10px; }
        #centerdiv { display: inline-block; }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <h5 class="navbar-text">Welcome,<?php echo htmlspecialchars($_SESSION['sname']); ?></h5>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="welcome.php">Go Back</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </nav>
    <div class="panel container-fluid">
        <h3 class="page-header" style="font-weight: bold;">Apply For a Company</h3>
        <?php
        echo "<table class=\"table table-lg table-striped\">
        <tr>
            <th>CID</th>
            <th>CName</th>
            <th>Quota</th>
        </tr>";

        $query ="SELECT * FROM company as c WHERE quota > 0 AND  NOT EXISTS (SELECT * FROM apply WHERE c.cid = cid AND sid =" . $_SESSION['sid'].")";

        //"SELECT * FROM company as c WHERE quota > 0 AND NOT EXISTS " .
        //"(SELECT * FROM APPLY WHERE c.cid = cid AND sid =" .$_SESSION['sid'] .")";

        if (!$query) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }

        $result = mysqli_query($db, $query);

        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>" . $row['cid'] . "</td>";
            echo "<td>" . $row['cname'] . "</td>";
            echo "<td>" . $row['quota'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>

    <form action="" METHOD="POST">
        <div class = "form-row">
            <input type="text"  class="form-control col-md-4" name="cid" placeholder="Company ID">
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </div>
    </form>
</div>
