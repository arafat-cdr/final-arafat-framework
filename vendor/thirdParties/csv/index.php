<?php
exit();
# use this I tested it ....
# we are Good To go.....
require(__DIR__."/vendor/autoload.php");
$csvFile = new Keboola\Csv\CsvReader(__DIR__ . '/data/test_image_copy.csv',
1 // skip line one
);
foreach($csvFile as $row) {
$row = (object) $row;
    echo "<pre>";
    print_r($row);
    echo "</pre>";

}