<?php

    function speak (&$array, &$lastelement, $counter)
    {
        if (array_search($lastelement, $array)===false)
        {
            if (array_search(0,$array)===false){
                $array[0]=$counter;
                $lastelement = 0;
            }
            else{
                $lastelement = $counter-$array[0];
                $array[$lastelement]=$counter;
                unset($array[0]);
            }
        }
        else {
            

            $lastnum = $array[$lastelement];
            unset($array[$lastelement]);
            $lastelement = $counter - $lastnum;
            $array[$lastelement]=$counter;
        }

    }

    //new attempt
    $inputs = array (0=>1, 3=>2, 6=>3);
    $lastelement = 6;

    $counter=3;

    while ($counter<10){
        $counter++;
        speak($inputs, $lastelement, $counter);
        var_dump($inputs);
    }

    var_dump($lastelement);

?>