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

    //var_dump($data);

    bubbleCharger($data);
    setReferencesAndDistances($data);

    //Add last device
    $phone = new charger;
    $phone->jolts=($data[count($data)-1]->jolts)+3;
    $phone->prev=&$data[count($data)-1];
    $phone->distanceToPrev=3;

    array_push($data, $phone);

    //var_dump($data);

    $counter = bucketCount($data);
    //var_dump($counter);

    echo $counter[1]*$counter[3];
?>