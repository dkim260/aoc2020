<?php

    class num {
        public $age = array();
    }

    //expensive off by 1 error
    function speak (&$array, &$lastnumber, $counter){
        if (array_key_exists($lastnumber, $array) === false){//last number doesn't exist
            $array[$lastnumber] = new num;
            array_push($array[$lastnumber]->age, $counter-1);
            return 0;
        }
        else if ($lastnumber === 0){
            $difference = $counter - 1 - $array[0]->age[count($array[0]->age)-1]; //difference
            array_push($array[0]->age, $counter-1);
            return $difference;
        }
        else {
            $difference = $counter - 1 - $array[$lastnumber]->age[count($array[$lastnumber]->age)-1];
            array_push($array[$lastnumber]->age, $counter-1);
            return $difference;
        }
    }

    //0 3 6 0 3 3 1 0 4 0

            //v this 3 gets flagged, so how I'm handling starters is wrong...
    //0 3 6 0 3 0 1 0 1 1    
    //0 3 6 0 3 3 0 2 0 1

    //0 3 6 0 3 3 1 0 3 2
    //0 3 6 0 3 3 1 0 3 3
    //0 3 6 0 3 3 1 0 4 0

    /*
    $inputs = array (0=>new num,3=>new num,6=>new num);
    array_push($inputs[0]->age, 1);
    array_push($inputs[3]->age, 2);
    array_push($inputs[6]->age, 3);


    $lastnumber = 6;
    $counter=4;
    */
    
    
    //0 0 1 0 2 0 2 2 1 6
                  //v falls off here
    //0 0 1 0 2 0 2 1 4 0

    /*
    $inputs = array (0 => new num);
    array_push($inputs[0]->age, 1);
    $lastnumber=0;
    $counter=2;
    */

    $inputs = array (3 => new num, 1=>new num, 2=> new num);
    array_push($inputs[3]->age, 1);
    array_push($inputs[1]->age, 2);
    array_push($inputs[2]->age, 3);

    $counter = 4;
    $lastnumber = 2;

    //nightmare to set up********************
    /*
    $inputs = array (0 => new num, 1 => new num, 4=> new num, 13=> new num, 15=> new num, 12=> new num, 16=> new num);
    array_push($inputs[0]->age, 1);
    array_push($inputs[1]->age, 2);
    array_push($inputs[4]->age, 3);
    array_push($inputs[13]->age, 4);
    array_push($inputs[15]->age, 5);
    array_push($inputs[12]->age, 6);
    array_push($inputs[16]->age, 7);

    $counter = 8;
    $lastnumber = 16;
    */


    while ($counter<=2020){
        $lastnumber = speak($inputs, $lastnumber, $counter);
        $counter++;
    }

    var_dump($lastnumber);

?>