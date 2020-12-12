<?php
    class bag {
        public $color="";
        public $otherBags = array();
        public $otherBagsCounter = array();
    }
    function filterSpaces ($string){
        $temp=preg_replace("/\s/", "", $string);
        return $temp;
    }
    function filterPeriods ($string){
        return preg_replace("/\./", "", $string);
    }
    function filterBags($string){
        return preg_replace("/bags|bag/", "", $string);
    }
    function linearSearch (&$bag, $color){//Takes in an array of bags, find if colors (string) exists in array. Return the bag
        for ($x=0; $x<count($bag); $x+=1){
            if ($bag[$x]->color==$color){
                return $bag[$x];
            }
        }
        return null;
    }

    function deepBag ($bag){
        if ($bag->color=="shinygold"){
            return true;
        }
        else if(count($bag->otherBags)==0){
            return false;
        }
        else{
            $truthy = false;
            foreach ($bag->otherBags as $subbag){
                $truthy = $truthy || deepBag ($subbag);
            }
            return $truthy;
        }
    }

    //Part 2
    function deepBag2 ($bag, $otherBagsCount){
        if (count($bag->otherBags)==0){
            printf("no other bags bagcolor: %s\n", $bag->color);
            return 0; //This thing... grrr set it as a 1 and it caused problems
        }
        else{
            $counter=0;
            for($x=0; $x<count($bag->otherBags); $x++){
                printf("curent bag: %s other bag: %s, bag count: %d counter: %d\n", $bag->color, $bag->otherBags[$x]->color, $otherBagsCount[$x],$counter);
                $counter+=$otherBagsCount[$x]; 
                $counter+=$otherBagsCount[$x]*deepBag2($bag->otherBags[$x], $bag->otherBags[$x]->otherBagsCounter);
                printf("counter: %d\n", $counter);
            }
            return $counter;
        }
    }

    $goldBag = new bag; //Gold bag
    $goldBag->color ="shinygold";

    $carriage = array(); //Contains bags that may or may not contain shiny gold bags
    $nosubbags = array(); //Contains bags that contain no other bags

    $parse = fopen("input.txt", "r");
    $line = fgets($parse);
    while (!feof($parse)){
        $bagRule = new bag;
        if (preg_match("/no other bags/", $line)){
            $tempcolors = sscanf($line, "%s%s");
            $bagRule->color = $tempcolors[0] . $tempcolors[1];
            array_push($nosubbags, $bagRule);
        }
        else
        {
            //filter inputs
            $toarray = preg_split("[contain]",$line);
            $bagRule->color=(filterSpaces(filterBags($toarray[0])));
            if ($bagRule->color!="shinygold"){
                $removecommas = preg_split("[,]", $toarray[1]);

                foreach ($removecommas as $bag){
                    $subBags = new bag;
                    $rules = (sscanf(filterBags(filterPeriods($bag)), " %d%s%s"));
                    $subBags->color=$rules[1].$rules[2];

                    array_push($bagRule->otherBagsCounter, $rules[0]);
                    array_push($bagRule->otherBags, $subBags);
                }
                array_push($carriage, $bagRule);
            }
            else{ //Part 2
                $removecommas = preg_split("[,]", $toarray[1]);
                foreach ($removecommas as $bag){
                    $subBags = new bag;
                    $rules = (sscanf(filterBags(filterPeriods($bag)), " %d%s%s"));
                    $subBags->color=$rules[1].$rules[2];

                    array_push($goldBag->otherBagsCounter, $rules[0]);
                    array_push($goldBag->otherBags, $subBags);
                }
            }
        }
        $line = fgets($parse);
    }
    fclose($parse);

    //set references
    foreach ($carriage as $bag){
        $referenceCarriage = array();
        foreach ($bag->otherBags as $subbag){
            $test1 = linearSearch ($carriage, $subbag->color);
            $test2 = linearSearch ($nosubbags, $subbag->color);

            if ($test1 != null){
                array_push($referenceCarriage, linearSearch($carriage, $subbag->color));
            }
            else if ($test2 != null){
                array_push($referenceCarriage, linearSearch($nosubbags, $subbag->color));
            }
            else{
                array_push($referenceCarriage, $goldBag);
            }
        }
        $bag->otherBags = $referenceCarriage; //Makes me nervous as hell
    }
    //var_dump($carriage);

    //Part 1!
    $counter=0;
    foreach ($carriage as $bag){
        if (deepBag($bag)==true){
            $counter+=1;
        }
    }
    //echo $counter;

    //part 2
    //Need to add the references to gold bag
    $referenceCarriage = array();
    foreach ($goldBag->otherBags as $subbag){
        $test1 = linearSearch ($carriage, $subbag->color);
        $test2 = linearSearch ($nosubbags, $subbag->color);
        if ($test1 != null){
            array_push($referenceCarriage, linearSearch($carriage, $subbag->color));
        }
        else if ($test2 != null){
            array_push($referenceCarriage, linearSearch($nosubbags, $subbag->color));
        }
        else{
            array_push($referenceCarriage, $goldBag);
        }
    }
    $goldBag->otherBags=$referenceCarriage;

    echo deepBag2($goldBag, $goldBag->otherBagsCounter);
    echo "\n";
?>