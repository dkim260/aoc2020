<?php

    class waypoint
    {
        public $x; public $y;
        public $ship;

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

        public function goL($units){ //Feel like this is cheating, but problem was a bit hard to understand
            if ($units==90){
                //10e 4n <- 4e 10s
                $temp = $this->y;
                $this->y=$this->x;
                $this->x=$temp*-1;
            }
            else if ($units==180){
                $this->x = $this->x * -1;
                $this->y = $this->y * -1;                
            }
            else if ($units==270){
                $this->goR(90);
            }
            else{
                printf ("Something went wrong\n");
            }
        }
        public function goR($units){
            if ($units==90){
                //Not correct... If you apply goR(90) twice it doesnt become goR(180)
                /*
                $temp = $this->x;
                $this->x = $this->y;
                $this->y = $temp * -1;*/
                //10e 4n -> 4e 10s
                if ($this->x>=0 && $this->y>=0){
                    $temp = $this->x;
                    $this->x = $this->y;
                    $this->y = $temp * -1;
                }
                else if ($this->x>=0 && $this->y<0){//Double check TODO ****************
                }
                else if ($this->y<0 && $this->x<0){
                }
                else{
                }

            }
            else if ($units==180){
                $this->x = $this->x * -1;
                $this->y = $this->y * -1;
            }
            else if ($units==270){
                $this->goL(90);
            }
            else{
                printf("Something went wrong\n");
            }
        }

        public function goF($units){
            if ($this->x>=0){
                $this->ship->goE($units*$this->x);
            }
            else{// ($this->x<0)
                $this->ship->goW($units*$this->x);
            }
            if ($this->y>=0){
                $this->ship->goN($units*$this->y);
            }
            else{
                $this->ship->goS($units*$this->y);
            }
        }

        public function __construct()
        {
            $this->x=10; 
            $this->y=1;

            $this->ship = new boat;
            $this->ship->x=0;
            $this->ship->y=0;
        }
    }

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

    $wp = new waypoint;
    var_dump($wp);

    /*
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
*/
?>