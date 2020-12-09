<?php

    class instruction {
        public $command;
        public $plusmin;
        public $value;
        public $visited=false;
    }
    function cloneDLL ($dll){
        $clonedll = new SplDoublyLinkedList();
        $dll->rewind();
        for ($x=0; $x<$dll->count(); $x++){
            $clonenode = clone $dll->current();
            $clonedll->push($clonenode);
            $dll->next();
        }
        $clonedll->rewind();
        return $clonedll;
    }

    function run ($insts, $iterator, &$acc) {
        while ($insts->valid()!=null){
            //var_dump($iterator);

            //if it's a jump and it's already been visited, return null for now
            if ($iterator->command=="jmp"){
                if ($iterator->visited==true){
                    return false;
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
                    return false;
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
                    return false;
                }
                $newnode = $iterator;
                $newnode->visited=true;
                $index=$insts->key();
                $insts->offsetSet($index, $newnode);
    
                $insts->next();
                $iterator = $insts->current();        
            }
        }

        return true; //got to the end of instructions
    }

    $parse = fopen("input.txt", "r");    
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
    $acc=0;
    $insts->rewind();
    $iterator = $insts->current();

    //Change jmps to nops
    while ($insts->valid()!=false){
        if ($iterator->command=="jmp"){
            //$instscopy = clone $insts; 
            //This doesn't create an entire copy, of the linkedlist, and what ends up happening is that 
            //the references still point to the original nodes

            $wherejmp = $insts->key();
            $instscopy = cloneDLL($insts); //Made my own

            $insts->rewind();
            for($x=0;$x<$wherejmp;$x++){
                $insts->next();
            }
            for($x=0;$x<$wherejmp;$x++){
                $instscopy->next();
            }
            $instscopy->key();
            $iterator = $instscopy->current();
            $iterator->command="nop";
            $instscopy->offsetSet($instscopy->key(),$iterator);

            $instscopy->rewind();
            $iterator = $instscopy->current();
            $acc=0;

            if (run($instscopy, $iterator, $acc)==true){
                echo $acc;
            }
        }

        //Move to the next nop
        $insts->next();
        $iterator = $insts->current();
        $acc=0;
    }
    //THANKFULLY JUST HAD TO CHANGE JMP TO NOP

?>