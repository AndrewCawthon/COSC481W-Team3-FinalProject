<!-- edited by Cecilia: removed provided password. made sure links worked. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First Login</title>
    <style>       
        @media screen and (max-width: 480px) {}  
    </style>
    <link rel="stylesheet" href="../css/FormTemplate1.css">
</head>
<body>
    <div class="main">
        <h1>First Time Login</h1>
        <form class="form" id="first_login" method="get" action="firstLogIn.php">  
            <input type="text" name="employeeID" class="form__input" autofocus="" placeholder="Employee ID"> <br><br>		
			<!--
            <div class="form__input-group">
                <input type="def_password" class="form__input" autofocus="" placeholder="Provided Password">
                <div class="form__input-error-message"></div>
            </div>
			-->
            <input type="password" name="password" class="form__input" autofocus="" placeholder="New Password"> <br><br>
            <input type="submit" name="submit" id ="setpass" class = "inputStyle" value="Set password & Login"><br><br>
            <!--<a class="form__link" href="../index.html">Not a First Time User?</a>-->       
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

if (isset($_GET['submit'])) {
    //get the employeeID and password from the form
    $username = $_GET['username'];
    $password = $_GET['password'];

    //check if the employeeID and password fields are empty
    if (empty($username) || empty($password)) {
    echo '<script language="javascript">alert("Please enter your ID and password!");</script>';  
    }

    //check if the employeeID and password fields are not empty
    else if (!empty($username) && !empty($password)) {
        //query the database to see if the user exists
        $sql = "SELECT * FROM employees WHERE username = '$username'";
        $result = $conn->query($sql);
        $row = $result->fetch();
        //if the user exists, print a JS alert and redirect to the login page
        if ($row) {
            echo '<script language="javascript">alert("User already exists! Please create a new user.");</script>';
            echo '<script language="javascript">window.location.href = "../welcomeToTheManagerPortalPage.html";</script>';
            $conn = null;
        }
        //if the user does not exist, insert the user into the database and redirect to the login page
        else {
            $sql = "INSERT INTO employees (username, password) VALUES ('$username', '$password')";
            $conn->exec($sql);
            echo '<script language="javascript">alert("User created!");</script>';
            echo '<script language="javascript">window.location.href = "../welcomeToTheManagerPortalPage.html";</script>';
            $conn = null;
        }
    }
    
}
?>
</body>
</html>
