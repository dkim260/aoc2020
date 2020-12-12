<?php
    class bag {
        public $color="";
        public $holds=1;
        public $otherBags = array();
    }
    function filterBags($string){
        return preg_replace("/bags|bag/", "", $string);
    }
    function filterSpaces ($string){
        $temp=preg_replace("/\s/", "", $string);
        return $temp;
    }
    function filterPeriods ($string){
        return preg_replace("/\./", "", $string);
    }

    function linearSearch (&$bag, $color){//Takes in an array of bags, find if colors (string) exists in array. Return the bag
        for ($x=0; $x<count($bag); $x+=1){
            if ($bag[$x]->color==$color){
                return $bag[$x];
            }
        }
        return null;
    }

    $goldBag = new bag; //Gold bag
    $goldBag->color ="shinygold";
    $goldBag->holds = 0;

    $carriage = array(); //Contains all bags

    $parse = fopen("input.txt", "r");
    $line = fgets($parse);
    while (!feof($parse)){
        $bagRule = new bag;
        if (preg_match("/no other bags/", $line)){
            $tempcolors = sscanf($line, "%s%s");
            $bagRule->color = $tempcolors[0] . $tempcolors[1];
            $bagRule->holds=0;
        }
        else
        {
            //filter inputs
            $toarray = preg_split("[contain]",$line);
            $bagRule->color=(filterSpaces(filterBags($toarray[0])));
            $removecommas = preg_split("[,]", $toarray[1]);

            foreach ($removecommas as $bag){
                $subBags = new bag;
                $rules = (sscanf(filterBags(filterPeriods($bag)), "%d%s%s"));
                $subBags->color=$rules[1].$rules[2];
                $subBags->holds=$rules[0];

                array_push($bagRule->otherBags, $subBags);
            }
        }
        array_push($carriage, $bagRule);
        $line = fgets($parse);
    }
    fclose($parse);

    //More filters
    //Find bags that contain gold bags and add them to hasGoldBag
    //Find bags that contain no bags and add them to a table
    //Find ambiguous bags
    $hasGoldBag = array();
    $hasNoBag = array();
    $ambiguousBags = array();
    for($x=0; $x<count($carriage); $x+=1)
    {
        if (count($carriage[$x]->otherBags)==0){
            array_push($hasNoBag, $carriage[$x]);
        }
        else
        {
            $count=0;
            foreach ($carriage[$x]->otherBags as $childBag){
                if ($childBag->color == "shinygold"){
                    array_push($hasGoldBag, $carriage[$x]);
                    $count+=1;
                }
            }
            if ($count==0){
                array_push($ambiguousBags, $carriage[$x]);
            }
        }
    }
    function getEntry (&$array, $search){//Look at array, and get the entry for search=another entry
        for ($x=0; $x<count($array); $x+=1){
            if($array[$x]->color==$search->color)
            {
                return $array[$x];
            }
        }
    }
    function removeEntry (&$array, $search){
        for ($x=0; $x<count($array); $x+=1){
            if($array[$x]->color==$search->color)
            {
                unset($array[$x]);
            }
        }

    }

    //gold bags is considered ambiguous, remove it
    removeEntry($ambiguousBags, $goldBag);
    $ambiguousBags=array_values($ambiguousBags);

    //var_dump(linearSearch($hasNoBag,"fadedblue"));

    //More filtering
    foreach ($ambiguousBags as $bag){
        foreach($bag->otherBags as $subbag){
            $test = linearSearch($ambiguousBags,$subbag->color);
            $test2 = linearSearch($hasGoldBag,$subbag->color);
            $test3 = linearSearch($hasNoBag,$subbag->color);
            if($test!=null){
                array_push($bag->otherBags, $test);
            }
            else if ($test2!=null){
                array_push($bag->otherBags, $test2);
            }
            else if ($test3!=null){
                array_push($bag->otherBags, $test3);

            }
        }
    }

    function deepBag (&$bag, &$truthy){
        if ($bag->color=="shinygold"){
            return $truthy||true;
        }
        else if (count($bag->otherBags)==0){
            return $truthy||false;
        }
        else{
            foreach ($bag->otherBags as $otherBag){
                deepBag($otherBag, $truthy);
            }
            return $truthy;
        }
    }


    var_dump(count($ambiguousBags));
    //$counter=count($hasGoldBag);


    $counter=0;
    foreach ($ambiguousBags as $bag){
        foreach($bag->otherBags as $subbag){
            $truthy=false;
            if (deepBag($subbag, $truthy)==true){
                $counter+=1;
            }
        }
    }
    echo $counter;

?>