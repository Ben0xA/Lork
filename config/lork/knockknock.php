<?php
    class knockknock
    {
        public function getaccess() {
            $rtn = "";
            $now = date("mdYHis");
            $mask = "Nevil Maskelyn";
            $ditdah = ".-..--...";
            $salt = "1903";
            $idx = -1;
            $ddidx = -1;
            $tidx = -1;
            if((int)substr($now, -2) < 30) {
                $now = date("mdYHi") . "00";
            }                
            else {
                $now = date("mdYHi") . "30";
            }
            $nstr = $now . $salt;
            foreach(str_split($mask) as $ltr) {
                $idx++;
                $ddidx++;
                $tidx++;
                if($ddidx >= strlen($ditdah)) {
                    $ddidx = 0;
                }
                if($tidx >= strlen($nstr)) {
                    $tidx = 0;
                }

                $rtn .= chr((ord($ltr) ^ ord(substr($ditdah, $ddidx, 1))) ^ ord(substr($nstr, $tidx, 1)));
            }

            return $rtn;
        }
    }
?>