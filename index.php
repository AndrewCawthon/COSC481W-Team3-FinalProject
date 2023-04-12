<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <style>
        @media screen and (max-width: 480px) {}  
    </style>
    <link rel="stylesheet" href="css/FormTemplate1.css">
</head>
<body>	
    <div class="main">
        <form class="form" id="loginForm" method="get" action="index.php">
            <h1 class="page_title">Login to Employee Portal</h1>
            <input type="password" class="form__input" id="employeeID" name="employeeID" autofocus="" placeholder="Employee ID"> <br><br>
            <input type="text" class="form__input" id="username" name="username" autofocus="" placeholder="Username"> <br><br>
            <input type="password" class="form__input" id="password" name="password" autofocus="" placeholder="Password"> <br><br>
            <input type="submit" id="login" name="login" class="inputStyle" value="LogIn"> <br><br>   
            <a href="resetPass.html" class="form__link">Forgot your password?</a> <br><br>
            <!-- <a class="form__link" href="firstLogIn.html" id="linkFirstTime">First Time User?</a><br> <br> -->
            <a class="form__link" href="adminLogIn.php" id="linkAdminLogin">Admin Login</a>
        </form>
    </div>
    <div class = "FAQ">
        <div class = "content"> <p><a href="FAQ.html"> FAQ</a></p></div>
        <img src="burger.gif" alt="burger">
    </div>
<?php
//connect to the mssql database
$conn = new PDO("sqlsrv:server = tcp:test-server-seniorproject.database.windows.net,1433; Database = test", "mainLogin", "AdminUser42!");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//check if the login button was pressed
if (isset($_GET['login'])) {
    //code to get the username, id, and password from the form 
    $employeeID = $_GET['employeeID'];
    $username = $_GET['username'];
    $password = $_GET['password'];

    //code to check if the username, id, and password are in the database
    $sql = "SELECT * FROM employees WHERE employeeID = '$employeeID' AND username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    //if the username, id, and password are in the database, then redirect to the employee portal page and add the employeeID to the session
    if ($row['employeeID'] == $employeeID && $row['username'] == $username && $row['password'] == $password) {
        $_SESSION['employeeID'] = $employeeID;
        header("Location: mainEmployeePortalPage.html");
    } else {
        echo "<script>alert('Incorrect Username, ID, or Password. Please try again.')</script>";
    }

    //if the username does not exist then print a JS alert
    if ($row['username'] != $username) {
        echo "<script>alert('Username does not exist. Please try again.')</script>";
    }

    //if the password is incorrect then print a JS alert
    if ($row['username'] == $username && $row['employeeID'] == $employeeID &&$row['password'] != $password) {
        echo "<script>alert('Incorrect Password. Please try again.')</script>";
    }

    //if the employeeID is incorrect then print a JS alert
    if ($row['username'] == $username && $row['employeeID'] != $employeeID && $row['password'] == $password) {
        echo "<script>alert('Incorrect Employee ID. Please try again.')</script>";
    }
    
}

?>
</body>
</html>

