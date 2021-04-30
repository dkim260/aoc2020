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
        array_push($convert, $ticket->inputs);
    }

    $tickets = &$convert;
    array_unshift($tickets, $firstticket->inputs);

    //$tickets, $rules, 

    //Use an array to hold the order {1,2,3..20}
    $order = array();
    for ($x =0; $x< 20; $x++){
        array_push($order, $x);
    }

    function verify2($tickets, $order){
        global $rules;

        $count=0;

        //Tickets
        foreach ($tickets as $ticket){
            $x=0;

            //Order
            foreach ($order as $entry){

                //Verify against rule
                if (($ticket[$entry] >= $rules[$x]->lower1 && $ticket[$entry] <= $rules[$x]->upper1) === false){
                    if (($ticket[$entry] >= $rules[$x]->lower2 && $ticket[$entry] <= $rules[$x]->upper2) === false){

                        //New order?
                        //Foreach working
                            //try swap x
                            //Recurse
                        
                        printf("ticket:" );
                        var_dump($ticket);
                        printf("index: ");
                        var_dump($entry);
                        printf("portion:");
                        var_dump($ticket[$entry]);
                        printf("bounds:" );
                        var_dump($rules[$x]);
                        //return false;
                        $count++;
                    }    
                }
                $x++;
            }
        }
        //return true;
        var_dump($count);
    }
    
    verify2($tickets, $order);
    //Notes:
    //The regular order fails for 10 tickets
    //Find where first error happens
    //Swap with one that it works with fail

    return;
?>