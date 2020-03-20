<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home-View</title>
</head>
<body>
    <h3>I am Home View</h3>
    <ul>
        <li>Home</li>
        <li>Page</li>
        <li>View</li>
        <li>Is FOund</li>
        <li>Ok</li>
        <?php
            pr($data2);
            // pr($data2);
        ?>
        <?php
            foreach ($data2 as $key => $v) {
                echo "<li>".$v."</li>";
            }
        ?>

    </ul>
    <?php
        global $coreCrud;
        // pr($coreCrud);
    ?>
</body>
</html>