<?php

    class instruction {
        public $command;
        public $plusmin;
        public $value;
        public $visited=false;
    }

    function run (&$insts, &$iterator, &$acc) {
        while ($insts->valid()!=null){
            //if it's a jump and it's already been visited, return null for now
            if ($iterator->command=="jmp"){
                if ($iterator->visited==true){
                    return;
                }
                $newnode = $iterator;
                $newnode->visited=true;
                $index=$insts->key();
                $insts->offsetSet($index, $newnode);
    
                //Do something about the jump
                if ($iterator->plusmin=="+"){
                    $countx=$iterator->value;
                    for ($x=0; $x<$countx; $x+=1){
                        $insts->next();
                        $iterator = $insts->current();    
                    }
                }
                else{
                    $countx=($iterator->value)*-1;
                    for ($x=0; $x<$countx; $x+=1){
                        $insts->prev();
                        $iterator = $insts->current();    
                    }
                }
            }
            else if ($iterator->command=="acc"){
                if ($iterator->visited==true){
                    echo "ping";
                    return;
                }
    
                $acc+=$iterator->value;
    
                $newnode = $iterator;
                $newnode->visited=true;
                $index=$insts->key();
                $insts->offsetSet($index, $newnode);
    
                $insts->next();
                $iterator = $insts->current();        
            }
            else{//NOP
                if ($iterator->visited==true){
                    if ($iterator->value!=0){
                        $newnode = $iterator;
                        $iterator->command="jmp";
                        $newnode->visited=false;
                        $index=$insts->key();
                        $insts->offsetSet($index, $newnode);

                        //Refresh the list.
                        $insts->rewind();
                        $iterator = $insts->current();
                        while ($insts->valid()!=null){
                            $iterator->visited=false;
                            $insts->next();
                        }
                        $acc=0;
                    
                        //Rerun it again
                        $insts->rewind();
                        $iterator = $insts->current();

                        run($insts, $iterator, $acc);

                        //It didn't work.
                        echo "failed";
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                $newnode = $iterator;
                $newnode->visited=true;
                $index=$insts->key();
                $insts->offsetSet($index, $newnode);
    
                $insts->next();
                $iterator = $insts->current();        
            }
        }

        return $acc; //it worked
    }

    $parse = fopen("inputs.txt", "r");    
    $line = fgets($parse);
    //Learning something new each day :)
    $insts = new SplDoublyLinkedList;
    $insts->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);

    $start = new instruction;
    $insts->push($start);

    $split = preg_split("/\s/",$line);    
    $start->command = $split[0];
    if (($split[1])[0]=="+"){
        $start->plusmin="+";
        $start->value=(int)((preg_split("/\+/", $split[1]))[1]);
    }
    else{
        $start->plusmin="-";
        $start->value=((int)preg_split("/\-/", $split[1])[1]) * -1;
    }
    $line = fgets($parse);
    while (!feof($parse))
    {
        $split = preg_split("/\s/",$line);

        $node = new instruction;
        $insts->push($node);

        $node->command = $split[0];
        if (($split[1])[0]=="+"){
            $node->plusmin="+";
            $node->value=(int)((preg_split("/\+/", $split[1]))[1]);
        }
        else{
            $node->plusmin="-";
            $node->value=((int)preg_split("/\-/", $split[1])[1]) * -1;
        }
    
        $line = fgets($parse);
    }
    fclose($parse);

    $acc=0;
    $insts->rewind();
    $iterator = $insts->current();

    //Part 2: Have to either change a single NOP <-> JMP statement to end the program.
    echo run($insts, $iterator, $acc);


?>