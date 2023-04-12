<?php
//start the session
session_start(); 
//DB connection
$conn = new PDO("sqlsrv:server = tcp:test-server-seniorproject.database.windows.net,1433; Database = test", "mainLogin", "AdminUser42!");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//get the current date 
$today = date("Y-m-d");

//check to see whether current week or next week was selected using POST from the schedule select box in employeeViewSchedule.html
$week = $_POST['schedule'];

//get the employeeID from the session variable
$employeeID = $_SESSION['employeeID'];

//get the current week number
$weekNum = date("W");

//get the next week number
$nextWeek = $weekNum + 1;

//check if current week was selected
if (isset($_POST['schedule']) && $_POST['schedule'] == 'current') {
    //get the schedule for the current week for the employeeID in session from the database in an html table 
    $sql = "SELECT * FROM schedule WHERE employeeID = '$employeeID' AND work_date BETWEEN DATEADD(week, DATEDIFF(week, 0, GETDATE()), 0) AND DATEADD(week, DATEDIFF(week, 0, GETDATE()) + 1, -1)";

    $result = $conn->query($sql);
    echo "<table border='1'>
    <tr>
    <th>Employee ID</th>
    <th>Work Date</th>
    <th>Start Work Hour</th>
    <th>End Work Hour</th>
    <th>Is Holiday</th>
    <th>Is Weekend</th>
    </tr>";
    while($row = $result->fetch()) {
        echo "<tr>";
        echo "<td>" . $row['employeeID'] . "</td>";
        echo "<td>" . $row['work_date'] . "</td>";
        echo "<td>" . $row['start_work_hour'] . "</td>";
        echo "<td>" . $row['end_work_hour'] . "</td>";
        echo "<td>" . $row['is_holiday'] . "</td>";
        echo "<td>" . $row['is_weekend'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

//check if next week was selected
if (isset($_POST['schedule']) && $_POST['schedule'] == 'next') {
    //get the schedule for the next week for the employeeID in session from the database in an html table 
    $sql = "SELECT * FROM schedule WHERE employeeID = '$employeeID' AND work_date BETWEEN DATEADD(week, DATEDIFF(week, 0, GETDATE()) + 1, 0) AND DATEADD(week, DATEDIFF(week, 0, GETDATE()) + 2, -1)";

    $result = $conn->query($sql);
    echo "<table border='1'>
    <tr>
    <th>Employee ID</th>
    <th>Work Date</th>
    <th>Start Work Hour</th>
    <th>End Work Hour</th>
    <th>Is Holiday</th>
    <th>Is Weekend</th>
    </tr>";
    while($row = $result->fetch()) {
        echo "<tr>";
        echo "<td>" . $row['employeeID'] . "</td>";
        echo "<td>" . $row['work_date'] . "</td>";
        echo "<td>" . $row['start_work_hour'] . "</td>";
        echo "<td>" . $row['end_work_hour'] . "</td>";
        echo "<td>" . $row['is_holiday'] . "</td>";
        echo "<td>" . $row['is_weekend'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

?>
