<?php

    $parse = fopen("input.txt", "r");

    $earliestdep = (int)(fgets($parse));
    $busses = preg_split("[,]", fgets($parse));
    fclose($parse);

    //var_dump($busses);

    //Think this has to do with common multiples?
    $busses = array_filter($busses, fn ($x) => $x!='x');

    $busses = array_map(fn ($x) => (int)$x, $busses);
    array_multisort($busses, SORT_ASC);

    //var_dump($busses);

    //modulo departure time by busID
    //I think this represents the number of minutes before the departure.
    //For each busid, subtract the number of minutes from departuretime, add the busID and subtract the depart
    //Pick the lowest value

    $closest = array();
    foreach($busses as $bus){
        $mod = $earliestdep % $bus;
        array_push($closest, $earliestdep - $mod + $bus - $earliestdep);
    }

    $merge = array_combine($busses, $closest);

    //
    $minkey = $busses[count($busses)-1];
    $minvalue = $merge[$minkey];
    foreach ($busses as $bus){
        if ($merge[$bus]<=$minvalue){
            $minkey = $bus;
            $minvalue = $merge[$bus];
        }
    }

    printf("Bus id: %d, Minutes to wait: %d Multiplied: %d", $minkey, $minvalue, $minkey*$minvalue);

?>