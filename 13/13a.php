<?php

    class bus { //Wonder if this is the right abstraction
        public $id;
        public $countx; //==1 if the next one is not an x
        public $next; //address
    }


    $parse = fopen("inputs.txt", "r");
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

    //var_dump($busses);

    //Need to find time stamp that fits the sequence

    $sequence = array();

    $iterator = 0;

    $bussa = new bus;
    $bussa->id = $busses[$iterator];
    $bussa->countx=1;
    $iterator+=1;

    while ($iterator <= count($busses)){
        while ($busses[$iterator]=="x"){
            $bussa->countx+=1;
            $iterator+=1;
        }
        array_push($sequence, $bussa);

        $bussa = new bus;
        $bussa->id = $busses[$iterator];
        $bussa->countx=1;
        $iterator+=1;
    }

    //var_dump($sequence);

    //set references
    for ($x=0; $x<count($sequence)-1; $x++){
        $sequence[$x]->next=$sequence[$x+1];
    }

    //var_dump($sequence);
    
    //All busses depart at 0.
    //The next time they will all depart at the same time is at $sequence[0] * $sequnce[1] * $sequnce[2] ....
    $meet = 1;
    foreach ($sequence as $bus){
        $meet *= $bus->id;
    }//Upper bound maybe?

    //var_dump($meet);

    //Attempt
    //Condition: ( depart + countx ) % this->next->id == 0 
    //Doesn't work
    //I thought that if you keep doubling the departure time then the xcounts would align / scale linearly
    //77, 78 
    //78*10-1%7 != 0
    //77*10+1%13 != 0 

    //7 * 13 = 91
    //91 - 13 = 78

    //Find the third departure as if there were no xs
    /*
    for ($runner=1; $runner<=5369; $runner++){
        if ((($runner+2) % 59 == 0) && (($runner+1)%13==0) && ($runner%7==0))
        {
            printf($runner);
        }
    }*/
    //0, 77, 4718

    //Find the third departure as if there are xs
    /*
    for ($runner=1; $runner<=714924299; $runner++){
        if ((($runner+4) % 59 == 0) && (($runner+1)%13==0) && ($runner%7==0))
        {
            var_dump($runner);
            break;
        }
    }*/
    //0, 77, 350
    
    //(departure + lastindex) % lastbusid == 0

?>