<htmL>
    <body>
        <?php
        //display the image from the scheudle_images folder based on the inputted image in the HTML form
        $files = glob("schedule_images/*.*");
        for ($i=1; $i<count($files); $i++)
        {
            $num = $files[$i];
            print $num."<br />";
            echo '<img src="'.$num.'" alt="random image" />'."<br /><br />";
        }
        ?>
    </body>
</htmL>