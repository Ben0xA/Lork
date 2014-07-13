<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/room.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r6789_text.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/touch_text.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/touchscreen.php");
    class r7 extends room
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
            $_SESSION['darkroom'] = false;
        }

        public function getCommand($command) {
            $rtn = "";
            if(isset($_SESSION['roomitem']['r7']['TOUCHSCREEN']['INUSE']) && $_SESSION['roomitem']['r7']['TOUCHSCREEN']['INUSE'] == true) {
                if($command == "QUIT") {                    
                    $_SESSION['roomitem']['r7']['TOUCHSCREEN']['INUSE'] = false;
                    $rtn = array(
                        "DISPLAY"=>TOUCHQUIT
                    );
                }
                else {
                    $rtn = touchscreen::typepassword('r7', $command);
                    if(isset($_SESSION['roomitem']['r7']['TOUCHSCREEN']['STATUS']) && $_SESSION['roomitem']['r7']['TOUCHSCREEN']['STATUS'] == ACCESSGRANTED) {
                        $this->addPoints(25);
                    }
                }
            }
            else {
                $rtn = room::getCommand($command);
            }
            if(isset($_SESSION['dbg'])) {
                $rtn = $this->dbg($rtn);
            }
            return $rtn;
        }

        public function enterText() {
            $rtn = R6789ENTER;
            return $this->textwithexit($rtn);
        }

        function look() {
            $rtn = R6789LOOK;
            return $this->textwithexit($rtn);;
        }

        function addExits() {
            $this->addExit("EAST", "room::EAST");
        }

        function addCommands() {
            $this->addCommand("LOOK AT BUTTON", array("DISPLAY"=>BUTTONLOOK));
            $this->addCommand("PUSH BUTTON", array("FUNCTION"=>"room::doaction","PARAMS"=>"PUSH BUTTON"));
            $this->addCommand("LOOK AT TOUCH SCREEN", array("DISPLAY"=>TOUCHSCREENLOOK));
            $this->addCommand("TOUCH TOUCH SCREEN", array("DISPLAY"=>TOUCHTOUCH));
            $this->addCommand("USE TOUCH SCREEN", array("FUNCTION"=>"room::doaction","PARAMS"=>"USE TOUCH SCREEN"));
        }

        function doaction($action) {
            $rtn = "";
            switch($action) {
                case "PUSH BUTTON":
                    $rtn = $this->pushbutton();
                    break;
                case "USE TOUCH SCREEN":
                    $rtn = $this->usetouchscreen();
                    break;
            }
            return $rtn;
        }

        function EAST() {
            return $this->go("r5");
        }

        function usetouchscreen() {
            return touchscreen::usetouchscreen('r7');
        }

        function pushbutton() {
            $rtn = "";
            if(isset($_SESSION['roomitem']['r7']['TOUCHSCREEN']['STATUS']) && $_SESSION['roomitem']['r7']['TOUCHSCREEN']['STATUS'] == ACCESSGRANTED) {
                if(!isset($_SESSION['konami'])){
                    $_SESSION['konami'] = "L";
                }
                else {
                    $_SESSION['konami'] .= "L";
                }
                $rtn = array("DISPLAY"=>BUTTONPUSH);
            }
            else {
                $rtn = array("DISPLAY"=>R6789FAILEDBUTTON);
            }
            return $rtn;
        }
    }
?>