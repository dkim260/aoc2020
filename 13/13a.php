<?php

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

    class bus { //Wonder if this is the right abstraction
        public $id;
        public $countx; //==1 if the next one is not an x
        public $next; //address
    }

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
    //The next time they will all meet is at $sequence[0] * $sequnce[1] * $sequnce[2] ....
    $meet = 1;
    foreach ($sequence as $bus){
        $meet *= $bus->id;
    }//Upper bound maybe?

    //var_dump($meet);

    //Plan:
    //start with sequence[0]. Double self until the next one is $sequence[1].
    //Keep track the distance
    //Find the next sequence.

    //Overwrite the distance
    //Double distance until the next condition

    //Condition: ( depart + countx ) % this->next->id == 0 

    $depart=0;
    $index=0;
    //Base case
    $distance=$sequence[$index]->id;

    $current = $sequence[$index];
    $depart+=$distance;
    $countx=$current->countx;

    while ($depart<$meet && $index<count($sequence)-1)
    {
        while (($depart + $countx) % $current->next->id != 0)
        {
            $depart+=$distance; //Something's not right here
        }
        var_dump($depart);
        $index++;
        $distance = $depart;
        $current = $sequence[$index];
        $countx+=$current->countx;
    }

    //var_dump($current);
    //var_dump($depart);

?>