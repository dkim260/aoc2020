<?php
    class answers {
        public $a = 0;
        public $b = 0;
        public $c = 0;
        public $d = 0;
        public $e = 0;
        public $f = 0;
        public $g = 0;
        public $h = 0;
        public $i = 0;
        public $j = 0;
        public $k = 0;
        public $l = 0;
        public $m = 0;
        public $n = 0;
        public $o = 0;
        public $p = 0;
        public $q = 0;
        public $r = 0;
        public $s = 0;
        public $t = 0;
        public $u = 0;
        public $v = 0;
        public $w = 0;
        public $x = 0;
        public $y = 0;
        public $z = 0;

        public $sum=0;

        public $size=0;
    }

    $parse = fopen("input.txt", "r");

    $line = fgets($parse);

    $testtakers  = array ();

    while (!feof($parse)){
        $test = new answers;
        
        $counter=0;
        while ($line!=false && ($line[0] != "\n" )){
            for ($x=0; $x<strlen($line); $x+=1){
                if ($line[$x] == "a"){
                    $test->a+=1;
                }
                else if ($line[$x]=="b"){
                    $test->b+=1;
                }
                else if ($line[$x]=="c"){
                    $test->c+=1;
                }
                else if ($line[$x]=="d"){
                    $test->d+=1;
                }
                else if ($line[$x]=="e"){
                    $test->e+=1;
                }
                else if ($line[$x]=="f"){
                    $test->f+=1;
                }
                else if ($line[$x]=="g"){
                    $test->g+=1;
                }
                else if ($line[$x]=="h"){
                    $test->h+=1;
                }
                else if ($line[$x]=="i"){
                    $test->i+=1;
                }
                else if ($line[$x]=="j"){
                    $test->j+=1;
                }
                else if ($line[$x]=="k"){
                    $test->k+=1;
                }
                else if ($line[$x]=="l"){
                    $test->l+=1;
                }
                else if ($line[$x]=="m"){
                    $test->m+=1;
                }
                else if ($line[$x]=="n"){
                    $test->n+=1;
                }
                else if ($line[$x]=="o"){
                    $test->o+=1;
                }
                else if ($line[$x]=="p"){
                    $test->p+=1;
                }
                else if ($line[$x]=="q"){
                    $test->q+=1;
                }
                else if ($line[$x]=="r"){
                    $test->r+=1;
                }
                else if ($line[$x]=="s"){
                    $test->s+=1;
                }
                else if ($line[$x]=="t"){
                    $test->t+=1;
                }
                else if ($line[$x]=="u"){
                    $test->u+=1;
                }
                else if ($line[$x]=="v"){
                    $test->v+=1;
                }
                else if ($line[$x]=="w"){
                    $test->w+=1;
                }
                else if ($line[$x]=="x"){
                    $test->x+=1;
                }
                else if ($line[$x]=="y"){
                    $test->y+=1;
                }
                else if ($line[$x]=="z"){
                    $test->z+=1;
                }
                else{
                }
            }
            $counter+=1;
            $line = fgets($parse);
        }

        $test->size=$counter;
        //holy don't do this
        if ($test->a==$test->size){
            $test->sum+=1;
        }
        if ($test->b==$test->size){
            $test->sum+=1;
        }
        if ($test->c==$test->size){
            $test->sum+=1;
        }
        if ($test->d==$test->size){
            $test->sum+=1;
        }
        if ($test->e==$test->size){
            $test->sum+=1;
        }
        if ($test->f==$test->size){
            $test->sum+=1;
        }
        if ($test->g==$test->size){
            $test->sum+=1;
        }
        if ($test->h==$test->size){
            $test->sum+=1;
        }
        if ($test->i==$test->size){
            $test->sum+=1;
        }
        if ($test->j==$test->size){
            $test->sum+=1;
        }
        if ($test->k==$test->size){
            $test->sum+=1;
        }
        if ($test->l==$test->size){
            $test->sum+=1;
        }
        if ($test->m==$test->size){
            $test->sum+=1;
        }
        if ($test->n==$test->size){
            $test->sum+=1;
        }
        if ($test->o==$test->size){
            $test->sum+=1;
        }
        if ($test->p==$test->size){
            $test->sum+=1;
        }
        if ($test->q==$test->size){
            $test->sum+=1;
        }
        if ($test->r==$test->size){
            $test->sum+=1;
        }
        if ($test->s==$test->size){
            $test->sum+=1;
        }
        if ($test->t==$test->size){
            $test->sum+=1;
        }
        if ($test->u==$test->size){
            $test->sum+=1;
        }
        if ($test->v==$test->size){
            $test->sum+=1;
        }
        if ($test->w==$test->size){
            $test->sum+=1;
        }
        if ($test->x==$test->size){
            $test->sum+=1;
        }
        if ($test->y==$test->size){
            $test->sum+=1;
        }
        if ($test->z==$test->size){
            $test->sum+=1;
        }

        array_push($testtakers, $test); 
        //var_dump($test);
        $line = fgets($parse);        
    }

    $sumofcounts = 0;
    foreach ($testtakers as $tester){
        $sumofcounts+=$tester->sum;
    }

    echo $sumofcounts;

    fclose($parse);
