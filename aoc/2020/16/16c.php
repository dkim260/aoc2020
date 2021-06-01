<?php
    //switched to a mac, php installation via brew, xdebug via pecl and everything is running super smooth
    function array_has_null($array){
        foreach ($array as $a){
            if ($a===NULL){
                return true;
            }
        }
        return false;
    }

    class rule {
        public $lower1;
        public $upper1;

        public $lower2;
        public $upper2;
    }

    class node{
        public $start; //type of rule
        public $end;
        public $connections = array(); //holds edges
        public $connectVisits = array(); //holds number of visits from edges        

    }

    class ticket{
        public $inputs = array(); //array
    }

    class space {
        public $marks=0;
        public $referenceRules=array();
    }

    function verifyTicket (array $inputs){
        foreach ($inputs as $input){
            if ($input->marked==false){
                return False;
            }
        }
        return True;
    }

    //Array deep copy
    function deepcopy($array){
        $arrreturn = array();
        foreach ($array as $entry){
            array_push($arrreturn, $entry);
        }
        return $arrreturn;
    }

    $file = fopen("input.txt", "r");

    $rules=array();
    $tickets=array(); //$ticket[0] is your ticket

    $parse="";
    while ($parse!==false){
        $parse = fgets($file);

            if (preg_match("[or]", $parse)===1){
                $read = sscanf($parse, "%s %d-%d or %d-%d");                
                if (array_has_null($read)===true){
                    $read = sscanf($parse, "%s%s %d-%d or %d-%d");
                    $newrule = new rule;
                    $newrule->lower1 = intval($read[2]);
                    $newrule->upper1 = intval($read[3]);
                    $newrule->lower2 = intval($read[4]);
                    $newrule->upper2 = intval($read[5]);

                    array_push($rules, $newrule);
                }
                else{
                    $newrule = new rule;
                    $newrule->lower1 = intval($read[1]);
                    $newrule->upper1 = intval($read[2]);
                    $newrule->lower2 = intval($read[3]);
                    $newrule->upper2 = intval($read[4]);

                    array_push($rules, $newrule);
                }
                
                //array_push($rules, preg_)
            }
            else if (preg_match("[,]", $parse)===1){
                $tick = new ticket;

                foreach (preg_split("[,]", $parse) as $el){
                    array_push($tick->inputs, intval($el));
                }

                //array_multisort($tick->inputs);

                array_push($tickets, $tick);
            }
    }
    fclose($file);


    $firstticket = array_shift($tickets);
    $sectionscopy = $rules; //Don't know if it's a copy or reference

    $highlighter = array();
    for ($x=0; $x<1000; $x++){
        $highlighter[$x]=new space;
    }

    //Set up highlights
    foreach ($rules as $rule){
        for ($x=$rule->lower1; $x<=$rule->upper1; $x++){
            array_push($highlighter[$x]->referenceRules, $rule);
            $highlighter[$x]->marks++;
        }
        for ($x=$rule->lower2; $x<=$rule->upper2; $x++){
            array_push($highlighter[$x]->referenceRules, $rule);
            $highlighter[$x]->marks++;
        }
    }

    //What does this mean?

    //If highlighter[$section] rule references are empty, that's an invalid ticket?
    $counter = 0;

    $invticketcount=0;
    $validtickets = array();
    foreach ($tickets as $ticket){
        $errorcode = 0;

        //$display = false;
        foreach ($ticket->inputs as $section){
            if (count($highlighter[$section]->referenceRules)===0){
                $errorcode+=$section;
            }
        }
        if ($errorcode!==0){
            $counter+=$errorcode;
            $invticketcount++;
        }
        else{
            array_push($validtickets, $ticket);
        }
    }
    printf("Total error: %d\n", $counter);

    //Sanity check
    printf("Total tickets: %d, total invalid: %d, total valid: %d\n", count($tickets), $invticketcount, count($validtickets));

    //Clean
    unset($tickets);
    $tickets = &$validtickets;
    $counter=0;

    //Convert to 2d array
    $convert = array();
    foreach ($tickets as $ticket){
        if ($ticket->inputs[2]!==0){
            array_push($convert, $ticket->inputs);
        }
    }

    $tickets = &$convert;
    array_unshift($tickets, $firstticket->inputs);

    //$tickets, $rules, 

    //Use an array to hold the order {1,2,3..20}
    $order = array();
    for ($x =0; $x< 20; $x++){
        array_push($order, $x);
    }

    //Shorter version
    function verify3($order){
        global $rules, $tickets;

        foreach ($order as $y){
            for ($x = 0; $x < count($tickets); $x++){
                if (!(  ($tickets[$x][$y] >= $rules[$y]->lower1 &&  $tickets[$x][$y] <= $rules[$y]->upper1) ||  ($tickets[$x][$y] >= $rules[$y]->lower2 && $tickets[$x][$y] <= $rules[$y]->upper2)  )){
                    return false;
                }
            }
        }
        return true;
    }

    //Let's write down which rules parts of a ticket satisfies
    $satisfies = array();
    for ($x = 0; $x<count($tickets); $x++){
        $satisfies[$x] = array();
        for ($y = 0; $y< 20; $y++){
            $satisfies[$x][$y] = array();
            $z=0;
            foreach ($rules as $rule){
                $satisfies[$x][$y][$z] = array();
                if ($tickets[$x][$y] >= $rule->lower1 && $tickets[$x][$y]<= $rule->upper1){
                    array_push($satisfies[$x][$y][$z],"a");
                }
                if ($tickets[$x][$y] >= $rule->lower2 && $tickets[$x][$y]<= $rule->upper2){
                    array_push($satisfies[$x][$y][$z],"b");
                }
                $z++;
            }
        }
    }

    //x = ticket, y = entry, z = rules satisfied
    for ($x = 0; $x<count($satisfies); $x++){
        for ($y = 0; $y<20; $y++){
            for ($z = 0; $z< 20; $z++){
                if (count($satisfies[$x][$y][$z])===0){
                    printf($x . " ". $y . " ". $z . "\n");
                }
            }
        }
    }
    //on every ticket there is at least one entry-rule pair that doesn't work
    //ticket #27 entry 2 has the most incompatibilities?
    //it has an entry of 0, that was an oversight
    //made adjustments on line 160

    //Your ticket (#0) has the least incompatibilities on its own (it works with all tickets)

    //Based on the visualization I saw, it kind of looked like it was reducing entries and making some sort of staircase

    //on every ticket there is at most one entry-rule pair that doesn't work
    //Stack all the rules that don't work for each ticket column

    $fails = array();
    for ($x = 0; $x  < 20; $x++){
        $fails[$x]=array();
    }

    //x = ticket, y = entry, z = rules satisfied
    for ($x = 0; $x<count($satisfies); $x++){
        for ($y = 0; $y<20; $y++){
            for ($z = 0; $z< 20; $z++){
                if (count($satisfies[$x][$y][$z])===0){
                    array_push($fails[$y], $z);
                }
            }
        }
    }

    for ($x = 0; $x < count($fails); $x++){
        asort($fails[$x]);
    }

    //Need to rewrite this as a procedure

    function satisfies ($order){
        global $tickets, $rules;
        $satisfies = array();
        for ($x = 0; $x<count($tickets); $x++){
            $satisfies[$x] = array();
            for ($y = 0; $y< 20; $y++){
                $satisfies[$x][$y] = array();
                $z=0;
                foreach ($order as $orderrule){
                    $satisfies[$x][$y][$z] = array();
                    if ($tickets[$x][$y] >= $rules[$orderrule]->lower1 && $tickets[$x][$y]<= $rules[$orderrule]->upper1){
                        array_push($satisfies[$x][$y][$z],"a");
                    }
                    if ($tickets[$x][$y] >= $rules[$orderrule]->lower2 && $tickets[$x][$y]<= $rules[$orderrule]->upper2){
                        array_push($satisfies[$x][$y][$z],"b");
                    }
                    $z++;
                }
            }
        }
        return $satisfies;    
    }

    $test = satisfies($order);
    
    function fails ($satisfies){
        $fails = array();
        for ($x = 0; $x  < 20; $x++){
            $fails[$x]=array();
        }
    
        //x = ticket, y = entry, z = rules satisfied
        for ($x = 0; $x<count($satisfies); $x++){
            for ($y = 0; $y<20; $y++){
                for ($z = 0; $z< 20; $z++){
                    if (count($satisfies[$x][$y][$z])===0){
                        array_push($fails[$y], $z);
                    }
                }
            }
        }
        for ($x = 0; $x < count($fails); $x++){
            asort($fails[$x]);
        }    

        return $fails;
    }

    $test2 = fails($test);

    //Find max
    function findMax($array){
        $min = 0;
        $index = 0;
        foreach ($array as $entry){
            if (count($entry)>=$min){
                $min = count($entry);
                $index = array_search($entry, $array);
            }
        }
        return $index;
    }

    //Find to swap with
    function findSwap ($array){
        $find = array();
        for ($x = 0; $x<20; $x++){
            array_push($find, $x);
        }

        foreach ($array as $entry){
            unset($find[$entry]);
        }
        return $find;
    }

    $test3 = findMax($test2);
    $test4 = findSwap ($test2);

    /*
    //Modify orders
    $temp = $order[$y];
    $key = array_search($entry, $test2);
    $order[$key] = $temp;
    $order[$temp] = $key;
    $test = satisfies($order);
    $test2 = fails($test);
    */


    return;
?>
