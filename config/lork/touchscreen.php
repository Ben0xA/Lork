<?php
    class touchscreen
    {
        public static function usetouchscreen($room) {
            $rtn = array(
                "DISPLAY"=>TOUCHPADUSE
            );
            if(!isset($_SESSION['roomitem'][$room]['TOUCHSCREEN'])) {
                $_SESSION['roomitem'][$room]['TOUCHSCREEN'] = array('STATUS'=>ACCESSDENIED, 'TRIES'=>0, 'INUSE'=>true);            
            }
            else {
                if(isset($_SESSION['roomitem'][$room]['TOUCHSCREEN']['STATUS']) && $_SESSION['roomitem'][$room]['TOUCHSCREEN']['STATUS'] == ACCESSGRANTED) {
                    $rtn["DISPLAY"] =TOUCHALREADYGRANTED;
                }
                else {
                     $_SESSION['roomitem'][$room]['TOUCHSCREEN']['INUSE'] = true;
                }
            }            
            return $rtn;
        }

        public static function typepassword($room, $password) {
            $rtn = array();            
            if(touchscreen::isvalid($room, $password)) {
                $_SESSION['roomitem'][$room]['TOUCHSCREEN']['STATUS'] = ACCESSGRANTED;
                $_SESSION['roomitem'][$room]['TOUCHSCREEN']['INUSE'] = false;
                $rtn["DISPLAY"] = TOUCHACCESSGRANTED;
            }
            else {
                $rtn["DISPLAY"] = TOUCHACCESSDENIED;
                $_SESSION['roomitem'][$room]['TOUCHSCREEN']['TRIES'] += 1;
                if($_SESSION['roomitem'][$room]['TOUCHSCREEN']['TRIES'] >= 3) {
                    unset($_SESSION['roomitem']);
                    $rtn["DISPLAY"] .= BR . BR . TOUCHFAIL;
                    $_SESSION['dbg'] = true;
                }
                else {
                    $rtn["DISPLAY"] .= BR . TOUCHTRIESREMAIN . (string)(3 - $_SESSION['roomitem'][$room]['TOUCHSCREEN']['TRIES']);
                }
            }            
            return $rtn;
        }

        static function isvalid($room, $password) {
            $rtn = false;
            switch($room) {
                case "r6":
                    if($password == R6) {
                        $rtn = true;
                    }
                    break;
                case "r7":
                    if($password == R7) {
                        $rtn = true;
                    }
                    break;
                case "r8":
                    if($password == R8) {
                        $rtn = true;
                    }
                    break;
                case "r9":
                    if($password == R9) {
                        $rtn = true;
                    }
                    break;
            }
            return $rtn;
        }
    }
?>