<?php
    class word{
        public $age;
        public $spoken=false;
    }

    function speak (&$array){ //returns elf speak
        if ($array[count($array)-1]->spoken==false){
            return 0;
        }
        else {
            $array[$array[count($array)-1]->age]->age = count($array) - $array[count($array)-1]->age;
            return $array[count($array)-1]->age;
        }
    }

    //

    $inputs = [0,3,6];

    //$inputs = [0,1,4,13,15,12,16];

    //var_dump($inputs);

    $counter=0;

    $words = array();

    while ($counter<2020){
        $counter++;
    }


?>