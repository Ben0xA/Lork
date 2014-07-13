<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/room.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r3_text.php");
    class r3 extends room
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

        function addCommands() {
            $this->addCommand("LOOK AT STICKY NOTE", array("DISPLAY"=>STICKYNOTE));
            $this->addCommand("LOOK STICKY NOTE", array("DISPLAY"=>STICKYNOTE));
            $this->addCommand("STICKY NOTE", array("DISPLAY"=>STICKYNOTE_UNK));
            $this->addCommand("PICK UP STICKY NOTE", array("DISPLAY"=>STICKYNOTE_TAKE));
            $this->addCommand("TAKE STICKY NOTE", array("DISPLAY"=>STICKYNOTE_TAKE));
        }

        public function enterText() {
            return $this->textwithexit(R3ENTER);
        }

        function look() {
            return $this->textwithexit(R3LOOK);
        }

        function addExits() {
            $this->addExit("NORTH", "room::NORTH");
        }

        function NORTH() {
            return $this->go("r2");
        }
    }
?>