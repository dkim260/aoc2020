<?php

    class bus {
        public $id;
        public $index;
        public $next;
    }




    $parse = fopen("input.txt", "r");
    fgets($parse);
    $busses = preg_split("[,]", fgets($parse));
    fclose($parse);
    $busses = array_map(fn ($x) => preg_replace("/\n/","",$x), $busses);
    $busses = array_map((function ($x){
        if ($x!="x"){
            return (int)$x;} 
        else {
            return $x;
        }
    }),$busses);

    $sequence = array();

    for ($x=0; $x<count($busses); $x++){
        if ($busses[$x]!="x"){
            $bussa = new bus;
            $bussa->id = $busses[$x];
            $bussa->index=$x;
            
            array_push($sequence, $bussa);
        }
    }

    for ($x=0; $x<count($sequence)-1; $x++){
        $sequence[$x]->next=$sequence[$x+1];
    }
    
    //var_dump($sequence);

    //(departure + lastindex) % lastbusid == 0

    //Work backwards?
    //Keep adding the multiple of the lastbusid until previous busid fits

    $departure = 1;
    foreach ($sequence as $bus){
        $departure *= $bus->id;
    }

    //var_dump($departure);

    //brute force
    function validate ($number, $sequence){
        foreach ($sequence as $bus){
            if ((($number + $bus->index) % $bus->id) != 0){
                return false;
            }
        }
        return true;
    }

    /*
    for ($x=0; $x<$departure; $x++){
        if (validate($x, $sequence)==true){
            var_dump($x);
        }
    }*/

    /*
    for ($x=0; $x<$departure; $x+=$sequence[0]->id){
        if (validate($x, $sequence)==true){
            var_dump($x);
        }
    }
    */

    //Some sort of sieve?
    //Push all the multiples of sequence[0] into an array until the ceiling
    //-----   Ran out of memory with a naiive implementation -----

?>