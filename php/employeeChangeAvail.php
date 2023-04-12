
<?php

//start session
session_start();

//get the employeeID from session
$employeeID = $_SESSION['employeeID'];

//connect to the database
$conn = new PDO("sqlsrv:server = tcp:test-server-seniorproject.database.windows.net,1433; Database = test", "mainLogin", "AdminUser42!");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//get the start times for the days in employeeChangeAvail.html
$startTime = $_POST['ST'];
//convert the start times to military time
if ($startTime == "12:00 AM") {
    $startTime = "00:00:00";
}
else if ($startTime == "1:00 AM") {
    $startTime = "01:00:00";
}
else if ($startTime == "2:00 AM") {
    $startTime = "02:00:00";
}
else if ($startTime == "3:00 AM") {
    $startTime = "03:00:00";
}
else if ($startTime == "4:00 AM") {
    $startTime = "04:00:00";
}
else if ($startTime == "5:00 AM") {
    $startTime = "05:00:00";
}
else if ($startTime == "6:00 AM") {
    $startTime = "06:00:00";
}
else if ($startTime == "7:00 AM") {
    $startTime = "07:00:00";
}
else if ($startTime == "8:00 AM") {
    $startTime = "08:00:00";
}
else if ($startTime == "9:00 AM") {
    $startTime = "09:00:00";
}
else if ($startTime == "10:00 AM") {
    $startTime = "10:00:00";
}
else if ($startTime == "11:00 AM") {
    $startTime = "11:00:00";
}
else if ($startTime == "12:00 PM") {
    $startTime = "12:00:00";
}
else if ($startTime == "1:00 PM") {
    $startTime = "13:00:00";
}
else if ($startTime == "2:00 PM") {
    $startTime = "14:00:00";
}
else if ($startTime == "3:00 PM") {
    $startTime = "15:00:00";
}
else if ($startTime == "4:00 PM") {
    $startTime = "16:00:00";
}
else if ($startTime == "5:00 PM") {
    $startTime = "17:00:00";
}
else if ($startTime == "6:00 PM") {
    $startTime = "18:00:00";
}
else if ($startTime == "7:00 PM") {
    $startTime = "19:00:00";
}
else if ($startTime == "8:00 PM") {
    $startTime = "20:00:00";
}
else if ($startTime == "9:00 PM") {
    $startTime = "21:00:00";
}
else if ($startTime == "10:00 PM") {
    $startTime = "22:00:00";
}
else if ($startTime == "11:00 PM") {
    $startTime = "23:00:00";
}
else if ($startTime == "12:00 PM") {
    $startTime = "24:00:00";
}

//get the end times for the days in employeeChangeAvail.html
$endTime = $_POST['ET'];
//convert the end times to military time
if ($endTime == "12:00 AM") {
    $endTime = "00:00:00";
}
else if ($endTime == "1:00 AM") {
    $endTime = "01:00:00";
}
else if ($endTime == "2:00 AM") {
    $endTime = "02:00:00";
}
else if ($endTime == "3:00 AM") {
    $endTime = "03:00:00";
}
else if ($endTime == "4:00 AM") {
    $endTime = "04:00:00";
}
else if ($endTime == "5:00 AM") {
    $endTime = "05:00:00";
}
else if ($endTime == "6:00 AM") {
    $endTime = "06:00:00";
}
else if ($endTime == "7:00 AM") {
    $endTime = "07:00:00";
}
else if ($endTime == "8:00 AM") {
    $endTime = "08:00:00";
}
else if ($endTime == "9:00 AM") {
    $endTime = "09:00:00";
}
else if ($endTime == "10:00 AM") {
    $endTime = "10:00:00";
}
else if ($endTime == "11:00 AM") {
    $endTime = "11:00:00";
}
else if ($endTime == "12:00 PM") {
    $endTime = "12:00:00";
}
else if ($endTime == "1:00 PM") {
    $endTime = "13:00:00";
}
else if ($endTime == "2:00 PM") {
    $endTime = "14:00:00";
}
else if ($endTime == "3:00 PM") {
    $endTime = "15:00:00";
}
else if ($endTime == "4:00 PM") {
    $endTime = "16:00:00";
}
else if ($endTime == "5:00 PM") {
    $endTime = "17:00:00";
}
else if ($endTime == "6:00 PM") {
    $endTime = "18:00:00";
}
else if ($endTime == "7:00 PM") {
    $endTime = "19:00:00";
}
else if ($endTime == "8:00 PM") {
    $endTime = "20:00:00";
}
else if ($endTime == "9:00 PM") {
    $endTime = "21:00:00";
}
else if ($endTime == "10:00 PM") {
    $endTime = "22:00:00";
}
else if ($endTime == "11:00 PM") {
    $endTime = "23:00:00";
}
else if ($endTime == "12:00 PM") {
    $endTime = "24:00:00";
}

//get the date to take effect from employeeChangeAvail.html
$date = $_POST['dateEffect'];

$is_weekend = 0;
$is_holiday = 0;

//holidays array
$holidays = array("2022-01-01", "2022-01-15", "2022-02-19", "20-05-28", "2018-07-04", "2018-09-03", "2018-11-22", "2018-11-23", "2018-12-25");

//check if the current date has already passed
if (date("Y-m-d") > $date) {
    echo '<script language="javascript">alert("Please enter a date that has not already passed.");</script>';
    echo '<script language="javascript">window.location.href = "../employeeChangeAvail.html";</script>';
}

//check if the start time is after the end time
else if ($startTime > $endTime) {
    echo '<script language="javascript">alert("Please enter a start time that is before the end time.");</script>';
    echo '<script language="javascript">window.location.href = "../employeeChangeAvail.html";</script>';
}

//check if the inputted date is a weekend
else if (date('N', strtotime($date)) >= 6) {
    $is_weekend = 1;
}

//if the start time is before the end time and the date has not passed, update the database
else {
    $sql = "INSERT INTO schedule_requests (employeeID, work_date, start_work_hour, end_work_hour, is_holiday, is_weekend) VALUES ('$employeeID', '$date', '$startTime', '$endTime', '$is_holiday', '$is_weekend')";
    $conn->exec($sql);
    echo '<script language="javascript">alert("Availability updated wait for a response!");</script>';
    echo '<script language="javascript">window.location.href = "../employeeChangeAvail.html";</script>';
}

?>