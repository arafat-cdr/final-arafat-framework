<?php
function error_trace(){
    if(debug_backtrace()){

        echo "<style>
            .error_table {
              font-family: Arial, Helvetica, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }

            .error_table td, .error_table th {
              border: 1px solid red;
              padding: 8px;
            }

            .error_table tr:nth-child(even){background-color: #f2f2f2;}

            .error_table tr:hover {background-color: #ddd;}

            .error_table th {
              padding-top: 12px;
              padding-bottom: 12px;
              text-align: left;
              background-color: black;
              color: white;
            }
        </style>";

        echo "<table class='error_table'>";

        echo "<thead>";
        echo "<tr>";
        echo "<th>";
        echo "File Name";
        echo "</th>";
        echo "<th>";
        echo "Line Number";
        echo "</th>";
        echo "</tr>";
        echo "</thead>";
        foreach (debug_backtrace() as $k => $v) {

            echo "<tr>";

            echo "<td>";
            echo $v["file"];
            echo "</td>";

            echo "<td>";
            echo $v["line"];
            echo "</td>";

            echo "</tr>";
        }
        echo "</table>";
        die(1);
    }
}