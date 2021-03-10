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

    class ticket{
        public $inputs = array(); //array
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
    foreach ($rules as $rule){

    }

    //Or, maybe set up a graph and mark edges as visited
    

?>