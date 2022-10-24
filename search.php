<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>
    </head>
    <body>
        <h1>Search</h1>
            <p>
            <?php
            $dir    = '/tmp';
            $files1 = scandir($dir);
            echo $files1;
            ?>
        </p>
    </body>
</html>