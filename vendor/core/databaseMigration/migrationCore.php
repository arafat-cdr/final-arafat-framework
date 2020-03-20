<?php

function cut_the_first_num($data){
    return preg_replace("/[0-9]+\)/", null, $data);
}

function run_the_migration(){
    $files = glob(DATABASE_PATH."/*.txt");
    $sql = NULL;
    // pr($files);
    if($files){
        foreach($files as $file_to_read){
            $file = fopen($file_to_read, "r") or exit("Unable to open file!");
            //Output a line of the file until the end is reached
            while(!feof($file))
              {
                 $line = cut_the_first_num( fgets($file) );
                 $line = trim($line);

                if( substr($line, 0, 6) == "table:" ){
                    if($sql){
                        $sql = rtrim($sql, ",");
                        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";

                        # Create the Table Dynamcally..
                        core_crud()->create_tbl($sql);
                    }
                    // echo $sql.str_repeat("<br/>", 5);
                    $table =  str_replace("table:", "", $line);
                    $table = trim($table);
                    // echo $table.str_repeat("<br/>", 5);
                    $sql = "CREATE TABLE IF NOT EXISTS {$table} (";
                }else{
                    // echo $line."<br/>";

                    $line = trim($line);
                    $fields = explode("-->", $line);
                    // pr($fields);

                    $field_name = $type = $length = $field_type = 0;
                    if( @count($fields) == 2 ){
                        $field_name = trim($fields[0]);
                        $field_type = trim($fields[1]);
                    }
                    // pr($field_type);

                    $type_length = explode(":", $field_type);
                    // pr($type_length);

                    if(@count( $type_length ) == 2){
                        $type = trim($type_length[0]);
                        $length = trim($type_length[1]);
                    }else if(@count( $type_length ) == 1){
                        $type = trim($type_length[0]);
                    }

                    /*echo "fields Name:-> ".$field_name." Type is -> ".$type." Length -> ".$length;
                    echo "<br/>";*/

                    if($type == "primary"){
                       $sql .= "{$field_name} INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
                    }else if( $field_name && $type ){
                        $type = strtoupper($type);

                        if($length){
                            $sql .= "{$field_name} {$type}({$length}) NULL,";
                        }else{
                            $sql .= "{$field_name} {$type} NULL,";
                        }

                    }

                }
              }
            fclose($file);

            # Now Move the File To the Done Folder..
           $file_name_is = str_replace(DATABASE_PATH."/", "", $file_to_read);

           $destination_path = DATABASE_PATH."/done/".$file_name_is;
          copy($file_to_read, $destination_path);
          unlink($file_to_read);

        }
    }
}