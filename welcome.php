<?php
/**
 * Created by IntelliJ IDEA.
 * User: ayberk
 * Date: 29 Kas 2018
 * Time: 09:00
 */

//inclusion of config.php
include("config.php");
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $given_cid = $_POST['given_cid'];
    $student_id = $_SESSION['sid'];

    // cancelling application query
    $deletion_query = "DELETE FROM apply WHERE sid ='$student_id' AND cid='$given_cid'";
    $result = mysqli_query($db,$deletion_query);

    // after deleting application, quota of this company is increased in that query
    $update_quota_query = "UPDATE company SET quota = quota + 1 WHERE cid='$given_cid'";
    $result1 = mysqli_query($db,$update_quota_query);

    //checking errors
    if (!$result && !$result1) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }else{
        echo "<script LANGUAGE='JavaScript'>
            window.alert('Application is successfully deleted.');
            window.location.href = 'welcome.php'; 
        </script>";
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
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <h5 class="navbar-text">Welcome,<?php echo htmlspecialchars($_SESSION['sname']); ?></h5>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Go Back</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </nav>
    <div class="panel container-fluid">
        <h3 class="page-header" style="font-weight: bold;">Applied Internships</h3>
        <?php
        // Prepare a select statement
        $query = "SELECT cid, cname, quota FROM student NATURAL JOIN apply NATURAL JOIN company WHERE sid = " .$_SESSION['sid'];

        echo "<p><b>Student ID:</b> " . $_SESSION['sid'] . "</p>";

        $result = mysqli_query($db, $query);

        if (!$result) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }

        echo "<table class=\"table table-lg table-striped\">
            <tr>
            <th>Company ID</th>
            <th>Company Name</th>
            <th>Quota</th>
            <th>Cancel</th>
            </tr>";

        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['cid'] . "</td>";
            echo "<td>" . $row['cname'] . "</td>";
            echo "<td>" . $row['quota'] . "</td>";
            echo "<td> <form action=\"\" METHOD=\"POST\">
                    <button type=\"submit\" name = \"given_cid\"class=\"btn btn-danger btn-sm\" value =".$row['cid'] .">X</button>
                    </form>
                     
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>
    </div>
    <p><a href="apply.php" class="btn btn-success">Apply Internship</a></p>
</div>



</body>
</html>

