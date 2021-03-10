<?php
    //keep ordered array entries as key: value
    //value is either null (because the entry doesn't exist), false, or integer

    function speak (&$array, &$lastspoken, $counter){ //returns elf speak
        if ($array[$lastspoken]===null){
            printf("new: %d\n",$lastspoken);
            $array[$lastspoken]=false;
        }
        else if ($array[$lastspoken]===false){
            printf("0\n");

            $lastspoken=0;
            if ($array[0]!==false){
                $array[$lastspoken]=false;
            }
            else{
                $array[$lastspoken]=$counter - $array[$lastspoken];    
            }
        }
        else {
            printf ("sub: %d difference: %d\n", $lastspoken, $counter-$array[$lastspoken]);
            $array[$lastspoken]=$counter-$array[$lastspoken];
            $lastspoken = $counter - $array[$lastspoken];
        }
    }

    class word{
        function __construct ($age){
            $this->age = array($age);
        }
    }

    function speak2 (&$array, &$lastspoken, $counter){
        printf("Counter: %d Last Spoken: %d\n", $counter, $lastspoken);
        if ($array[$lastspoken]==null){
            $array[$lastspoken] = new word ($counter);
        }
        

        if (count($array[$lastspoken]->age)==1){
            array_push($array[$lastspoken]->age, $counter);
            $lastspoken=0;
            printf("zero\n");
        }
        else{
            array_push($array[$lastspoken]->age, $counter);
            //oh man
            $lastspoken = $array[$lastspoken]->age[count($array[$lastspoken]->age)-1] - $array[$lastspoken]->age[count($array[$lastspoken]->age)-2];
            printf("last spoken: %d\n", $lastspoken);
        }

    }

    $inputs = array(0=>new word(1), 3=>new word(2), 6=>new word(3));

    $lastspoken = 6;
    
    $counter=count($inputs);
    while ($counter<10){
        $counter++;
        //var_dump($inputs);
        speak2($inputs, $lastspoken, $counter);
    }
    
    var_dump($lastspoken);

?>