<?php
/**
 * Created by IntelliJ IDEA.
 * User: ayber
 * Date: 29 Kas 2018
 * Time: 09:00
 */
include("config.php");
session_start();

echo "Welcome: ".$_SESSION['sname'];
echo "<table >
            <tr>
            <th>CID</th>
            <th>CName</th>
            <th>Quota</th>
            </tr>";

$query = "SELECT cid, cname, quota FROM student NATURAL JOIN apply NATURAL JOIN company WHERE sid = " .$_SESSION['sid'];

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

<!DOCTYPE html>
<html>
<body>

<a href="apply.php"><button type="button" onclick="">Apply Internship</button></a>



</body>
</html>
