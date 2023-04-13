<html>
    <title>All Employees</title>
    <body>
        <form action="../welcomeToTheManagerPortalPage.html" method="post">
            <input type="submit" name="back" value="Back">
        </form>
        <form action="viewEmployees.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="submit" name="delete" value="Delete">
        </form>
    </body>
</html>
<?php
$conn = new PDO("sqlsrv:server = tcp:test-server-seniorproject.database.windows.net,1433; Database = test", "mainLogin", "AdminUser42!");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM employees";

//run the query and display the results in a table
$result = $conn->query($sql);
echo "<table border='1'>";
echo "<tr><th>Employee ID</th><th>Username</th><th>Password</th></tr>";
foreach ($result as $row) {
    echo "<tr><td>".$row['employeeID']."</td><td>".$row['username']."</td><td>".$row['password']."</td></tr>";
}
echo "</table>";

//if the delete button was pressed
if (isset($_POST['delete'])) {
    //code to get the username from the form
    $username = $_POST['username'];

    //code to delete the username from the database
    $sql = "DELETE FROM employees WHERE username = '$username'";
    $result = $conn->query($sql);
    //reload the page
    header("Location: viewEmployees.php");
}

?>
