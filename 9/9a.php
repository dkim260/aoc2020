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

    function queueSum ($queue){
        $sum=0;
        for ($x=0; $x<count($queue); $x++){
            $sum+=$queue->offsetGet($x);
        }
        return $sum;
    }

    function contigSum ($data, $workingdata, $goal){ //Think this one through more
        if (queueSum($workingdata)==$goal){
            var_dump($workingdata);
            return;
        }

        else{
            if ($data->isEmpty()){
                echo "Empty";
                die();
            }
            else
            {
                $workingdata->enqueue($data->dequeue());
                foreach ($data as $entry){
                    $workingdata->enqueue($entry);
                    contigSum($data, $workingdata, $goal);
                }               
                printf("Sum: %d\n", queueSum($workingdata)); 
                echo "failed\n";
                return;
            }
        }
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
            $error=$checker->top();
        }
        $checker->dequeue();
        $checker->enqueue($rotator->dequeue());
    }
    
    //part2:
    //must find a contiguous set of at least two numbers where the sum=50047984, for inputs.txt=127

    $parse = fopen("inputs.txt", "r");
    $rotator = new SplQueue;
    while (!feof($parse)){
        $input = (int)fgets($parse);
        $rotator->enqueue($input);
    }
    fclose($parse);

    //$error=127, 50047984
    $check = new SplQueue;
    contigSum($rotator, $check, $error);

?>