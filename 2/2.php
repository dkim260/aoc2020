<?php

    function verify ($range1, $range2, $rule, $line){
        $counter = 0;

        for ($x =0; $x<strlen($line); $x+=1){
            if (strcmp($line[$x],$rule)==0){ //issue was that strcmp returns a range of values, I didn't specify it as 1 and thought it was a bool
                $counter += 1;
            }
        }
        //debugging:
        /*
        if( $counter >= $range1 && $counter <=$range2 ){
            printf("line: %s, rule: %s, counter: %d range1: %d, eval: %d", $line, $rule, $counter, $range1, ($counter >= $range1));
            printf(" counter: %d range2: %d, eval: %d\n", $counter, $range2, ($counter <= $range2));
        }*/

        return $counter >= $range1 && $counter <=$range2;
    }

    function verify2 ($index1, $index2, $rule, $line){
        return (strcmp($line[$index1-1], $rule)==0 || strcmp ($line[$index2-1], $rule)==0);
    }


    $counttrue = 0;

    $parse = fopen("input.txt", "r");
    $read = fscanf($parse, "%d-%d %c:%s\n");

    $range1 = $read[0];
    $range2 = $read[1];
    $rule = $read[2];
    $line = $read[3];

    while (!feof($parse)){    

        if (verify ($range1, $range2, $rule, $line)==true) //ran into an error where string comparisons weren't working
        {
            $counttrue+=1;
        }
        
        $read = fscanf($parse, "%d-%d %c:%s\n");

        $range1 = $read[0]; //throws an index out of bounds kind of error because fscanf is done parsing
        $range2 = $read[1];
        $rule = $read[2];
        $line = $read[3];
    }

    fclose($parse);
    echo $counttrue . "\n";

    //part 2
    $counttrue = 0;

    $parse = fopen("input.txt", "r");
    $read = fscanf($parse, "%d-%d %c:%s\n");

    while (!feof($parse)){ //this ordering fixes it
        $range1 = $read[0];
        $range2 = $read[1];
        $rule = $read[2];
        $line = $read[3];

        if (verify2 ($range1, $range2, $rule, $line)==true)
        {
            $counttrue+=1;
        }
        
        $read = fscanf($parse, "%d-%d %c:%s\n");
    }

    fclose($parse);
    echo $counttrue;


    


?>