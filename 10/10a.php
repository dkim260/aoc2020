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
        public $chargersthatfit = array(); //Will hold references to other chargers **** at most 3

        function addSubCharger (&$subcharger) {//Input of type charger
            $difference = abs ($this->jolts - $subcharger->jolts);

            if (count($this->chargersthatfit) == 3){
                return;
            }
            else if ($difference > 3 || $difference < 1){
                return;
            }
            else{
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

    //Subreddit mentioned memoization and my memory of it from uni is hazy.
    //Write down the results somewhere and reuse.
    //Wikipedia said to use the most recent result that you stored somewhere.

    //Another way to think about it is:
    //Start with 1 charger, and you have 1 permutation.
    //Each layer you add, 


    $parse = fopen("inputs.txt", "r");

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

    /*
    for ($x=0; $x<count($data); $x++){
        if (count($data[$x]->chargersthatfit)>=1){
            $counter*=count($data[$x]->chargersthatfit);
        }
        else{
            $counter*=1;
        }
    }*/

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
    $index=0;
    while ($index<count($data)-1){
        $tempcount=0;
        for ($y=0; $y<count($data[$index]->chargersthatfit); $y++){
            $tempcount+=1;
        }
        $index+=$tempcount;
        $counter*=$tempcount;
    }
    echo $counter;

?>