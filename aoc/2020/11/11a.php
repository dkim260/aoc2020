<?php
    class seat {
        public $x;
        public $y;
        public $state;
        public $nextstate;

        public $right;
        public $left;
        public $top;
        public $bottom;

        public $topright;
        public $topleft;
        public $bottomleft;
        public $bottomright;

        function assignx($x){
            $this->x=$x;
        }
        function assigny($y){
            $this->y=$y;
        }
        function assignstate ($state){
            $this->state=$state;
        }

        static function getSeat (&$seats, $getx, $gety){
            try {            
                set_error_handler(function (){return null;});
                $x=$seats[$getx][$gety];
                return $x;
            }
            catch (ErrorException $error){
                return null;
            }
        }

        function readyNextState (){
            if ($this->state=="L"){
                $truthy = true;

                //Got hard to debug Dx
                $right = $this->right;
                while ($right->state!=null && $right->state=="."){
                    $right = $right->right;
                }
                if($right->state=="#"){
                    $truthy=false;
                }

                $left = $this->left;
                while ($left->state!=null && $left->state=="."){
                    $left = $left->left;
                }
                if($left->state=="#"){
                    $truthy=false;
                }

                $top = $this->top;
                while ($top->state!=null && $top->state=="."){
                    $top = $top->top;
                }
                if($top->state=="#"){
                    $truthy=false;
                }

                $bottom = $this->bottom;
                while ($bottom->state!=null && $bottom->state=="."){
                    $bottom = $bottom->bottom;
                }
                if($bottom->state=="#"){
                    $truthy=false;
                }

                $topright = $this->topright;
                while ($topright->state!=null && $topright->state=="."){
                    $topright = $topright->topright;
                }
                if($topright->state=="#"){
                    $truthy=false;
                }

                $topleft = $this->topleft;
                while ($topleft->state!=null && $topleft->state=="."){
                    $topleft = $topleft->topleft;
                }
                if($topleft->state=="#"){
                    $truthy=false;
                }

                $bottomleft = $this->bottomleft;
                while ($bottomleft->state!=null && $bottomleft->state=="."){
                    $bottomleft = $bottomleft->bottomleft;
                }
                if($bottomleft->state=="#"){
                    $truthy=false;
                }

                $bottomright = $this->bottomright;
                while ($bottomright->state!=null && $bottomright->state=="."){
                    $bottomright = $bottomright->bottomright;
                }
                if($bottomright->state=="#"){
                    $truthy=false;
                }

                if ($truthy==true){
                    $this->nextstate="#";
                }
            }
            if ($this->state=="#"){
                $counter=0;

                $right = $this->right;
                while ($right->state!=null && $right->state=="."){
                    $right = $right->right;
                }
                if ($right->state=="#")
                {
                    $counter+=1;
                }

                $left = $this->left;
                while ($left->state!=null && $left->state=="."){
                    $left = $left->left;
                }
                if ($left->state=="#")
                {
                    $counter+=1;
                }

                $top = $this->top;
                while ($top->state!=null && $top->state=="."){
                    $top = $top->top;
                }
                if ($top->state=="#")
                {
                    $counter+=1;
                }

                $bottom = $this->bottom;
                while ($bottom->state!=null && $bottom->state=="."){
                    $bottom = $bottom->bottom;
                }
                if ($bottom->state=="#")
                {
                    $counter+=1;
                }

                $topleft = $this->topleft;
                while ($topleft->state!=null && $topleft->state=="."){
                    $topleft = $topleft->topleft;
                }
                if ($topleft->state=="#")
                {
                    $counter+=1;
                }

                $topright = $this->topright;
                while ($topright->state!=null && $topright->state=="."){
                    $topright = $topright->topright;
                }
                if ($topright->state=="#")
                {
                    $counter+=1;
                }

                $bottomleft = $this->bottomleft;
                while ($bottomleft->state!=null && $bottomleft->state=="."){
                    $bottomleft = $bottomleft->bottomleft;
                }
                if ($bottomleft->state=="#")
                {
                    $counter+=1;
                }
                
                $bottomright = $this->bottomright;
                while ($bottomright->state!=null && $bottomright->state=="."){
                    $bottomright = $bottomright->bottomright;
                }
                if ($bottomright->state=="#")
                {
                    $counter+=1;
                }
                

                if ($counter>=5){
                    $this->nextstate="L";
                }
                else{
                    $this->nextstate="#";
                }
            }
            if ($this->state=="."){
                $this->nextstate=".";
            }
        }

        static function readyNextStates($seats, $xsize, $ysize){
            for ($y=0; $y<$ysize; $y++){
                for($x=0; $x<$xsize; $x++){
                    $seats[$y][$x]->readyNextState();
                }
            }
        }

        function runNextState (){
            $this->state = $this->nextstate;
            unset($this->nextstate);
        }

        static function iterateNextState($seats, $xsize, $ysize){
            for ($y=0; $y<$ysize; $y++){
                for($x=0; $x<$xsize; $x++){
                    $seats[$y][$x]->runNextState();
                }
            }
        }

        static function printSeats ($seats, $xsize, $ysize){
            for ($y=0; $y<$ysize; $y++){
                for($x=0; $x<$xsize; $x++){
                    printf("%s", $seats[$y][$x]->state);
                }
                printf("\n");
            }
        }

        static function returnSeats ($seats, $xsize, $ysize){
            $seatsString="";
            for ($y=0; $y<$ysize; $y++){
                for($x=0; $x<$xsize; $x++){
                    $seatsString = $seatsString . $seats[$y][$x]->state;
                }
            }
            return $seatsString;
        }

        static function countOccupied($seats, $xsize, $ysize){
            $counter=0;
            for ($y=0; $y<$ysize; $y++){
                for($x=0; $x<$xsize; $x++){
                    if ($seats[$y][$x]->state == "#"){
                        $counter+=1;
                    }
                }
            }
            return $counter;
        }
    }

    $parse = fopen("input.txt", "r");

    $line = fgets($parse);
    $seats = array();

    $numofcolumns = strlen($line)-2; //I understand why it would be -1, but not -2. Not sure what's going on with that..
    $numofrows=0;

    while (!feof($parse)){
        $row = array();

        for ($y=0; $y<$numofcolumns; $y++){
            $newseat = new seat;
            $newseat->assignx($y);
            $newseat->assigny($numofrows);
            $newseat->assignstate($line[$y]);
            array_push($row, $newseat);
        }
        array_push($seats, $row);

        $numofrows+=1;
        $line = fgets($parse);
    }
    fclose($parse);
    //Have $numofrows, and $numofcolumns

    //echo count($seats);
    //Set references

    //var_dump($seats[$numofrows-1][5]);

    //var_dump(seat::getSeat($seats, 0,1));

    //Numofcolumns is the max horizontal direction.
    //Numofrows is the max vertical direction
    //$seats [*][] is the vertical direction (ROW)
    //$seats [][*] is the horizontal direction (COLUMN)
    //Holy cow this was frustrating to debug
    for($x=0; $x<$numofcolumns; $x++){
        for ($y=0; $y<$numofrows; $y++){
            
            set_error_handler(function () {
                global $x; global $y; global $seats;
                //printf("x: %d y: %d\n", $x, $y); 
            });

            if ($seats[$y+1][$x]!=null){
                $seats[$y][$x]->bottom = &$seats[$y+1][$x];
            }
            if ($seats[$y-1][$x]!=null){
                $seats[$y][$x]->top = &$seats[$y-1][$x];
            }
            if ($seats[$y][$x+1]!=null){
                $seats[$y][$x]->right = &$seats[$y][$x+1];
            }
            if ($seats[$y][$x-1]!=null){
                $seats[$y][$x]->left = &$seats[$y][$x-1];
            }

            if ($seats[$y+1][$x+1]!=null){
                $seats[$y][$x]->bottomright = &$seats[$y+1][$x+1];
            }
            if ($seats[$y+1][$x-1]!=null){
                $seats[$y][$x]->bottomleft = &$seats[$y+1][$x-1];
            }
            if ($seats[$y-1][$x-1]!=null){
                $seats[$y][$x]->topleft = &$seats[$y-1][$x-1];
            }
            if ($seats[$y-1][$x+1]!=null){
                $seats[$y][$x]->topright = &$seats[$y-1][$x+1];
            }


        }
    }

    //seat::printSeats($seats, $numofcolumns, $numofrows);
    //printf("\n");
    //Have to prep iterations.
    seat::readyNextStates($seats, $numofcolumns, $numofrows);
    //Then execute
    seat::iterateNextState($seats, $numofcolumns, $numofrows);

    //seat::printSeats($seats, $numofcolumns, $numofrows);
    //printf("\n");

    $previousState = seat::returnSeats($seats, $numofcolumns, $numofrows);

    //part2
    seat::readyNextStates($seats, $numofcolumns, $numofrows);
    seat::iterateNextState($seats, $numofcolumns, $numofrows);
    //seat::printSeats($seats, $numofcolumns, $numofrows);
    //printf("\n");

    $currentState = seat::returnSeats($seats, $numofcolumns, $numofrows);

    while (strcmp($previousState, $currentState)!=0){
        $previousState = $currentState;
        seat::readyNextStates($seats, $numofcolumns, $numofrows);
        seat::iterateNextState($seats, $numofcolumns, $numofrows);
        //seat::printSeats($seats, $numofcolumns, $numofrows);
        //printf("\n");
        $currentState = seat::returnSeats($seats, $numofcolumns, $numofrows);
    }

    printf("num of occupied: %d\n", seat::countOccupied($seats, $numofcolumns, $numofrows));
?>