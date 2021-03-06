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

                array_multisort($tick->inputs);

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
    foreach ($tickets as $ticket){
        $errorcode = 0;

        //$display = false;
        foreach ($ticket->inputs as $section){
            if (count($highlighter[$section]->referenceRules)===0){
                $errorcode+=$section;
            }
        }
        if ($errorcode!==0){
            //unset($tickets[$ticket]);
            $counter+=$errorcode;
            //var_dump($errorcode);
        }
    }
    printf("Total error: %d", $counter);

    return;

?>