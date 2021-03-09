<?php

    /*
    function array_mergecomb ($array1){
        $keys = array();
        for ($x=0; $x< array_key_last($array1); $x+=1){
            array_push($keys, $x);
        }
        $array1 = array_merge($array1, $array1);
        return array_combine($keys,$array1);
    }*/
    function printarr ($array1){
        for ($a=0; $a<array_key_last($array1); $a+=1){
            echo $array1[$a];
        }
        echo "\n";
    }

    function asarray ($array1){
        $arr = array();

        for ($a=0; $a<=array_key_last($array1); $a+=1){
            array_push($arr, $array1[$a]);
        }
        return $arr;
    }

    function array_double ($array1){
        $array2 = array();
        for ($a=0; $a<=array_key_last($array1)*2; $a+=1){
            $array2[$a]=$array1[$a%array_key_last($array1)];
        }
        return $array2;
    }

    $parse = fopen("input.txt", "r");
    $numoftrees=0;

    //Use some sort of 'cursor'
    $x=2;
    $y=3;

    //we know each line is length 31
    $linelength=31;
    //if x or y>linelength, concatenate the next line by overflow amount of times
    $overflow=0;

    //debugging:
    /*
    $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");    

    for ($a=0; $a<array_key_last($line); $a+=1){
        echo $line[$a];
    }
    echo "\n";

    $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");    

    for ($a=0; $a<array_key_last($line); $a+=1){
        echo $line[$a];
    }
    echo "\n";
    die();
    fclose($parse);
    */
    //inputs are working fine

    while (!feof($parse)){
        if ($x>=$linelength-1 || $y>=$linelength-1){
            $linelength+=31;
            $overflow+=1;
        }

        $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
        $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");

        //debugging
        fclose($parse);
        $line2 = $line;
        $line3 = array_double($line2);
        printarr($line3);
        die();

        //$read2 = $line[($y % 31)]; too naiive

        $line2 = $line;
        for ($a=0; $a<$overflow; $a+=1){
            $line2 = array_double($line2);
        }
        //printarr($line2);
        $read2 = $line2[$y];

        if (strcmp($read2, '#')==0){
            $numoftrees+=1;
        }
        
        $x+=3;
        $y+=3;
    }

    fclose($parse);
    echo $numoftrees;
?>