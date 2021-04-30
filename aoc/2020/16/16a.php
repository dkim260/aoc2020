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


    //I want to roll out the bounds like a piece of string
    //Or, maybe set up a graph and mark edges as visited

    //Old approach won't work, can't split the rules into two pieces
    //$sections = array();
    //It would work if you set a reference point

    //Remove first ticket, we can use it as a test variable
    $firstticket = array_shift($tickets);
    $sectionscopy = $rules; //Don't know if it's a copy or reference

    //Naiive
    //Would have issues, because some combinations would work while others won't.
    //So some backtracking might be required?
    /*
    foreach ($firstticket->inputs as $input){
        foreach ($sectionscopy as $section){
            if ($section->marked==false){
                //Check boundaries
                if ( ($input<=$section->upper1 && $input>=$section->lower1) || ($input<=$section->upper2 && $input>=$section->lower2)){
                    $section->marked=true;
                    unset($sectionscopy[$section]);
                }
            }
        }  
    }
    */

    //Some sort of tree?
    //Some sort of subsets?
    
    //Create a 2d array/checkerboard and highlight ranges?
    //Does it have to be a 2d array?
    //Going to take up a lot of space probably, whoops

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

    //Mark sections ticket fulfills
    /*
    foreach ($firstticket->inputs as $section){
        $highlighter[$section]->visits++;
        array_push($highlighter[$section]->visitors, $section);
    }
    */

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
        array_push($convert, $ticket->inputs);
    }
    $tickets = &$convert;

    array_unshift($tickets, $firstticket->inputs);

    //maybe sort based off the highest high, and lowest low ticket? ticket with the largest range?

    //Look for the least flexible ticket? the most flexible?

    //$rules, $tickets

    //Something I'm seeing while I'm highlighting ticket values is that some values are repeated in other tickets
    //Maybe put them in a map for now?
    //Expression: pair?
    //Is this a boolean satisfiability kind of thing?

    //Use an array to hold the order {1,2,3..20}
    $order = array();
    for ($x =0; $x< 20; $x++){
        array_push($order, $x);
    }

    //Array deep copy
    function deepcopy($array){
        $arrreturn = array();
        foreach ($array as $entry){
            array_push($arrreturn, $entry);
        }
        return $arrreturn;
    }

    //check ticket[order] -> rule[0,1,2,...19] is satisfied
    //This function wasn't correct
    /*
    function verify ($tickets, $order){
        global $rules;

        //Tickets
        foreach ($tickets as $ticket){
            $x=0;

            //Order
            foreach ($order as $entry){
                //Verify the rule
                /* if (){return true;} */
                /*
                if (($ticket[$entry] >= $rules[$x]->lower1 && $ticket[$entry] <= $rules[$x]->upper1 || $ticket[$entry] >= $rules[$x]->lower2 && $ticket[$entry] <= $rules[$x]->upper2) === false){
                    return false;
                }
                $x++;
            }
        }
        return true;
    }
    */

    //Some temporary idea / guess for now
    //Ticket by ticket, try sorting by value
    
    function bsort (&$array, &$array2){
        //Count should be 20?
        for ($x = 0; $x< count($array); $x++){
            for ($y = $x+1; $y<count($array); $y++){
                if ($array[$x]> $array[$y]){
                    //Swap
                    $temp = $array[$x];
                    $array[$x] = $array[$y];
                    $array[$y] = $temp;

                    $temp = $array2[$x];
                    $array2[$x] = $array2[$y];
                    $array2[$y] = $temp;
                }
            }
        }
    }
    //Then do something with the rules?
    //Sort rules by upper1 ascending?
    
    //try each ticket
    /*
    for ($x = 0; $x< count($tickets); $x++){
        $temparr = (deepcopy($tickets[$x]));
        $temporder = deepcopy ($order);

        //bsort($temparr, $temporder);
    }
    */
    

    //Currently the above isn't working
    //Try brute force:
    //20! = ~5 quintillion...
    /*
    function permutations ($orderholder, $inputs){
        global $tickets;
        if (count($orderholder)===20){
            if (verify($tickets, $orderholder) === true){
                var_dump($inputs);
            }
            else{
                $orderholder;
            }
            return;
        }
        else{
            foreach ($inputs as $input){
                if (array_search($input,$orderholder)===false){
                    $temp = deepcopy($orderholder);
                    array_push($temp, $input);
                    $temp2 = deepcopy($inputs);
                    array_unshift($temp2);
                    permutations($temp, $temp2);    
                }
            }
        }
    }
    permutations(array(), $order);
    //Yeahhh that's not happening
    */

    //Some values are repeated
    //Can we group those somehow?
    /*
    $bucket = array();
    foreach ($tickets as $ticket){
        foreach ($ticket as $value){
            if (key_exists($value, $bucket)){
                $bucket[$value]=$bucket[$value]+1;
            }
            else{
                $bucket[$value]=1;
            }    
        }
    }
    ksort($bucket);
    var_dump($bucket);
    */

    return;
?>