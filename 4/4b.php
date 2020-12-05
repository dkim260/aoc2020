<?php
    function removeLineBreaks($input){
        return trim($input);
    }

    class user {
        public $byr = -1;
        public $iyr = -1;
        public $eyr = -1;
        public $hgt = "";
        public $hcl = "";
        public $ecl = "";
        public $pid = -1;
        public $cid = -1;

        public function toString()
        {
            return "byr: " . $this->byr . " iyr: " . $this->iyr . " eyr: " . $this->eyr . " hgt: " . $this->hgt . " hcl: " . $this->hcl . " ecl: " . $this->ecl . " pid: " . $this->pid . " cid: " . $this->cid . "\n";
        }

        public function naiiveVerify () { //Should have done this for first part
            return !( $this->byr == -1 || $this->iyr == -1 || $this->eyr == -1 || $this->hgt == "" || $this->hcl == "" || $this->ecl == "" || $this->pid == -1 ); 
        }
        public function verifyUser () : bool {
            $checkbyr = ($this->byr <=2002) && ($this->byr>=1920);
            $checkiyr = ($this->iyr <=2020) && ($this->iyr>=2010);
            $checkeyr = ($this->eyr <=2030) && ($this->eyr>=2020);
            $checkhgt = ($this->verifyHeight($this->hgt));

            $checkhcl = (preg_match("/#[0-9a-f]{6}/", $this->hcl)==1);
            $checkecl = ($this->verifyEcl($this->ecl));
            $checkpid = ($this->verifyPid ($this->pid));

            return $checkbyr && $checkiyr && $checkeyr && $checkhgt && $checkhcl && $checkecl && $checkpid;
        }
        public function verifyDebug () {
            $checkbyr = ($this->byr <=2002) && ($this->byr>=1920);
            $checkiyr = ($this->iyr <=2020) && ($this->iyr>=2010);
            $checkeyr = ($this->eyr <=2030) && ($this->eyr>=2020);
            $checkhgt = ($this->verifyHeight($this->hgt));

            $checkhcl = (preg_match("/#[0-9a-f]{6}/", $this->hcl)==1);
            $checkecl = ($this->verifyEcl($this->ecl));
            $checkpid = ($this->verifyPid ($this->pid));

            //fprintf ("byr: %s iyr: %s eyr: %s hgt: %s hcl: %s ecl: %s pid: %s\n", $checkbyr, $checkiyr, $checkeyr, $checkhgt, $checkhcl, $checkecl, $checkpid);
            return "debug:". " byr: ". $checkbyr . " iyr: " . $checkiyr             . " eyr: " . $checkeyr            . " hgt: " . $checkhgt            . " hcl: " . $checkhcl             . " ecl: " . $checkecl            . " pid: " .  $checkpid . "\n";
        }
        public function verifyEcl ($input){
            $count = 0;
            if (strcmp($input, "amb") == 0){
                $count+=1;
            }
            if (strcmp($input, "blu") == 0){
                $count+=1;
            }
            if (strcmp($input, "brn") == 0){
                $count+=1;
            }
            if (strcmp($input, "gry") == 0){
                $count+=1;
            }
            if (strcmp($input, "grn") == 0){
                $count+=1;
            }
            if (strcmp($input, "hzl") == 0){
                $count+=1;
            }
            if (strcmp($input, "oth") == 0){
                $count+=1;
            }

            if ($count==1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public function verifyHeight ($input) : bool {
            //input should be a string
            $verify = sscanf($input, "%d%s");
            if ($verify==null)
            {
                return false;
            }

            if (strcmp($verify[1],"cm")==0){
                return ($verify[0]>=150 && $verify[0] <=193);
            }
            else if (strcmp($verify[1],"in")==0){
                return ($verify[0]>=59 && $verify[0] <=76);
            }
            else {
                return false;
            }
        }
        public function verifyPid ($input) : bool { //There was an issue with verifying Pid?
            if (preg_match ("/[0-9]{9}/",$input)==1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public function setfield ($array){ //array should have an array of size two: first represents field, second represents value
            if (strcmp($array[0],"byr")==0)
            {
                $this->byr=(int)$array[1];
            }
            else if (strcmp($array[0],"iyr")==0){
                $this->iyr=(int)$array[1];                
            }
            else if (strcmp($array[0],"eyr")==0){
                $this->eyr=(int)$array[1];
            }
            else if (strcmp($array[0],"hgt")==0){
                $this->hgt=removeLineBreaks($array[1]);
            }
            else if (strcmp($array[0],"hcl")==0){
                $this->hcl=removeLineBreaks($array[1]);
            }
            else if (strcmp($array[0],"ecl")==0){
                $this->ecl=removeLineBreaks($array[1]);
            }
            else if (strcmp($array[0],"pid")==0){
                $this->pid=removeLineBreaks($array[1]);                
            }
            else if (strcmp($array[0],"cid")==0){
                $this->cid=removeLineBreaks($array[1]);                
            }
            else{}
        }
    }

    $parse = fopen("input.txt", "r");
    $counter = 0;

    $validnaiive=0;
    $validusers=0;

    $numofusers=0;

    $pass = fopen ("pass.txt", "w");
    $fail = fopen ("fail.txt", "w");
    $other = fopen ("other.txt", "w");

    while (!feof($parse)){

        $line = fgets($parse);//fgets parses 1 line in full

        $user = array ();//start a user
        $user1 = new user();//user class
        $numofusers+=1;

        while (strcmp ($line, "\n")!=0 && $line!=false){//ran into an infinite loop for the last person because formatting
            $args = preg_split("[ ]\n", $line);
            foreach ($args as $arg){
                array_push($user, $arg);
            }
            $line = fgets($parse);
        }

        //add all the available fields into user class
        foreach ($user as $field){
            $whichfield = preg_split("[:]", $field);
            $user1->setfield($whichfield);
        }

        if ($user1->naiiveVerify()==true){
            $validnaiive+=1;

            if ($user1->verifyUser() == true){
                fwrite($pass, $user1->toString());
                $validusers+=1;
            }
            else
            {
                fwrite($fail, $user1->verifyDebug());
                fwrite($fail, $user1->toString());
                // var_dump($user1);
                // $user1->verifyDebug();
            }
        }
        else{
            fwrite($other, $user1->verifyDebug());
            fwrite($other, $user1->toString());
        }
        //var_dump($user1); //something weird happens here -- two users are in one variable for some reason? If you unset $user1 then it's fine. Side effect?

        unset($user);
        unset($usersfields);
        unset($user1); 
        
        $counter+=1;
    }
    fclose($pass);
    fclose($fail);
    fclose($other);

    fclose($parse);
    echo "\nnaiive: ".  $validnaiive;
    echo "\nValid: " . $validusers;
    echo "\nnumofusers: " . $numofusers;
?>