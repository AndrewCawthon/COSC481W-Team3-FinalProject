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
        <form class="form" id="loginForm" method="post" action="adminLogin.php">
            <h1 class="page_title">Admin Login Portal</h1>
            <input type="password" class="form__input" id="employeeID" name="employeeID" autofocus="" placeholder="Admin ID"> <br><br>
            <input type="text" class="form__input" id="username" name="username" autofocus="" placeholder="Username"> <br><br>
            <input type="password" class="form__input" id="password" name="password" autofocus="" placeholder="Password"> <br><br>
            <input type="submit" id="login" name="login" class="inputStyle" value="LogIn"> <br><br>   
            <a href="ResetPassword.html" class="form__link">Forgot your password?</a> <br><br>
            <!--<a class="form__link" href="firstLogIn.html" id="linkFirstTime">First Time User?</a><br> <br>-->
            <!--<a class="form__link" href="adminLogIn.html" id="linkAdminLogin">Admin Login</a>-->
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

ini_set('display_errors', 1);

//check if the login button was pressed
if (isset($_POST['login'])) {
    //code to get the username, id, and password from the form 
    $employeeID = $_POST['employeeID'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    //check if the username ID and password are in the admins table
    $sql = "SELECT * FROM admins WHERE adminID = '$employeeID' AND admin_username = '$username' AND admin_password = '$password'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //if the username, id, and password are in the admins table
    if ($result) {
        //set the session variable to the employeeID
        $_SESSION['employeeID'] = $employeeID;
        //redirect to the admin home page
        header("Location: welcomeToTheManagerPortalPage.html");
        echo "<script>alert('Login Successful');</script>";
    }
    //if the username, id, and password are not in the admins table
    else {
        //redirect to the employee login page
        header("Location: index.php");
        echo "<script>alert('Incorrect Username, ID, or Password');</script>";
    }    
}
?>
</body>
</html>

