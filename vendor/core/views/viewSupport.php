<?php
function view($view_file, $variables = array(), $print = true)
{
    # We are setting the Absulate Path here
    # Using Our Predefine Variables ....
    $filePath = VIEW_PATH."/".$view_file;
    $output = NULL;

    if( file_exists( $filePath ) ){
        // ----------------------------------------------
        // Extract the variables to a local namespace
        // This will extract the pass variable
        // ----------------------------------------------

        extract($variables);

        // Start output buffering
        ob_start();

        // Include the template file
        include( $filePath );

        // End buffering and return its contents
        $output = ob_get_clean();
    }else{
        dd("<p style='color: red;'>The view File -->> <strong> {$filePath} </strong> <<-- not Exist<p>");
    }

    # Now Printing the Out Put ....
    # The Out Put variable Printing the Wholw page
    # With It's variable ........

    if ($print) {
        # Here We will printin the Whole page with vars
        print $output;
    }
    return $output;
}