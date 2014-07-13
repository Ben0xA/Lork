<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/room.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r4_text.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/combolock.php");
    class r4 extends room
    {
    	function  __construct() {
            $this->loadRoom();		
    	}

        function loadRoom() {
            if(!isset($_SESSION['dbg'])) {
                $this->setDefaults();
                $this->addExits();
                $this->addCommands();
                $this->addRoomItems();
            }                       
            $_SESSION['darkroom'] = true;
        }

        public function getCommand($command) {
            $rtn = "";
            if(isset($_SESSION['combolock'])) {
                if($command == "QUIT") {                    
                    unset($_SESSION['combolock']);
                    $rtn = array(
                        "DISPLAY"=>COMBOQUIT
                    );
                }
                else {
                    $rtn = combolock::typecode($command);
                    if(isset($_SESSION['doors']['r5']) && $_SESSION['doors']['r5']) {
                        $this->addPoints(100);
                        $this->addExit("DOWN", "room::DOWN");
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
            $rtn = R4ENTER;
            if(isset($_SESSION['doors']['r5']) && $_SESSION['doors']['r5']) {
                $this->addExit("DOWN", "room::DOWN");
            }
            return $this->textwithexit($rtn);
        }

        function look() {
            $rtn = R4LOOK;
            if($this->getRoomItemStatus('r4', 'CARPET') == MOVED) {
                $rtn .= BR . BR . R4LOOKTRAPDOOR;
            }
            else {
                $rtn .= " " . R4LOOKCARPET;
            }
            return $this->textwithexit($rtn);;
        }

        function addExits() {
            $this->addExit("EAST", "room::EAST");
        }

        function addCommands() {
            $this->addCommand("LOOK AT CARPET", array("DISPLAY"=>CARPETLOOK));
            $this->addCommand("LOOK AT TABLE", array("DISPLAY"=>TABLELOOK));
            $this->addCommand("LOOK AT CANDLE HOLDER", array("DISPLAY"=>CANDLEHOLDERLOOK));
            $this->addCommand("LOOK AT MATCHES", array("DISPLAY"=>MATCHESLOOK));
            $this->addCommand("LOOK AT TRAP DOOR", array("FUNCTION"=>"room::lookat", "PARAMS"=>"TRAP DOOR"));
            $this->addCommand("LOOK AT PAGES", array("DISPLAY"=>PAPERLOOK));
            $this->addCommand("LOOK AT PAPER", array("DISPLAY"=>PAPERLOOK));
            $this->addCommand("LOOK AT BOOKS", array("DISPLAY"=>BOOKLOOK));
            $this->addCommand("LOOK AT BOOK", array("DISPLAY"=>BOOKLOOK));
            $this->addCommand("TAKE MATCHES", array("FUNCTION"=>"room::take","PARAMS"=>array("MATCHES")));
            $this->addCommand("USE MATCH WITH CANDLE", array("FUNCTION"=>"room::doaction","PARAMS"=>array("LIGHT CANDLE")));
            $this->addCommand("LIGHT CANDLE", array("FUNCTION"=>"room::doaction","PARAMS"=>array("LIGHT CANDLE")));
            $this->addCommand("LIGHT CANDLE HOLDER", array("DISPLAY"=>LIGHTCANDLEHOLDER));
            $this->addCommand("LIGHT CARPET", array("DISPLAY"=>CARPETLIGHT));
            $this->addCommand("MOVE CARPET", array("FUNCTION"=>"room::doaction","PARAMS"=>array("MOVE CARPET")));
            $this->addCommand("MOVE RUG", array("DISPLAY"=>RUGMOVE));
            $this->addCommand("TAKE CANDLE HOLDER", array("DISPLAY"=>YCTT));
            $this->addCommand("TAKE CANDLE", array("DISPLAY"=>YCTT));
            $this->addCommand("TAKE CHAIR", array("DISPLAY"=>YCTT));
            $this->addCommand("TAKE TABLE", array("DISPLAY"=>YCTT));
            $this->addCommand("TAKE BOOKS", array("DISPLAY"=>YCTT));
            $this->addCommand("TAKE PAPER", array("DISPLAY"=>YCTT));
            $this->addCommand("TAKE CARPET", array("DISPLAY"=>YCTT));
            $this->addCommand("USE COMBINATION LOCK", array("FUNCTION"=>"room::doaction","PARAMS"=>"USE COMBINATION LOCK"));
            $this->addCommand("USE LOCK", array("FUNCTION"=>"room::doaction","PARAMS"=>"USE COMBINATION LOCK"));
            $this->addCommand("LOOK AT COMBINATION LOCK", array("FUNCTION"=>"room::lookat", "PARAMS"=>"COMBINATION LOCK"));
            $this->addCommand("LOOK AT LOCK", array("FUNCTION"=>"room::lookat", "PARAMS"=>"COMBINATION LOCK"));
            $this->addCommand("DOWN", array("FUNCTION"=>"room::DOWN"));
            $this->addCommand("D", array("FUNCTION"=>"room::DOWN"));
            $this->addCommand("LOOK AT PAPER", array("DISPLAY"=>PAPERLOOK));
        }

        function addRoomItems() {
            if(!isset($_SESSION['roomitem']['r4']['CARPET'])) {
                $this->addRoomItem("r4", array("CARPET"=>array("STATUS"=>UNMOVED)));    
            }            
        }

        function takematches() {
            $rtn = array();
            if(!isset($_SESSION['inventory']['MATCHES'])) {
                $rtn["DISPLAY"] = MATCHESTAKE;
                $matches = array(
                    "COMMANDS"=>array(
                        "STRIKE MATCH"=>array("DISPLAY"=>MATCH_ON,"FUNCTION"=>"items::ignite"), 
                        "LIGHT MATCH"=>array("DISPLAY"=>MATCH_ON,"FUNCTION"=>"items::ignite"), 
                        "LOOK AT MATCHES"=>array("DISPLAY"=>MATCHESLOOK),
                        "USE MATCHES"=>array("DISPLAY"=>MATCHESUNK),
                        "USE MATCH"=>array("DISPLAY"=>MATCHESUNK),
                        "MATCHES"=>array("DISPLAY"=>MATCHESUNK),
                        "MATCH"=>array("DISPLAY"=>MATCHESUNK)
                    ),
                    "STATUS"=>UNLIT
                );
                $this->addItem("MATCHES", $matches);
            }
            else {
                $rtn["DISPLAY"] = MATCHESTAKENOTFOUND;
            }
            return $rtn;
        }

        function lightcandle() {
            $rtn = array();
            if(isset($_SESSION['inventory']['MATCHES'])) {
               if($this->getItemStatus('MATCHES') == LIT) {
                    $rtn["DISPLAY"] = LIGHTCANDLE;
                    items::extinguish("MATCHES");
               }
               else {
                    $rtn["DISPLAY"] = LIGHTCANDLE_NOTLIT;
               }
            }
            else {
                $rtn["DISPLAY"] = LIGHTCANDLE_NOMATCHES;
            }
            return $rtn;
        }

        function movecarpet() {
            $rtn = array();
            if($this->getRoomItemStatus('r4', 'CARPET') == UNMOVED) {
                $rtn["DISPLAY"] = CARPETMOVE;
                $_SESSION['roomitem']['r4']['CARPET']['STATUS'] = MOVED;
            }
            else {
                $rtn["DISPLAY"] = CARPETMOVED;
            }
            return $rtn;
        }

        function usecombolock() {
            $rtn = array();
            if($this->getRoomItemStatus('r4', 'CARPET') == MOVED) {
                $rtn = combolock::usecombolock();
            }
            else {
                $rtn["DISPLAY"] = CNF;
            }
            return $rtn;
        }

        function lookattrapdoor() {
            $rtn = array();
            if($this->getRoomItemStatus('r4', 'CARPET') == MOVED)  {
                $rtn["DISPLAY"] = TRAPDOOR;
            }
            else {
                $rtn["DISPLAY"] = CNF;
            }
            return $rtn;
        }

        function lookatcombolock() {
            $rtn = array();
            if($this->getRoomItemStatus('r4', 'CARPET') == MOVED)  {
                $rtn["DISPLAY"] = COMBOLOCK;
            }
            else {
                $rtn["DISPLAY"] = CNF;
            }
            return $rtn;
        }

        function take($item) {
            $rtn = "";
            switch($item) {
                case "MATCHES":
                    $rtn = $this->takematches();
            }
            return $rtn;
        }

        function doaction($action) {
            $rtn = "";
            switch($action) {
                case "LIGHT CANDLE":
                    $rtn = $this->lightcandle();
                    break;
                case "MOVE CARPET":
                    $rtn = $this->movecarpet();
                    break;
                case "USE COMBINATION LOCK":
                    $rtn = $this->usecombolock();
                    break;
            }
            return $rtn;
        }

        function lookat($object) {
            $rtn = "";
            switch($object) {
                case "TRAP DOOR":
                    $rtn = $this->lookattrapdoor();
                    break;
                case "COMBINATION LOCK":
                    $rtn = $this->lookatcombolock();
                    break;
            }
            return $rtn;
        }

        function EAST() {
            return $this->go("r2");
        }

        function DOWN() {
            $rtn = array();
            if(isset($_SESSION['doors']['r5']) && $_SESSION['doors']['r5']) {
                 $rtn = $this->go("r5");
            }
            else {
                $rtn["DISPLAY"] = CNF;
            }
            return $rtn;
        }
    }
?>