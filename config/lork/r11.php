<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/room.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r11_text.php");
    class r11 extends room
    {
    	function  __construct() {
            $this->loadRoom();		
    	}

        function loadRoom() {
            if(!isset($_SESSION['dbg'])) {
                $this->setDefaults();
                $this->endgame();
            }                       
            $_SESSION['darkroom'] = false;
        }

        public function enterText() {
            $this->add("WINNER!");
            return ENDOFGAME;
        }
    }
?>