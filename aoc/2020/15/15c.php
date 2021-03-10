<?php

    class num{
        public $age = -1;
    }

    function speak(&$array, &$lastnumber, $counter){
        if (array_key_exists($lastnumber, $array) === false){//last number doesn't exist
            $array[$lastnumber] = new num;
            $array[$lastnumber]->age=$counter-1;
            return 0;
        }
        else if ($lastnumber === 0){
            $difference = $counter - 1 - $array[0]->age; //difference
            $array[0]->age = $counter-1;//should figure out what to do about here
            return $difference;
        }
        else {
            $difference = $counter - 1 - $array[$lastnumber]->age;
            $array[$lastnumber]->age=$counter-1;
            return $difference;
        }
    }

    /*
    $inputs = array (3 => new num, 1=>new num, 2=> new num);
    $inputs[3]->age=1;
    $inputs[1]->age=2;
    $inputs[2]->age=3;

    $counter = 4;
    $lastnumber = 2;
    */

    //nightmare to set up********************
    
    $inputs = array (0 => new num, 1 => new num, 4=> new num, 13=> new num, 15=> new num, 12=> new num, 16=> new num);
    $inputs[0]->age=1;
    $inputs[1]->age=2;
    $inputs[4]->age=3;
    $inputs[13]->age=4;
    $inputs[15]->age=5;
    $inputs[12]->age=6;
    $inputs[16]->age=7;

    $counter = 8;
    $lastnumber = 16;

    
    while ($counter<=30000000){//runs out of memory for old implementation in 15b.php
        //changed indices to not hold onto array values, but just one value and swap.
        //changed to 1024M memory in php.ini, there's probably a simpler solution.

        $lastnumber = speak($inputs, $lastnumber, $counter);
        $counter++;
    }

    var_dump($lastnumber);

?>