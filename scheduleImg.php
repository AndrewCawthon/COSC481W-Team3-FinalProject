
<html>
    <head>
        <title>Employee Schedules</title>
        <link rel="stylesheet" href="./css/style.css">
    </head>
<?php
    //back button
    echo "<form action='welcomeToTheManagerPortalPage.html' method='post'>";
    echo "<input type='submit' name='back' value='Back'>";
    echo "</form>";

    //add a form to upload a new schedule image keeping the file name on upload
    echo "<form action='scheduleImg.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='file' name='file'>";
    //hide the "no file chosen" text
    echo "<style>input[type=file]::-webkit-file-upload-button {display: none;}</style>";
    echo "<br>";
    //add a text box to allow the user to name the file
    echo "<input type='text' name='filename' placeholder='File Name'>";
    echo "<input type='submit' name='submit2' value='Upload'>";
    echo "</form>";

    //if the upload button was pressed
    if (isset($_POST['submit2'])) {
        //get the file name from the form
        $file = $_FILES['file'];
        //get the file name from the form
        $filename = $_POST['filename'];
        //get the file extension
        $fileExt = explode('.', $file['name']);
        $fileActualExt = strtolower(end($fileExt));
        //set the file name to the name the user entered
        $fileNameNew = $filename.".".$fileActualExt;
        //set the file destination
        $fileDestination = './schedule_images/'.$fileNameNew;
        //move the file to the destination
        move_uploaded_file($file['tmp_name'], $fileDestination);
        //reload the page
        header("Location: scheduleImg.php?uploadsuccess");
    }

    //dropdown menu from which the user can select a schedule image to view from scheudle_iamges folder
    $dir = "./schedule_images/";
    $files = scandir($dir);
    echo "<form action='scheduleImg.php' method='post'>";
    echo "<select name='file'>";
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo "<option value='$file'>$file</option>";
        }
    }
    echo "</select>";
    echo "<input type='submit' name='submit' value='View'>";
    echo "</form>";
    if (isset($_POST['submit'])) {
        $file = $_POST['file'];
        echo "<img src='./schedule_images/$file'>";
    }

    //form to delete a schedule image
    echo "<form action='scheduleImg.php' method='post'>";
    echo "<select name='file2'>";
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo "<option value='$file'>$file</option>";
        }
    }
    echo "</select>";
    echo "<input type='submit' name='submit3' value='Delete'>";
    echo "</form>";
    if (isset($_POST['submit3'])) {
        $file = $_POST['file2'];
        unlink("./schedule_images/$file");
        header("Location: scheduleImg.php?deletesuccess");
    }


?>
</html>
