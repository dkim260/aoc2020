<?php
    function printarr ($array1){
        for ($a=0; $a<array_key_last($array1); $a+=1){
            echo $array1[$a];
        }
    }


    $parse = fopen("input.txt", "r");
    $length=31;

    $numoftrees=0;

    //cursor
    $y=3;

    $counter=0;
    while (!feof($parse)){
        $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
        $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
        $counter+=2;

        if ($line == false){ //error handling lol
            fclose($parse);
            echo $numoftrees;
            die();
        }
        else
        {
            
            $charaty = $line[($y%31)-1];
            
            //debugging:
            if ($counter<100){
                echo "line #: ". $counter;
                echo " line: ";
                printarr($line);
                echo " y: " . $y . " ymod31: " . ($y%31);
                echo " charat: " . $charaty;                
                echo " num of trees: " . $numoftrees;
                echo "\n";
            }

            if (strcmp($charaty,"#")==0 && $counter<100){
                echo "flagged\n";
                $numoftrees+=1;
            }    
            $y+=3;
        }
    }
?>