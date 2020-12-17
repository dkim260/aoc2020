<?php
    //Dec 17 - Threw in towel: people mentioned sieves and crt
    //https://www.reddit.com/r/adventofcode/comments/kc4njx/2020_day_13_solutions/gfncyoc/?utm_source=reddit&utm_medium=web2x&context=3
    //main takeaways: study the input, think on relations between variables longer + don't give up

    class bus { //Wonder if this is the right abstraction
        public $id;
        public $countx; //==1 if the next one is not an x
        public $next; //address
        public $index;
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

    $iterator = 0;

    $bussa = new bus;
    $bussa->id = $busses[$iterator];
    $bussa->countx=1;
    $bussa->index=0;
    $iterator+=1;

    while ($iterator <= count($busses)){
        while ($busses[$iterator]=="x"){
            $bussa->countx+=1;
            $iterator+=1;
        }
        array_push($sequence, $bussa);

        $bussa = new bus;
        $bussa->id = $busses[$iterator];
        $bussa->index=$iterator;
        $bussa->countx=1;
        $iterator+=1;
    }

    //set references
    for ($x=0; $x<count($sequence)-1; $x++){
        $sequence[$x]->next=$sequence[$x+1];
    }

    $meet = 1;
    foreach ($sequence as $bus){
        $meet *= $bus->id;
    }

    //var_dump($sequence);

    function validate ($number, $sequence){
        foreach ($sequence as $bus){
            if ((($number + $bus->index) % $bus->id) != 0){
                return false;
            }
        }
        return true;
    }

    $depart = 0;
    $step = $sequence[0]->id;
    $countx = $sequence[0]->countx;

    $index=1;
    while ($depart <= $meet && $sequence[$index]->next->id!=null){
        if (($depart + $sequence[$index+1]->index) % $sequence[$index+1]->id == 0) { //multiply the step
            //printf("Before: Depart: %d, Step: %d, Countx: %d Index: %d Sequencex+1: %d\n", $depart, $step, $countx, $index, $sequence[$index+1]->id);
            $index++;
            $step *= $sequence[$index]->id;
            $countx = $sequence[$index]->countx;
            //printf("After: Depart: %d, Step: %d, Countx: %d Index: %d Sequencex+1: %d\n", $depart, $step, $countx, $index, $sequence[$index+1]->id);
        }
        $depart += $step;
    }

    while (validate ($depart, $sequence) != true){
        $depart += $step;
    }
    printf("Start at: %d", $depart);
?>