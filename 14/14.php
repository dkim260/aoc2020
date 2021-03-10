<?php

    function applymask ($mask, $input){ //returns value of input with mask applied
        $binconv = decbin($input);
        $out = "";
        for ($x=0; $x<strlen($mask); $x++){
            if ($mask[$x]=="0"){
                $out = $out . "0";
            }
            else if ($mask[$x]=="1"){
                $out = $out . "1";
            }
            else if (strlen($mask)-$x>=0 && strlen($mask)-$x <=strlen($binconv)) //why
            {
                $out = $out . $binconv[strlen($binconv)-(strlen($mask)-$x)];
            }
            else{ //x
                $out = $out . "0";
            }
        }
        return $out;
    }

    function binarySum ($array){ //takes an input of binary numbers and reduces to the sum
        return array_reduce($array, fn ($carry, $x) => $carry + bindec($x) , 0);
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
            $write = sscanf($line, "mem[%d] = %d");
            //printf("mask:\t%s\nnum:\t%s\nnumbin:\t%s\nconvert:%s\n", $mask, $write[1], decbin($write[1]), applymask($mask, $write[1]));
            $memory[$write[0]] = applymask($mask,$write[1]);
        }
        $line = fgets($parse);
    }
    fclose($parse);

    //var_dump($memory);

    var_dump (binarySum($memory));

?>