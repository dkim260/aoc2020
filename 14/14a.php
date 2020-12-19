<?php

    function applymask ($mask, $input){ //returns mask address of input address
        $binconv = decbin($input);
        $out = "";
        for ($x=0; $x<strlen($mask); $x++){
            if ($mask[$x]=="0"){
                if (strlen($mask)-$x>=0 && strlen($mask)-$x <=strlen($binconv)) //why
                {
                    $out = $out . $binconv[strlen($binconv)-(strlen($mask)-$x)];
                }
                else{
                    $out = $out . "0";
                }
            }
            else if ($mask[$x]=="1"){
                $out = $out . "1";
            }
            else{ //floating
                $out = $out . "X";
            }
        }
        return $out;
    }

    function writeValues ($mask, $value, &$memory){ //writes values into memory using a floating mask
        if (strpos($mask,"X")==false){
            $memory[$mask]=(int)$value;
        }
        else{ //read too much of the reddit thread
            $xpos = strpos($mask, "X");
            $masksub = $mask;
            $masksub[$xpos]="0";
            writeValues($masksub, $value, $memory);

            $masksub[$xpos]="1";
            writeValues($masksub, $value, $memory);
        }
    }

    function memSum ($array){ //reduces array
        $sum = 0;
        foreach ($array as $element){  
            if (is_float($sum)){
                printf("overflow\n");
            }

            $sum+=$element;
        }
        return $sum;
        //return array_reduce($array, fn ($carry, $x) => $carry + $x , 0);
    }

    $parse = fopen ("input.txt", "r");

    $line = fgets($parse);
    $mask; $write;
    $memory = array();

    while (!feof($parse)){
        if ($line[0]=="m" && $line[1]=="a"){
            $mask = sscanf($line, "mask = %s")[0];
        }
        else {
            $write = sscanf($line, "mem[%d] = %d"); //Had a bit of confusion here, thought the values being written were in binary
            $addresses = applymask($mask, $write[0]);
            //printf("mask:\t\t%s\naddress:\t%s\naddressbin:\t\t\t%s\nmaskedaddress:\t%s\nvalue:\t%s\n", $mask, $write[0], decbin($write[0]), $addresses, $write[1]);

            writeValues ($addresses, $write[1], $memory);
        }
        $line = fgets($parse);
    }
    fclose($parse);

    var_dump(count($memory));

    var_dump (memSum($memory));

?>