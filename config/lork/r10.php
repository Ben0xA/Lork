<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/room.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r10_text.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/laptop.php");
    class r10 extends room
    {
    	function  __construct() {
            $this->loadRoom();		
    	}

        function loadRoom() {
            if(!isset($_SESSION['dbg'])) {
                if(!isset($_SESSION['eog'])) {
                    $this->setDefaults();
                    $this->addCommands();    
                }                
            }                       
            $_SESSION['darkroom'] = false;
        }

        public function getCommand($command) {
            $rtn = "";
            if(isset($_SESSION['laptop'])) {
                if($command == "QUIT") {                    
                    unset($_SESSION['laptop']);
                    $rtn = array(
                        "DISPLAY"=>LAPTOPQUIT
                    );
                }
                else {
                    $rtn = laptop::typecommand($command);
                    if(!isset($_SESSION['nc']) || strtolower($command) == "nc 10.2.1.3 4444") {
                        $base = BR . BASHPROMPT . strtolower($command) . BR;    
                    }
                    else {
                        $base = $command . BR;
                        unset($_SESSION['nc']);
                        unset($_SESSION['laptop']);
                    }
                    $rtn["BASE"] = $base;
                    if(isset($_SESSION['winner']) && $_SESSION['winner']) {
                        $this->addpoints(100);
                        $rtn = $this->go('r11');
                    }
                    elseif(isset($_SESSION['eog']) && $_SESSION['eog']) {
                        $this->endgame();
                        $this->add("FAILED NC!");
                    }
                }
            }
            else {
                $rtn = room::getCommand($command);
            }
            return $rtn;
        }

        public function enterText() {            
            $rtn = R10ENTER . BR . BR . R10INFO . BR . BR . FLAG3;
            return $this->textwithexit($rtn);
        }

        function look() {
            $rtn = R10LOOK;
            return $this->textwithexit($rtn);;
        }

        function addCommands() {
            $this->addCommand("LOOK AT METAL CART", array("DISPLAY"=>CARTLOOK));
            $this->addCommand("LOOK AT CART", array("DISPLAY"=>CARTLOOK));
            $this->addCommand("LOOK AT LAPTOP", array("DISPLAY"=>LAPTOPLOOK));
            $this->addCommand("USE LAPTOP", array("FUNCTION"=>"room::doaction","PARAMS"=>"USE LAPTOP"));
        }

        function doaction($action) {
            $rtn = "";
            switch($action) {
                case "USE LAPTOP":
                    $rtn = $this->uselaptop();
                    break;
            }
            return $rtn;
        }

        function uselaptop() {
            return laptop::uselaptop();
        }
    }
?>