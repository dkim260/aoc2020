<?php
    function binaryRows ($top, $bottom, $read){
        if ($read[0]=="F"){
            $top =  floor (($top +$bottom)/2);
        }
        else{
            $bottom = floor((($bottom + $top)/2)+0.5);
        }
        if ($read[1]=="F"){
            $top =  floor (($top +$bottom)/2);
        }
        else{
            $bottom = floor((($bottom + $top)/2)+0.5);
        }
        if ($read[2]=="F"){
            $top =  floor (($top +$bottom)/2);
        }
        else{
            $bottom = floor((($bottom + $top)/2)+0.5);
        }
        if ($read[3]=="F"){
            $top =  floor (($top +$bottom)/2);
        }
        else{
            $bottom = floor((($bottom + $top)/2)+0.5);
        }
        if ($read[4]=="F"){
            $top =  floor (($top +$bottom)/2);
        }
        else{
            $bottom = floor((($bottom + $top)/2)+0.5);
        }
        if ($read[5]=="F"){
            $top =  floor (($top +$bottom)/2);
        }
        else{
            $bottom = floor((($bottom + $top)/2)+0.5);
        }
        if ($read[6]=="F"){
            return $bottom;
        }
        else{
            return $top;
        }
    }
    function binaryColumns ($top, $bottom, $read){        
        if ($read[7]=="L"){
            $top = floor (($top +$bottom)/2);
        }
        else{
            $bottom = floor((($bottom + $top)/2)+0.5);
        }
        if ($read[8]=="L"){
            $top =  floor (($top +$bottom)/2);
        }
        else{
            $bottom = floor((($bottom + $top)/2)+0.5);
        }
        if ($read[9]=="L"){
            return $bottom;
        }
        else{
            return $top;
        }
    }
    class Tickets {
        public $max = -1;
        public $holder = array();
    }

    $parse = fopen ("inputs.txt", "r");

    $ticket = new Tickets;

    $read = fgets($parse);
    while (!feof($parse)){        
        $row = binaryRows(127, 0, $read);

        $top = 7;
        $bottom = 0;

        $column = binaryColumns(7, 0, $read);

        $seatID = $row * 8 + $column;
        if ($ticket->max<=$seatID){
            $ticket->max=$seatID;
        }
        array_push($ticket->holder, $seatID);
        $read = fgets($parse);
    }
    echo $ticket->max;

    fclose($parse);
?>