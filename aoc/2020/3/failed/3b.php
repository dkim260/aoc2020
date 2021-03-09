<?php
    function printarr ($array1){
        for ($a=0; $a<array_key_last($array1); $a+=1){
            echo $array1[$a];
        }
    }

    /*
    function shallowcopy ($array){
        $newarray = array();
        foreach ($array as $element){
            array_push($newarray, $element);
        }
        return $newarray;
    }*/

    $parse = fopen("input.txt", "r");

    $length=31;

    $numoftrees=0;

    $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
    $y=1;    //cursor
    $counter=1; //line counter

    $holderline = $line; //off by one error

    while (!feof($parse)){
        //there's 32 characters, not 31
        $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
        $y+=3;
        $counter+=1;

        if ($line == false){
            fclose($parse);
            echo $numoftrees;
            die();
        }
        else
        {
            $charaty = "";
            echo " y: " . $y;
            if (($y%32)-1 < 0){ //holy moly
                $charaty=$holderline[31];
                echo " indexa: ". (($y%32)-1);
            }
            else{
                $charaty = $line[($y%32)-1];
                echo " indexb: ". (($y%32)-1);
            }

            //debugging:
            echo " line #: ". $counter;
            echo " line: ";
            if (($y%32)-1 < 0){ //holy moly
                echo " holder: ";
                printarr($holderline);
            }
            else{
                printarr($line);
            }
            echo " charat: " . $charaty;  
            echo " num of trees: " . $numoftrees;
            echo "\n";

            if (strcmp($charaty,"#")==0){
                echo "flagged\n";
                $numoftrees+=1;
            }
            $holderline = $line;
        }
    }
?>