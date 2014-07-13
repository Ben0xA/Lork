<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/room.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r5_text.php");
    class r5 extends room
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

        public function enterText() {
            $rtn = R5ENTER;
            return $this->textwithexit($rtn);
        }

        function look() {
            $rtn = R5LOOK;
            return $this->textwithexit($rtn);;
        }

        function addExits() {
            $this->addExit("NORTH", "room::NORTH");
            $this->addExit("EAST", "room::EAST");
            $this->addExit("SOUTH", "room::SOUTH");
            $this->addExit("WEST", "room::WEST");
            $this->addExit("UP", "room::UP");
        }

        function addCommands() {
            $this->addCommand("LOOK AT PAPER", array("DISPLAY"=>R5PAPERLOOK));
            $this->addCommand("TAKE PAPER", array("DISPLAY"=>PAPERTAKE));
            $this->addCommand("LOOK AT BUTTON", array("DISPLAY"=>WHICHBUTTON));
            $this->addCommand("LOOK AT GREEN BUTTON", array("DISPLAY"=>GREENLOOK));
            $this->addCommand("LOOK AT RED BUTTON", array("DISPLAY"=>REDLOOK));
            $this->addCommand("PUSH BUTTON", array("DISPLAY"=>WHICHBUTTON));
            $this->addCommand("PUSH GREEN BUTTON", array("FUNCTION"=>"room::doaction","PARAMS"=>"PUSH GREEN BUTTON"));
            $this->addCommand("PUSH RED BUTTON", array("FUNCTION"=>"room::doaction","PARAMS"=>"PUSH RED BUTTON"));
        }

        function doaction($action) {
            $rtn = "";
            switch($action) {
                case "PUSH GREEN BUTTON":
                    $rtn = $this->pushgreenbutton();
                    break;
                case "PUSH RED BUTTON":
                    $rtn = $this->pushredbutton();
                    break;
            }
            return $rtn;
        }

        function NORTH() {
            return $this->go("r6");
        }

        function EAST() {
            return $this->go("r8");
        }

        function SOUTH() {
            return $this->go("r9");
        }

        function WEST() {
            return $this->go("r7");
        }

        function UP() {
            return $this->go("r4");
        }

        function pushgreenbutton() {
            $rtn = array();
            if(isset($_SESSION['konami']) && $_SESSION['konami'] == "UUDDLRLR") {
                unset($_SESSION['konami']);
                $this->addPoints(100);
                $rtn = $this->go("r10");
            }
            else {
                $rtn['DISPLAY'] = FAILEDBUTTON;
                $_SESSION['dbg'] = true;
            }
            return $rtn;
        }

        function pushredbutton() {
            $_SESSION['konami'] = "";
            return array("DISPLAY"=>REDPUSH);
        }
    }
?>