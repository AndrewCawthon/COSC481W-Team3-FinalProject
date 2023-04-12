
<html>
    <head>
    <title>Edit Schedules</title>
    <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <form action="editSchedule.php" method="post">
            <input type="text" name="id" placeholder="Employee ID">
            <input type="submit" name="submit" value="Submit">
        </form>
        <form action="../welcomeToTheManagerPortalPage.html">
            <input type="submit" name="back" value="Back">
        </form>
    </body>
</html>
<?php
session_start();
//connect to the mssql database
$conn = new PDO("sqlsrv:server = tcp:test-server-seniorproject.database.windows.net,1433; Database = test", "mainLogin", "AdminUser42!");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//select all schedule change reqquests based on employeeID when the submit but is pressed
if (isset($_POST['submit'])) {
    $employeeID = $_POST['id'];
    $_SESSION['EmployeeID'] = $_POST['id'];

    $sql = "SELECT employeeID, work_date, start_work_hour, end_work_hour FROM schedule_requests WHERE employeeID = '$employeeID'";
    $result = $conn->query($sql);

    //display the results in an HTML table with a checkbox next to each row
    //put the checkbox in a form so that the user can select multiple rows
    echo "<form action='editSchedule.php' method='post'>";
    echo "<table border='1'>";
    echo "<tr><th>Employee ID</th><th>Work Date</th><th>Start Time</th><th>End Time</th><th>Accept</th><th>Deny</th></tr>";
    foreach ($result as $row) {
        echo "<tr><td>".$row['employeeID']."</td><td>".$row['work_date']."</td><td>".$row['start_work_hour']."</td><td>".$row['end_work_hour']."</td><td><input type='checkbox' name='accept[]' value='".$row['work_date']."'></td><td><input type='checkbox' name='deny[]' value='".$row['work_date']."'></td></tr>";
    }
    echo "</table>";
    echo "<input type='submit' name='submit2' value='Submit Change'>";
    echo "</form>";

}

if (isset($_POST['submit2'])) {
    //change the schedule for the employee based on the checkboxes
    //if the accept checkbox is checked, add the schedule to the schedule table
    //if the deny checkbox is checked, delete the schedule from the schedule_requests table
    if (isset($_POST['accept'])) {
        $accept = $_POST['accept'];
        $employeeID = $_SESSION['EmployeeID'];
        foreach ($accept as $accepted) {
            $sql = "INSERT INTO schedule (employeeID, work_date, start_work_hour, end_work_hour) SELECT employeeID, work_date, start_work_hour, end_work_hour FROM schedule_requests WHERE employeeID = '$employeeID' AND work_date = '$accepted'";
            $conn->query($sql);
            $sql = "DELETE FROM schedule_requests WHERE employeeID = '$employeeID' AND work_date = '$accepted'";
            $conn->query($sql);
        }
    }
    if (isset($_POST['deny'])) {
        $deny = $_POST['deny'];
        $employeeID = $_SESSION['EmployeeID'];
        foreach ($deny as $denied) {
            $sql = "DELETE FROM schedule_requests WHERE employeeID = '$employeeID' AND work_date = '$denied'";
            $conn->query($sql);
        }
    }
   
    /*foreach ($accept as $accepted) {
        echo $accepted . " was accepted" . "<br>";
    }*/  

}

?>
