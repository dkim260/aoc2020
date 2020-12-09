<?php
    function bubblecheck ($queue) {
        for ($x=0; $x<count($queue)-1; $x+=1){
            for ($y=1; $y<count($queue)-1; $y+=1){
                if ($queue->offsetGet($x)+$queue->offsetGet($y)==$queue->offsetGet(5)) //Keep track of offset here
                {
                    return true;
                }
            }
        }
        return false;
    }
    function encweakness ($queue){
        $max=0;
        for ($x=0; $x<count($queue); $x++){
            if ($queue->offsetGet($x)>=$max){
                $max=$queue->offsetGet($x);
            }
        }

        $min=$max;
        for ($x=0; $x<count($queue); $x++){
            if ($queue->offsetGet($x)<=$min){
                $min = $queue->offsetGet($x);
            }
        }

        return $max-$min;
    }

    $parse = fopen("inputs.txt", "r");
    $rotator = new SplQueue;
    while (!feof($parse)){
        $input = (int)fgets($parse);
        $rotator->enqueue($input);
    }
    fclose($parse);

    $checker = new SplQueue;
    for ($x=0; $x<5; $x++){ //keep track of x here
        $checker->enqueue($rotator->dequeue());
    }
    $checker->enqueue($rotator->dequeue());

    while (!$rotator->isEmpty()){
        if(bubblecheck($checker)==false){
            echo $checker->top();
        }
        $checker->dequeue();
        $checker->enqueue($rotator->dequeue());
    }
    
    //part2:
    //must find a contiguous set of at least two numbers where the sum=50047984

    
?>