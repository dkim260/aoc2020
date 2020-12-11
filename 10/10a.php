<?php
    //Super naiive, probably best to add it into a tree of some sort
    function bubbleCharger (&$chargers) {
        for ($x=0; $x<count($chargers); $x++){
            for ($y=$x+1; $y<count($chargers); $y++){
                if ($chargers[$x]->jolts>=$chargers[$y]->jolts){
                    $temp = $chargers[$x];
                    $chargers[$x]=$chargers[$y];
                    $chargers[$y]=$temp;
                }
            }
        }
    }

    class charger {
        public $jolts;
        public $holds=0;
        //Counts how many chargers fit it
        public $chargersthatfit = array(); //Will hold references to other chargers **** at most 3
        public $chargersthatfitself = array();
        public $otherconnections=0;

        function addSubCharger (&$subcharger) {//Input of type charger
            $difference = abs ($this->jolts - $subcharger->jolts);

            if (count($this->chargersthatfit) == 3){
                return;
            }
            else if ($difference > 3 || $difference < 1){
                return;
            }
            else{
                $this->holds+=1;
                array_push($this->chargersthatfit, $subcharger);
            }
        }

    }

    /* can't think of an algorithm...
    function printPermutations ($chargers){
        echo $chargers[0]->jolts . " ";
        foreach ($chargers[0]->chargersthatfit as $charger){
            echo $charger->jolts . " ";
        }
        array_shift($chargers);
        if (count($chargers)!=0){
            printPermutations($chargers);
        }
        else{
            echo "\n";
            return;
        }
    }*/

    //Solution's fine with smaller n
    function generator ($node, &$counter, $max){
        if($node->jolts==$max){
            //echo $node->jolts;
            $counter++;
            //echo "\n";
        }
        else if ($node!=null){
            //echo $node->jolts . " ";
        }
        else{
            return;
        }

        foreach ($node->chargersthatfit as $charger){
            generator($charger, $counter, $max);
        }
    }

    //Another attempt...
    //Modified to chargers to show how many it holds explicitly

    //the last node / the phone charger should hold how many references lead to it.
    /*
    function generator2 ($node, $data, $max){
        if ($node->jolts==0){
            
        }
        else if ($node->jolts!=$max){
            for ($x=0; $x<count($node->chargersthatfit); $x++){
                //$node->chargersthatfit[$x]->holds*=;
            }
        }
        else//($node->jolts==$max)
        {
            echo $node->holds;
        }

    }
    */

    //Subreddit mentioned memoization and my memory of it from uni is hazy.
    //Write down the results somewhere and reuse.
    //Wikipedia said to use the most recent result that you stored somewhere.
    //Start from the last charger?
    //Start from the last charger and move backwards from n, n-1, n-2... 1
    //The first charger will have at most 3
    //The last charger will have at most 1
    function generator2 ($data, $index, $max){
        if($data[$index]->jolts==$max){
            $data[$index]->otherconnections++;
            return generator2($data, $index-1, $max);
        }
        else if ($data[$index]->jolts==0){ //Going to be a maximum of three.
            foreach ($data[$index]->chargersthatfit as $charger){
                $data[$index]->otherconnections+=$charger->otherconnections;
            }
            return $data[$index]->otherconnections;
        }
        else if ($data[$index]!=null){ //Going to be a maximum of three.
            foreach ($data[$index]->chargersthatfit as $charger){
                $data[$index]->otherconnections+=$charger->otherconnections;
            }
            return generator2($data, $index-1, $max);
        }
        else{//Something went wrong!
            return;
        }
    }

    $parse = fopen("input.txt", "r");

    $data = array();

    while (!feof($parse)){
        $line = fgets($parse);
        $charge = new charger;
        $charge->jolts = (int)$line;
        array_push($data, $charge);
    }
    //The last one will be the wall
    fclose($parse);

    bubbleCharger($data);

    //Add last device
    $phone = new charger;
    $phone->jolts=($data[count($data)-1]->jolts)+3;
    array_push($data, $phone);

    //Part 2
    //Data already holds new chargers
    //Everything is sorted already.

    //Add the references
    for($x=0; $x<count($data)-3; $x+=1){
        for ($y=1; $y<4; $y++){
            $data[$x]->addSubCharger($data[$x+$y]);
        }
    }
    //Manually check the third last and second last
    $data[count($data)-3]->addSubCharger($data[count($data)-2]);
    $data[count($data)-3]->addSubCharger($data[count($data)-1]);

    $data[count($data)-2]->addSubCharger($data[count($data)-1]);
    
    //What now?
    $counter=1;
    //generator($data[0], $counter, $phone->jolts);

    //Attempt
    /*
    for ($x=0; $x<count($data)-1; $x++){
        $counter*=count($data[$x]->chargersthatfit);
    }

    echo $counter ."\n";
    */

    //$counter=1;
    //root
    //we know how many elements there are in its sub array
    //skip that many in a loop
    //counter *= how many
    //move to the highest of the bunch

    //count the next layer

                    //branch
                    // ->
                    //\\branch
               //branch                   \
    //Start->   branch                         ->End
    //         \\branch

    /*

    //Another way to think about it is:
    //Start with 1 charger, and you have 1 permutation.
    //Each layer you add, 

    //... work backwards?


    $index=0;
    while ($index<count($data)-1){
        $tempcount=0;
        for ($y=0; $y<count($data[$index]->chargersthatfit); $y++){
            $tempcount+=1;
        }
        $index+=$tempcount;
        $counter*=$tempcount;
    }
    echo $counter;*/

    //echo generator2($data[0], $data, $data[count($data)-1]);

    //echo $data[count($data)-1];

    //var_dump($data[count($data)-1]);

    echo generator2($data, count($data)-1, $data[count($data)-1]->jolts);

?>
