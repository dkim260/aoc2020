<?php
    $validuser = array ("byr" => 0, "iyr" => 0, "eyr" => 0, "hgt" => 0, "hcl" => 0, "ecl" => 0, "pid" => 0, "cid" => 0);
    function verify_user ($array){//array is user we're checking

        global $validuser;
        $validusercopy = $validuser;

        //pop every field from array
        while ($hmm = array_shift($array)){
            //echo $hmm . "\n";
            $validusercopy[$hmm]=1;
        }
        $test =  (($validusercopy["byr"] == 1 && $validusercopy["iyr"] == 1 &&  $validusercopy["eyr"] == 1 &&  $validusercopy["hgt"] == 1 &&  $validusercopy["hcl"] == 1 &&  $validusercopy["ecl"] == 1 &&  $validusercopy["pid"] == 1 &&  $validusercopy["cid"] == 1) || ($validusercopy["byr"] == 1 && $validusercopy["iyr"] == 1 &&  $validusercopy["eyr"] == 1 &&  $validusercopy["hgt"] == 1 &&  $validusercopy["hcl"] == 1 &&  $validusercopy["ecl"] == 1 &&  $validusercopy["pid"] == 1 &&  $validusercopy["cid"] == 0) ); 
        unset($validusercopy);
        return $test;
    }


    $parse = fopen("input.txt", "r");

    $counter = 0;
    
    $validusers=0;
    while (!feof($parse) && $counter<=297){

        $line = fgets($parse);//fgets parses 1 line in full
        $user = array ();//start a user
        while (strcmp ($line, "\n")!=0){
            $args = preg_split("[ ]", $line);
            foreach ($args as $arg){
                array_push($user, $arg);     //********ran out of memory for the last user************, checked them manually
            }
            $line = fgets($parse);
        }

        //add all the available fields into an array
        $usersfields = array ();
        foreach ($user as $field){
            $whichfield = preg_split("[:]", $field);
            array_push($usersfields, $whichfield[0]);
            echo " field: ". $whichfield[0] . " value: ". $whichfield[1];
        }
        
        if (verify_user($usersfields) == true){
            $validusers+=1;
        }

        unset($usersfields);
        unset($user);

        $counter+=1;
        echo " counter: ". $counter. "\n";
    }
    fclose($parse);
    echo $validusers;
?>