<?php
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

    $parse = fopen("input.txt", "r");
    $rotator = new SplQueue;
    while (!feof($parse)){
        $input = (int)fgets($parse);
        $rotator->enqueue($input);
    }
    fclose($parse);

    $checker = new SplQueue;
    for ($x=0; $x<25; $x++){
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

?>