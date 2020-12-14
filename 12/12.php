<?php

    class boat {
        public $x; public $y;
        public $facing=90; //going clockwise.

        public function goN($units){
            $this->y+=$units;
        }
        public function goS($units){
            $this->y-=$units;
        }

        public function goE($units){
            $this->x+=$units;
        }

        public function goW($units){
            $this->x-=$units;
        }

        public function goF($units){
            if ($this->facing==90){
                $this->goE($units);
            }
            else if ($this->facing==180){
                $this->goS($units);
            }
            else if ($this->facing==270){
                $this->goW($units);
            }
            else if ($this->facing==0){
                $this->goN($units);
            }
            else{
                $this->reposFacing();
                $this->goF($units);
                printf("Something went wrong going forward\n");
                var_dump($this);
            }
        }

        public function turnL($degrees){
            $this->facing-=$degrees;
            $this->reposFacing();
        }

        public function turnR($degrees){
            $this->facing+=$degrees;
            $this->reposFacing();
        }

        public function reposFacing(){
            if ($this->facing<0){
                $this->facing *= -1;
                $this->facing = 360-$this->facing;

            }
            else if ($this->facing>=360){
                $this->facing -= 360;
            }
            else{
            }
        }

        public function manSum(){
            return abs($this->x)+abs($this->y);
        }
    }

    $ship = new boat;

    $parse = fopen("input.txt", "r");

    
    $input = fscanf($parse, "%c%d");

    while (!feof($parse)){
        $command = $input[0];
        $num = $input[1];

        if ($command=="N"){$ship->goN($num);}
        else if ($command=="E"){$ship->goE($num);}
        else if ($command=="S"){$ship->goS($num);}
        else if ($command=="W"){$ship->goW($num);}
        else if ($command=="F"){$ship->goF($num);}
        else if ($command=="L"){$ship->turnL($num);}
        else if ($command=="R"){$ship->turnR($num);}
        else{printf("Something went wrong reading input");}

        $input = fscanf($parse, "%c%d");
    }

    fclose($parse);

    printf ("Man sum: %d\n", $ship->manSum());

?>