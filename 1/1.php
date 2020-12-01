<?php
    $inputarr = array();
    $inputcount = 0;

    //file handling
    $input = fopen("input.txt", "r") or die ("unable to read file");

    $readinputs = fscanf($input, "%d\n");
    while (!feof($input)){
        list ($num) = $readinputs;        
        array_push($inputarr, $num);
        $readinputs = fscanf($input, "%d\n");
        $inputcount +=1;
    }

    fclose($input);

    //part1
    /*
    for ($xcount = 0; $xcount< $inputcount-1; $xcount+=1){
        for ($ycount = 1; $ycount < $inputcount; $ycount +=1){
            if ($inputarr[$xcount]+$inputarr[$ycount]==2020)
            {
                echo $inputarr[$xcount]*$inputarr[$ycount];
                die();
            }
        }
    }*/

    //part2
    for ($xcount = 0; $xcount< $inputcount-2; $xcount+=1){
        for ($ycount = 1; $ycount < $inputcount-1; $ycount +=1){
            for ($zcount = 2; $zcount < $inputcount; $zcount +=1){
                if ($inputarr[$xcount]+$inputarr[$ycount]+$inputarr[$zcount]==2020)
                {
                    echo "x: ".$inputarr[$xcount]." y:".$inputarr[$ycount]." z:".$inputarr[$zcount]."\n";
                    echo "multiply: " .$inputarr[$xcount]*$inputarr[$ycount]*$inputarr[$zcount];
                    die();
                }
            }
        }
    }

?>