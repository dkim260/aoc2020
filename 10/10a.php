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

    //Chargers must be sorted
    function setReferencesAndDistances (&$chargers){
        for ($x=1; $x<count($chargers); $x++){
            $chargers[$x]->distanceToPrev=$chargers[$x]->jolts-$chargers[$x-1]->jolts;
            $chargers[$x]->prev=&$chargers[$x-1];
        }
    }

    //Will return an array containing the Key: jolt differences -> Value: # of chargers with jolt difference
    function bucketCount ($chargers){
        $bucket = array(1=>0,2=>0,3=>0);

        for ($x=1; $x<count($chargers); $x++){
            $index = $chargers[$x]->distanceToPrev;
            $bucket[$index]+=1;
        }

        return $bucket;
    }

    class charger {
        public $jolts;
        public $distanceToPrev;
        public $prev;
    }

    function dll($array){
        $arr = array();
        foreach ($array as $element){
            array_push($arr, $element);
        }
        return $arr;
    }

    function printArray ($array){
        foreach ($array as $entry){
            echo $entry . " ";
        }
        echo "\n";
    }

    /*Everything's already sorted, so..
    Start with the front. Add it to the head of empty permutations.
    While (charger array full)
    Dequeue the front of the charger array
    If the max index of placeholder joins to the dequeued value, push to permutations.    
    Do nothing otherwise*/

    //At the end of the loop:
    //the last one is the phone, echo the permutation, update the counter, echo the counter.
    
    function permutationSearch($data, $permutation, $end, &$counter){
        while ($data->isEmpty()!=true){
            $entry = $data->dequeue();
            $calcdistance = abs($permutation->offsetGet($permutation->count()-1) - $entry);
            if ($calcdistance<=3){
                $permutation->enqueue ($entry);
            }
            else{
                $data->dequeue();
            }
            permutationSearch ($data, $permutation, $end, $counter);    
        }
        if ($permutation[count($permutation)-1]==$end){
            printArray($permutation);
            $counter+=1;
        }
    }


    //Maybe do a tree instead and depth first
    class node {
        public $jolts;
        public $subkeys=array(); //Will hold references to other chargers **** at most 3
    }


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
    setReferencesAndDistances($data);

    //Add last device
    $phone = new charger;
    $phone->jolts=($data[count($data)-1]->jolts)+3;
    $phone->prev=&$data[count($data)-1];
    $phone->distanceToPrev=3;

    array_push($data, $phone);

    $counter = bucketCount($data);

    //echo $counter[1]*$counter[3];

    //Part 2*******
    //Push everything to a queue for now
    $data2 = new SplQueue;
    foreach ($data as $entry){
        $data2->enqueue($entry->jolts);
    }

    //var_dump($data2);
    // $start = $data[0];
    $end = $data[count($data)-1]->jolts;

    //Maybe it could be done without a search? 
    $permutation = new SplQueue();
    $permutation->enqueue($data2->dequeue());

    $counter=0;
    permutationSearch ($data2, $permutation, $end, $counter);
    echo $counter;
?>