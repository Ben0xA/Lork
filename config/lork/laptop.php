<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/nc.php");
    class laptop
    {
        public static function uselaptop() {
            $_SESSION['laptop'] = true;
            $rtn = array("DISPLAY"=>LAPTOPUSE);
            return $rtn;
        }

        public static function typecommand($command) {
            $rtn = array();
            if(isset($_SESSION['nc']) && $_SESSION['nc']) {
                $rtn = nc::typepass($command);
            }
            else {
                $command = strtolower(trim($command));            
                $rtntxt = LAPTOPCNF;
                if(!laptop::accessdenied($command)) {
                    switch($command) {
                        case "ls":
                        case "l": 
                        case "ls -l":
                        case "ls -al":
                            $rtntxt = LS;
                            break;
                        case "pwd":
                            $rtntxt = PWD;
                            break;
                        case "make me a sandwich":
                            $rtntxt = MIYS;
                            break;
                        case "sudo make me a sandwich":
                            $rtntxt = SANDWICH;
                            break;
                        case "whoami":
                            $rtntxt = WHOAMI;
                            break;
                        case "history":
                            $rtntxt = HISTORY;
                            break;
                        case "date":
                        case "time":
                            $rtntxt = date("D, M d, Y  g:i:s A");
                            break;
                        case "yes":
                        case "yes yes":
                            $rtntxt = "NO";
                            break;
                        case "cat knockknock.py":
                            $rtntxt = CATKNOCK;
                            break;
                        case "python knockknock.py":
                            $rtntxt = PYTHON;
                            break;
                        case "sudo vi knockknock.py":
                            $rtntxt = NOTTHATEASY;
                            break;
                        case "keyboard doopdy doop":
                            $rtntxt = DOOPDYDOOP;
                            break;
                        case "in the computer!":
                            $rtntxt = INTHECOMPUTER;
                            break;
                        case "duhhhhhhhhhhhhhhhhhhhhh":
                            $rtntxt = DUHHH;
                            break;
                        case "i hate ben0xa!":
                            $rtntxt = BEN0XA;
                            break;
                        case "nc 10.2.1.3 4444":
                            $rtntxt = ENTERPASSCODE;
                            $_SESSION['nc'] = true;
                            break;
                    }    
                }
                else {
                    $rtntxt = ACCESSDENIED;
                }
                $rtn = array("DISPLAY"=>$rtntxt);
            }
            return $rtn;
        }

        static function accessdenied($command) {
            $rtn = false;
            if(substr($command,0,3) == "cd ") {
                $rtn = true;
            }
            else if(substr($command,0,7) == "apt-get" || substr($command,0,12) == "sudo apt-get") {
                $rtn = true;
            }
            return $rtn;
        }
    }
?>