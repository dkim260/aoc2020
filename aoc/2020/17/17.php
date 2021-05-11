<?php
    //returns the neighbour points (x,y,z) of a point in plane
    function cubepointneighours ($x, $y, $z){
        $dump = array();

        $pairs = array(-1, 0, 1);
        foreach ($pairs as $a){
            foreach ($pairs as $b){
                foreach ($pairs as $c){
                    $coords = array();
                    array_push($coords, $x+$a);
                    array_push($coords, $y+$b);
                    array_push($coords, $z+$c);

                    array_push($dump, $coords);
                }
            }
        }

        $search = array($x,$y,$z);
        unset($dump[array_search($search, $dump)]);

        return $dump;
    }

    $file = fopen("input.txt", "r");

    $parse="";

    //3d array: if key in array is null, it's inactive. otherwise entry is x or .
    $y=0;
    $z=0;
    $points = array();

    while ($parse !== false){
        $parse = fgets($file);
        for ($x = 0; $x< strlen($parse)-1; $x++){
            if (!key_exists($x, $points)){
                $points[$x] = array();
            }
            if (!key_exists($y, $points[$x])){
                $points[$x][$y]=array();
            }
            if (!key_exists($z, $points[$x][$y])){
                $points[$x][$y][$z]=array();
            }
            array_push($points[$x][$y][$z], $parse[$x]);
        }
        $y++;
    }

    //There's an extra column?
    array_pop($points);

    //Looks super dangerous
    function cycle(&$array){
        foreach ($array as $a){
            foreach ($a as $b){
                foreach ($b as $c){
                    $x = array_search($a, $array);
                    $y = array_search($b, $a);
                    $z = array_search($c, $b);

                    $counter=0;
                    foreach (cubepointneighours($x,$y,$z) as $neighbour){
                        // $array[$neighbour[0]][$neighbour[1][$neighbour[2]]];
                        $flag = false;
                        if (!key_exists($neighbour[0],$array)){
                            $array[$neighbour[0]] = array();
                            $flag = true;
                        }
                        if (!key_exists($neighbour[1],$array[$neighbour[0]])){
                            $array[$neighbour[0]][$neighbour[1]] = array();
                            $flag = true;
                        }
                        if (!key_exists($neighbour[2],$array[$neighbour[0]][$neighbour[1]])){
                            $array[$neighbour[0]][$neighbour[1]][$neighbour[2]] = array();
                            $flag = true;
                        }

                        if ($flag===true){
                            $array[$neighbour[0]][$neighbour[1]][$neighbour[2]]=".";
                        }
                        else if ($array[$neighbour[0]][$neighbour[1]][$neighbour[2]] === "x"){
                            $counter++;
                        }
                    }

                    if ($array[$x][$y][$z]==="x" && !($counter == 2 || $counter == 3)){
                        $array[$x][$y][$z]=".";
                    }
                    else if ($array[$x][$y][$z] === "." && $counter ===3 ){
                        $array[$x][$y][$z]="x";
                    }

                }
            }
        }
        
    }

    //Simulate 6 cycles of conway cube
    $cycle=0;
    while ($cycle<6){
        cycle($points);
        $cycle++;
    }
    
    $counter=0;
    foreach ($points as $a){
        foreach ($a as $b){
            foreach ($b as $c){
                if ($c==="x"){
                    $counter++;
                }

            }
        }
    }

    var_dump($counter);

    return;
?>