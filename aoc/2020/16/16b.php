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

    //Sleep deprived chat with someone
    //Each value columnwise for the tickets should be unique?
    //Verify which rule(s?) works for a column
    //Go back to original idea of sort by column

    /*
    $failedcount = 0;
    for ($y = 0; $y < count($rules); $y++){

        $flag = false;
        $failed = array();
        for ($x = 0; $x < count($tickets); $x++){
            if (!(  ($tickets[$x][$y] >= $rules[$y]->lower1 &&  $tickets[$x][$y] <= $rules[$y]->upper1) ||  ($tickets[$x][$y] >= $rules[$y]->lower2 && $tickets[$x][$y] <= $rules[$y]->upper2)  )){
                $flag = true;
                //php arrays: only string or ints can be keys
                /*
                array_push($failed, $failed[$tickets[$x]]);
                $failed[$tickets[$x]]=$failed[$x][$y];
                */
                /*
                $failed[$x] = $tickets[$x][$y];
            }
        }

        if ($flag === false){
            printf("works\n");
        }

        else{
            //printf("fails\n");
            var_dump($failed);
            var_dump($y);
            var_dump($rules[$y]);
            $failedcount++;
        }
    }*/

    //Observations from above: Seems like it's only one ticket that will fail a rule
    //10 rules fail
    //Try swapping a rule with another and see the results
    //10! is significantly smaller than 20! for brute forcing at least for testing

    /*
    $order[0]=1;
    $order[1]=0;
    Fails 
    */

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

    $reductions = array();

    $failed = failedrules($order);

    function failedrules($order){
        global $rules, $tickets;
        $failed = array();

        foreach ($order as $y){
            for ($x = 0; $x < count($tickets); $x++){
                if (!(  ($tickets[$x][$y] >= $rules[$y]->lower1 &&  $tickets[$x][$y] <= $rules[$y]->upper1) ||  ($tickets[$x][$y] >= $rules[$y]->lower2 && $tickets[$x][$y] <= $rules[$y]->upper2)  )){
                    $failed[count($failed)] = $y;
                }
            }
        }
        return $failed;
    }

    function swapAndVerify ($holder){
        //swap order array with the new parts
        global $failed, $order;
        for ($x = 0; $x < count($holder); $x++){
            $order [$failed[$x]] = $holder[$x];
        }
        if (verify3($order)===true){
            var_dump($order);
            return true;
        }
        else{return;}
    }

    /*
    $counter=0;

    //Brute force the failed
    //10P10 is ~3million but the last time I tried this returns 600
    //Need to remember backtracking
    function bff ($holder, $carry){
        if (count($holder) === 10){
            swapAndVerify($holder);
            return;
        }
        else{
            foreach ($carry as $y){
                array_push($holder, $y);
                $filter = array_filter ($carry, fn ($x) => $x !== $y);
                bff($holder, $filter);
                global $counter;
                $counter++;
            }
        }
    }

    bff(array(), $failed);
    //Brute forcing ended up with 7million in the counter and none of them made the rules work.
    */

    //Threw in the towel
    //Some googling and I'm getting Heap's algorithm: https://en.wikipedia.org/wiki/Heap%27s_algorithm

    $length = count($failed);
    function heapsalgo ($k, $array){
        if ($k===1){
            swapAndVerify($array);
        }
        else{
            heapsalgo ($k-1, $array);

            for ($x = 0; $x< $k-1; $x++){
                if ($k % 2 === 0){
                    $temp = $array[$x];
                    $array[$x]=$array[$k-1];
                    $array[$k-1]=$temp;
                }
                else{
                    $temp = $array[0];
                    $array[0]=$array[$k-1];
                    $array[$k-1]=$temp;
                }

                heapsalgo ($k-1, $array);
            }
        }
    }
    heapsalgo($length-1, $failed);
    //Permutations here don't work.

    //Reddit thread says greedy, rule-index sieves

    

    return;
?>