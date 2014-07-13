<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/room.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r2_text.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/keypad.php");
    class r2 extends room
    {
    	function  __construct() {
            $this->loadRoom();		
    	}

        function loadRoom() {            
            if(!isset($_SESSION['dbg'])) {
                $this->setDefaults();
                $this->addExits();
                $this->addCommands();
            }       
            $_SESSION['darkroom'] = true;
        }

        public function getCommand($command) {
            $rtn = "";
            if(isset($_SESSION['keypad'])) {
                if($command == "QUIT") {                    
                    unset($_SESSION['keypad']);
                    $rtn = array(
                        "DISPLAY"=>KEYPADQUIT
                    );
                }
                else {
                    $rtn = keypad::typeName($command);
                    if(isset($_SESSION['doors']['r4']) && $_SESSION['doors']['r4']) {
                        $this->addPoints(100);
                    }
                }
            }
            else {
                $rtn = room::getCommand($command);
            }
            return $rtn;
        }

        public function enterText() {
            $rtn = R2ENTER;
            if(isset($_SESSION['doors']['r4']) && $_SESSION['doors']['r4']) {
                $rtn .= BR. BR. R2DOOROPEN;
            }
            return $this->textwithexit($rtn);
        }

        function look() {
            $rtn = R2LOOK;
            if(isset($_SESSION['doors']['r4']) && $_SESSION['doors']['r4']) {
                $rtn .= BR. BR. R2DOOROPEN;
            }
            return $rtn;
        }

        function addExits() {
            $this->addExit("WEST", "room::WEST");
            $this->addExit("SOUTH", "room::SOUTH");
        }

        function addCommands() {
            $this->addCommand("USE KEYPAD", array("FUNCTION"=>"keypad::usekeypad"));
            $this->addCommand("LOOK AT KEYPAD", array("DISPLAY"=>KEYPADLOOK));
        }

        function WEST() {
            $rtn = array();
            if(isset($_SESSION['doors']['r4']) && $_SESSION['doors']['r4']) {
                return $this->go("r4");
            }
            else {
                $rtn["DISPLAY"] = R2WEST;
                $rtn = $this->dbg($rtn);
            }
            return $rtn;
        }

        function SOUTH() {
            return $this->go("r3");
        }
    }
?>