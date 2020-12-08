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

    $parse = fopen("inputs.txt", "r");
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

    var_dump($ambiguousBags);

    function lookupByNode (&$array, $node){//Get an array, return the entry that has the node color
        $color = $node->color;
        for ($x = 0; $x< count($array); $x+=1){
            if ($array[$x]==$color){
                return $array[$x];
            }
        }
    }

    var_dump(lookupByNode ($carriage, $ambiguousBags[0]));

    /*
    function linearAppend (&$bag){//take in a bag rule
        global $hasGoldBag;
        global $hasNoBag;
        global $ambiguousBags;
        while (count($bag->otherBags)!=0){
            $otherBagChild = array_shift($bag->otherBags);

            if (linearSearch($hasGoldBag, $otherBagChild->color)){ //Found a gold bag
                echo "1 ";
            }
            else if (linearSearch($hasNoBag, $otherBagChild->color)){ //Found no bag
                echo "0 ";
            }
            else
            {
                var_dump(lookupByNode($ambiguousBags,$otherBagChild));
                return;
                //array_unshift($bag->otherBags, lookupByNode($ambiguousBags,$otherBagChild));
                linearAppend($otherBagChild); //If this keeps looping, something went wrong.
            }
        }
        echo "\n";
    }

    foreach ($ambiguousBags as $bag){
        $results = array();
        linearAppend ($bag, $results);
        //echo $results . "\n";
    }*/

?>