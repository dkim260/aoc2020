<?php

    class spoke {
        public $value;
        public $lastTurn;
        public $spoke=false;
    }

    function speak ($nums, $counter){

    }

    $parse = fopen("inputs.txt", "r");

    $start = preg_split("[,]",fgets($parse));
    $start = array_map (fn ($x) => preg_replace("[\r\n]",'',$x), $start);

    fclose($parse);

    $nums = array();

    $count=1;
    foreach ($start as $num){
        $temp = new spoke;
        $temp->value=$num; 
        $temp->lastTurn=$count;

        array_push($nums, $temp);
        $count++;
    }
    var_dump($nums);

    $carriage = array();

    $lastspoke = &$nums[$count-1];
    if ($lastspoke->spoke===false){
//        array_push($carriage);

        $lastspoke->spoke=true;
    }

    while ($count<=2020){

        $count++;
    }

?>