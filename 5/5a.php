<?php
    //part 2
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
        public $row = -1;
        public $column = -1;
        public $seatID = -1;
    }
    function sortTicketsByID (&$tickets) { //Taught me about edge case for bubble sort 
        for ($x=0; $x<count($tickets); $x+=1){
            for ($y=1; $y<count($tickets); $y+=1){
                if ($tickets[$x]->seatID<=$tickets[$y]->seatID){
                    $temp = $tickets[$x];
                    $tickets[$x]=$tickets[$y];
                    $tickets[$y]=$temp;
                }
            }
        }
    }
    function findSelfID ($tickets){//Incorrect
        for ($x=1; $x<count($tickets)-1; $x+=1){
            if ($tickets[$x]->seatID==(($tickets[$x-1]->seatID)-1) && $tickets[$x]->seatID==(($tickets[$x+1]->seatID)+1)){
                echo "row: ";
                echo $tickets[$x]->row;
                echo " column: ";
                echo $tickets[$x]->column;
                echo " seatID: ";
                echo $tickets[$x]->seatID;
                echo "\n";
            }
        }
    }
    //Ticket ID somewhere between range of 510 and 615, 563 is incorrect
    function findSelfID2 ($tickets){
        for ($x=0; $x<count($tickets); $x+=1){
            if ($tickets[$x]->seatID > 510 && $tickets[$x]->seatID<615){
                echo "row: ";
                echo $tickets[$x]->row;
                echo " column: ";
                echo $tickets[$x]->column;
                echo " seatID: ";
                echo $tickets[$x]->seatID;
                echo "\n";
            }
        }
    }
    //Ticket ID somewhere between range of 510 and 615, 563 is incorrect
    function findSelfID3 ($tickets){
        for ($x=0; $x<count($tickets); $x+=1){
            if ($tickets[$x]->seatID > 510 && $tickets[$x]->seatID<615){
                if ($tickets[$x]->seatID==(($tickets[$x-1]->seatID)-1) && $tickets[$x]->seatID==(($tickets[$x+1]->seatID)+1)){
                    echo "row: ";
                    echo $tickets[$x]->row;
                    echo " column: ";
                    echo $tickets[$x]->column;
                    echo " seatID: ";
                    echo $tickets[$x]->seatID;
                    echo "\n";
                }
            }
        }
    }
    function findSelfID4 ($tickets){//cheesed, looked for the missing number
        for ($x=0; $x<count($tickets); $x+=1){
            if ($tickets[$x]->seatID > 605 && $tickets[$x]->seatID<615){
                echo "row: ";
                echo $tickets[$x]->row;
                echo " column: ";
                echo $tickets[$x]->column;
                echo " seatID: ";
                echo $tickets[$x]->seatID;
                echo "\n";
            }
        }
    }

    function findSelfIDProper ($tickets){
        $behind=$tickets[0];
        for ($x=1; $x<count($tickets); $x+=1){
            if ( ( $tickets[$x]->seatID - $behind->seatID) != 1)
            {
                echo "above: ";
                var_dump($tickets[$x]);
                echo "below: ";
                var_dump($behind);
            }
            $behind=$tickets[$x];
        }
    }

    $parse = fopen ("inputs.txt", "r");

    $max = -1;
    $min = 999;

    $tickets = array ();
    
    $read = fgets($parse);
    while (!feof($parse)){
        $ticket = new Tickets;
        
        $ticket->row = binaryRows(127,0, $read);
        $ticket->column = binaryColumns(7, 0, $read);
        $ticket->seatID = $ticket->row * 8 + $ticket->column;

        if ($max<=$ticket->seatID){
            $max=$ticket->seatID;
        }
        if ($min>=$ticket->seatID){
            $min=$ticket->seatID;
        }

        array_push($tickets, $ticket);
        $read = fgets($parse);
    }

    sortTicketsByID($tickets);

    //findSelfIDProper($tickets);
    echo "min: " . $min . " max: " . $max . "\n";
    echo "size: ". count($tickets);

    echo "\n0: ";
    var_dump($tickets[0]);
    echo "end: ";
    var_dump($tickets[count($tickets)-1]);

    fclose($parse);
?>