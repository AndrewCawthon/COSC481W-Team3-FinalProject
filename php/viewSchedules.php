<html>
    <head>
    <title>Employee Schedules</title>
    <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <form action="viewSchedules.php" method="post">
            <input type="text" name="id" placeholder="Employee ID">
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
</html>

<?php
//connect to the mssql database
$conn = new PDO("sqlsrv:server = tcp:test-server-seniorproject.database.windows.net,1433; Database = test", "mainLogin", "AdminUser42!");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['submit'])) {
    $id = $_POST['id'];

    //display the schedule for the employee based on the username
    $sql = "SELECT employeeID, work_date, start_work_hour, end_work_hour FROM schedule WHERE employeeID = '$id'";
    $result = $conn->query($sql);

   //display the results in an HTML table
    echo "<table border='1'>";
    echo "<tr><th>Employee ID</th><th>Work Date</th><th>Start Work Hour</th><th>End Work Hour</th></tr>";
    foreach ($result as $row) {
        echo "<tr><td>".$row['employeeID']."</td><td>".$row['work_date']."</td><td>".$row['start_work_hour']."</td><td>".$row['end_work_hour']."</td></tr>";
    }
    echo "</table>";
}

?>
