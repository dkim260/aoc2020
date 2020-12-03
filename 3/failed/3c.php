<?php
    function printarr ($array1){
        for ($a=0; $a<=array_key_last($array1); $a+=1){
            echo $array1[$a];
        }
    }
    
    $parse = fopen("input.txt", "r");

    $length=31;

    $numoftrees=0;

    //there's 31 characters per line
    $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
    $cursor = 1;
    $old = $line[30];
    $linecounter = 1;

    $hitatree = "";
    $hitatreecounter=0;

    while (!feof($parse)){
        $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
        $cursor+=3;
        $cursor = $cursor % 31;

        //more debugging
        $linecounter+=1;
        echo " line #: ";
        echo $linecounter;

        if ($line == false)
        {
            fclose($parse);

            echo "\nnum hit a tree: ";
            echo $hitatreecounter;

            die();
        }

        //debugging


        echo " line: ";
        printarr($line);

        if ($cursor % 31 == 0){

            echo " hit base: " ;
            echo " char at cursor: ";

            $hitatree = $line[0];
            //maybe just add 1?
            echo $hitatree;
        }
        else{
            echo " regular: " ;

            echo " char at cursor: ";
            echo $line[$cursor-1];

            $hitatree = $line[$cursor-1];
        }
        echo " cursor: ";
        echo $cursor;

        if (strcmp ($hitatree, "#")==0){
            $hitatreecounter+=1;
        }

        echo "\n";        
    }        
?>