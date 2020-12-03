<?php
    $parse = fopen("input.txt", "r");

    //There are exactly 31 characters in each line.
    $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
    $cursor = 1;

    $hitatree = 0;
    while (!feof($parse)){
        $line = fscanf($parse, "%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c\n");
        $cursor +=5;

        if ($cursor >31){
            $cursor = $cursor % 31;
        }

        if (strcmp ($line[$cursor-1], "#") == 0)
        {
            $hitatree +=1;
        }
    }

    echo "\nhit a tree: " .  $hitatree;
    fclose ($parse);
?>