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

    function linearSearch ($bag, $color){//Takes in an array of bags, find if colors (string) exists in array
        for ($x=0; $x<count($bag); $x+=1){
            if ($bag[$x]->color==$color){
                return true;
            }
        }
        return false;
    }

    $goldBag = new bag; //Gold bag
    $goldBag->color ="shinygold";
    $goldBag->holds = 0;

    $carriage = array(); //Contains all bags

    $parse = fopen("input.txt", "r");
    while (!feof($parse)){
        $line = fgets($parse);
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
    // var_dump($hasGoldBag);
    // var_dump($hasNoBag);
    // var_dump($ambiguousBags);
    function getEntry (&$array, $search){//Look at array, and get the entry for search=another entry
        for ($x=0; $x<count($array); $x+=1){
            if($array[$x]->color==$search->color)
            {
                return $array[$x];
            }
        }
    }
    // var_dump($ambiguousBags);
    // $var = $ambiguousBags[2]->otherBags; //2->1 child is vibrant plum
    // $vartest = $ambiguousBags[4]; //4 -- vibrantplum
    // var_dump(getEntry($var, $vartest));
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

    function modifySelf ($array){
        global $hasGoldBag;
        global $ambiguousBags;
        global $hasNoBag;

        foreach ($array as $entry){
            echo "childcolor: " . $entry->color . ": contains: ";
            if (getEntry($hasGoldBag, $entry)!=null){ //The color contains a gold bag
                echo "Gold bag ";
            }
            else if (getEntry($hasNoBag, $entry)!=null){ //The color contains no bag
                echo "No bag ";
            }
            else
            {
                array_push($entry->otherBags , (getEntry($ambiguousBags, $entry))   ); //
                modifySelf($entry->otherBags);
            }
        }
    }

    foreach ($ambiguousBags as $bag){
        echo "\nambiguous entry color: " . $bag->color . "\n";
        modifySelf ($bag->otherBags);
    }

?>