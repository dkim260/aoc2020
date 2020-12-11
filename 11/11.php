<?php

    class seat {
        public $x;
        public $y;
        public $state;

        function assignx($x){
            $this->x=$x;
        }
        function assigny($y){
            $this->y=$y;
        }
        function assignstate ($state){
            $this->state=$state;
        }
    }

    $parse = fopen("input.txt", "r");




    $line = fgets($parse);
    $seats = array();

    $numofcolumns = strlen($line);
    $rownum=0;


    while (!feof($parse)){
        $newseat = new seat;

        for ($y=0; $y<$numofcolumns; $y++){
            $newseat->assignx($y);
            $newseat->assigny($rownum);
            $newseat->assignstate($line[$y]);
            var_dump($newseat);
        }
        array_push($seats, $newseat);

        $rownum+=1;
        $line = fgets($parse);
    }
    fclose($parse);

    //var_dump($seats);
?>