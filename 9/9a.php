<?php
    function encweakness ($queue){
        var_dump($queue);

        $max=0;
        for ($x=0; $x<count($queue); $x++){
            if ($queue->offsetGet($x)>=$max){
                $max=$queue->offsetGet($x);
            }
        }
        printf("Max: %d", $max);
        $min=$max;
        for ($x=0; $x<count($queue); $x++){
            if ($queue->offsetGet($x)<=$min){
                $min = $queue->offsetGet($x);
            }
        }
        printf(" Min: %d\n", $min);

        return $max+$min;
    }
    function cloneQueue ($dll){
        $clonedll = new SplQueue();
        $dll->rewind();
        for ($x=0; $x<$dll->count(); $x++){
            $clonenode = clone $dll->current();
            $clonedll->push($clonenode);
            $dll->next();
        }
        $clonedll->rewind();
        return $clonedll;
    }
    function queueSum ($queue){
        $sum=0;
        for ($x=0; $x<count($queue); $x++){
            $sum+=$queue->offsetGet($x);
        }
        return $sum;
    }

    function bubblecheck ($queue) {
        for ($x=0; $x<count($queue)-1; $x+=1){
            for ($y=1; $y<count($queue)-1; $y+=1){
                if ($queue->offsetGet($x)+$queue->offsetGet($y)==$queue->offsetGet(25))
                {
                    return true;
                }
            }
        }
        return false;
    }

    function wtf ($rotator, &$min, &$max, $error){            
        for ($x=0; $x<count($rotator); $x++){
            for ($y=0; $y<count($rotator->offsetGet($x)->valuesArray); $y++){
                if ($rotator->offsetGet($x)->valuesArray[$y]==$error){
                    printf("Min Index: %d Max Value: %d\n", $y, $rotator->offsetGet($x)->value);

                    $min=$y;
                    $max=$x;

                    return;
                }
            }
        }
    }

    class entry {
        public $value;
        public $valuesArray = array();
    }

    $parse = fopen("input.txt", "r");
    $rotator = new SplQueue;
    while (!feof($parse)){
        $input = (int)fgets($parse);
        $rotator->enqueue($input);
    }
    fclose($parse);

    $checker = new SplQueue;
    for ($x=0; $x<25; $x++){ //************************CHANGE THIS BACK TO 25 */
        $checker->enqueue($rotator->dequeue());
    }

    $checker->enqueue($rotator->dequeue());
    while (!$rotator->isEmpty()){
        if(bubblecheck($checker)==false){
            $error=$checker->top();
        }
        $checker->dequeue();
        $checker->enqueue($rotator->dequeue());
    }
    
    //part2:
    //must find a contiguous set of at least two numbers where the sum=50047984, for inputs.txt=127

    $parse = fopen("input.txt", "r");
    $rotator = new SplQueue;
    while (!feof($parse)){
        $input = (int)fgets($parse);
        $ent = new entry();
        $ent->value=$input;
        $rotator->enqueue($ent);
    }
    fclose($parse);

    //$error=127, 50047984

    //last element should be the number at the index
    //Each entry will grow 1, 2, 3, 4
    //Think of it as
    //1
    //1 1 
    //1 1 1
    //1 1 1 1
    //Each row uses previous rows entries
    array_push($rotator->offsetGet(0)->valuesArray,($rotator->offsetGet(0)->value));

    for ($x=1; $x<count($rotator); $x++){ //n^2 rip
        //This is a bit toxic
        for ($y=0; $y<count($rotator->offsetGet($x-1)->valuesArray); $y++){
            array_push($rotator->offsetGet($x)->valuesArray, $rotator->offsetGet($x)->value + $rotator->offsetGet($x-1)->valuesArray[$y]);
        }
        array_push($rotator->offsetGet($x)->valuesArray, $rotator->offsetGet($x)->value);
    }

    $min=0;
    $max=0;

    wtf($rotator, $min, $max, $error);
    printf("min: %d max: %d", $min, $max);
    //Massage queue:
    $massage = new SplQueue;
    for ($x=$min; $x<$max; $x++){
        $massage->enqueue($rotator->offsetGet($x)->value);
    }
    echo encweakness($massage);

?>