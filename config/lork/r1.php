<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/room.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r1_text.php");
    class r1 extends room
    {
    	function  __construct() {
            $this->loadRoom();		
    	}

        function loadRoom() {
            if(!isset($_SESSION['dbg'])) {
                $this->setDefaults();
                if(!array_key_exists("FLASHLIGHT", $_SESSION['inventory'])) {
                    $this->addFlashLight();    
                }
                $this->addExits();    
                $this->addCommands();
            }                       
            $_SESSION['darkroom'] = false;
        }

        function addCommands() {
            $this->addCommand("LOOK AT DOOR", array("DISPLAY"=>DOORLOOK));
            $this->addCommand("LOOK AT DOOR 42", array("DISPLAY"=>DOORLOOK));
        }

    	function addFlashLight() {
    		$flashlight = array(
                "COMMANDS"=>array(
                    "TURN ON FLASHLIGHT"=>array("DISPLAY"=>FLASHLIGHT_ON,"FUNCTION"=>"items::on"), 
                    "TURN OFF FLASHLIGHT"=>array("DISPLAY"=>FLASHLIGHT_OFF,"FUNCTION"=>"items::off"), 
                    "LOOK AT FLASHLIGHT"=>array("DISPLAY"=>FLASHLIGHT),
                    "LOOK FLASHLIGHT"=>array("DISPLAY"=>FLASHLIGHT),
                    "USE FLASHLIGHT"=>array("DISPLAY"=>FLASHLIGHT_UNK),
                    "FLASHLIGHT"=>array("DISPLAY"=>FLASHLIGHT_UNK),
                    "FLASHLIGHT ON"=>array("DISPLAY"=>FLASHLIGHT_UNK)
                ),
                "STATUS"=>"OFF"
    		);
    		$this->addItem("FLASHLIGHT", $flashlight);
    	}

        public function enterText() {
            return $this->textwithexit(R1ENTER);
        }

        function look() {
            return $this->textwithexit(R1LOOK);
        }

        function addExits() {
            $this->addExit("WEST", "room::WEST");
        }

        function WEST() {
            $rtn = array();
            if($_SESSION['inventory']['FLASHLIGHT']['STATUS'] == ON) {
                $rtn = $this->go("r2");
            }
            else {
                $rtn["DISPLAY"] = R1WEST;
                $_SESSION["dbg"] = true;
            }
            return $rtn;
        }
    }
?>