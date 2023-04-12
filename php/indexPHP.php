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
    <link rel="stylesheet" href="../css/FormTemplate1.css">
</head>
<body>
	
    <div class="main">
        <form class="form" id="loginForm" method="get" action="indexPHP.php">
            <h1 class="page_title">Login to Employee Portal</h1>
            <input type="text" class="form__input" id="employeeID" name="employeeID" autofocus="" placeholder="Employee ID"> <br><br>
            <input type="password" class="form__input" id="password" name="password" autofocus="" placeholder="Password"> <br><br>
            <input type="submit" id="login" name="login" class="inputStyle" value="LogIn"> <br><br>   
            <a href="resetPass.html" class="form__link">Forgot your password?</a> <br><br>
            <a class="form__link" href="../firstLogIn.html" id="linkFirstTime">First Time User?</a><br> <br>
            <a class="form__link" href="../adminLogIn.html" id="linkAdminLogin">Admin Login</a>
        </form>
    </div>
    <div class = "FAQ">
        <div class = "content"> <p><a href="../FAQ.html"> FAQ</a></p></div>
        <img src="../burger.gif" alt="burger">
    </div>
<?php
//connect to the mssql database
$conn = new PDO("sqlsrv:server = tcp:test-server-seniorproject.database.windows.net,1433; Database = test", "mainLogin", "AdminUser42!");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//code to get the employeeID and password from the form 
$employeeID = $_GET['employeeID'];
$password = $_GET['password'];

//code to check if the employeeID and password fields are empty
if (empty($employeeID) || empty($password)) {
    echo '<script language="javascript">alert("Please enter your ID and password!");</script>';  
}

//code to check if the employeeID and password fields are not empty
if (!empty($employeeID) && !empty($password)) {
    //query the database to see if the user exists
    $sql = "SELECT * FROM employees WHERE username = '$employeeID'";
    $result = $conn->query($sql);
    $row = $result->fetch();
    if ($row) {
        //check if the password is correct
        if ($row['password'] == $password) {
            //JS alert to say login successful
            echo '<script language="javascript">alert("Login Successful!");</script>';
            //redirect to mainEmployeePortal.html
            header("Location: ../mainEmployeePortalPage.php");
            $conn = null;
        }
        else {
            echo '<script language="javascript">alert("Incorrect Password!");</script>';          
            $conn = null;
        }
    }
    else {
        echo '<script language="javascript">alert("Incorrect Employee ID!");</script>';
        $conn = null;
    }
}

//check if the login button was pressed and query the database to get the employeeID from the table where the inputted username and password match and store it in a session variable
if (isset($_GET['login'])) {
    $sql = "SELECT employeeID FROM employees WHERE username = '$employeeID' AND password = '$password'";
    $result = $conn->query($sql);
    $row = $result->fetch();
    //add the employeeID to the session variable
    $_SESSION['employeeID'] = $row['employeeID'];
}

?>    
</body>
</html>
