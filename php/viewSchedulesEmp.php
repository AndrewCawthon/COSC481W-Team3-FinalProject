<?php session_start(); ?>
<html>
    <head>
    <title>Employee Schedule</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <style>
        *{
            text-decoration: none;
            padding: 5;
        }
        a {
            color: blue;
			text-decoration: underline;
        }
		a:hover {
			text-decoration: none;
		}
        header{
            height: 70px;
            width: 100%;
            position: fixed;
            display: flex;
            justify-content: flex-end;
            border-bottom: 1px black solid;
            background-color: rgb(252, 251, 251);
        }
        .imgs{
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        td {
            padding-right: 10px;
            text-align: center;
        }
        @media screen and (max-width: 480px) {}  
    </style>
    <link rel='stylesheet' href='./style.css'>
    </head>
    <body>
        <form action="../mainEmployeePortalPage.html" method="post">
            <input type="submit" name="back" value="Back">
        </form>
        <form action="viewSchedulesEmp.php" method="post">
            <input type="text" name="id" placeholder="Employee ID">
            <input type="submit" name="submit" value="Submit">
        </form> 
    </body>
</html>

<?php
//connect to the mssql database
$conn = new PDO("sqlsrv:server = tcp:test-server-seniorproject.database.windows.net,1433; Database = test", "mainLogin", "AdminUser42!");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//if the submit button was clicked, display the schedule for the employee based on the id
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $_SESSION['EmployeeID'] = $_POST['id'];
    //display the schedule for the employee based on the id
    $sql = "SELECT employeeID, work_date, start_work_hour, end_work_hour FROM schedule WHERE employeeID = '$id'";
    $result = $conn->query($sql);

    //display the results in an HTML table
    echo "<table border='1' bgcolor='beige'>";
    echo "<tr><th>Employee ID</th><th>Work Date</th><th>Start Work Hour</th><th>End Work Hour</th></tr>";
    foreach ($result as $row) {
        echo "<tr><td>".$row['employeeID']."</td><td>".$row['work_date']."</td><td>".$row['start_work_hour']."</td><td>".$row['end_work_hour']."</td></tr>";
    }
    echo "</table>";
}




?>
