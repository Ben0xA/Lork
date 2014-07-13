<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/items.php");
    class room
    {
        private $items;

        public function getCommand($command) {
            $command = substr($command, 0, MAXSTRLEN);          
            $base = BR . PROMPT . $command . BR;                
            $rtn = array("DISPLAY"=>CNF, "BASE"=>$base);
            if($this->items == null) {
                $this->items = new items();
            }         
            if(array_key_exists($command, $_SESSION['commands'])) {
                $rtn = $_SESSION['commands'][$command];
                if(array_key_exists("FUNCTION", $rtn)) {
                    $func = (string)$rtn["FUNCTION"];
                    if(array_key_exists("PARAMS", $rtn)) {
                        $params = (array)$rtn["PARAMS"];
                        $rtn = call_user_func_array($func, $params);
                        if(isset($_SESSION['dbg'])) {
                            $rtn = $this->dbg($rtn);
                        }
                    }
                    else {
                        $rtn = call_user_func($func); 
                        if(isset($_SESSION['dbg'])) {
                            $rtn = $this->dbg($rtn);
                        }    
                    }                    
                }           
            }
            else {
                if(isset($_SESSION['inventory'])) {
                    foreach($_SESSION['inventory'] as $key=>$value) {
                        if(array_key_exists("COMMANDS", $value)) {
                            if(array_key_exists($command, $value["COMMANDS"])) {
                                $rtn = $value["COMMANDS"][$command];
                                if(array_key_exists("FUNCTION", $rtn)) {
                                    $func = (string)$rtn["FUNCTION"];
                                    $params = array($key);
                                    call_user_func_array($func, $params);
                                    if(isset($_SESSION['dbg'])) {
                                        $rtn = $this->dbg($rtn);
                                    }
                                }                            
                            }
                        }
                    }    
                }                
            }
        	return $rtn;
        }

        function checklight() {
            $rtn = true;
            if(items::nolight() && $_SESSION['darkroom'] == true) {
                $rtn = false;
            }
            return $rtn;
        }

        function enterText() {
            return "";
        }

        function look() {
            return "";
        }

        function textwithexit($text) {
            return $text . BR . BR . $this->getExits();
        }

        function WEST() {
            return $this->WEST();
        }

        function EAST() {
            return $this->EAST();
        }

        function NORTH() {
            return $this->NORTH();
        }

        function SOUTH() {
            return $this->SOUTH();
        }

        function DOWN() {
            return $this->DOWN();
        }

        function UP() {
            return $this->UP();
        }

        function take($item) {
            return $this->take($item);
        }

        function doaction($action) {
            return $this->doaction($action);
        }

        function lookat($object) {
            return $this->lookat($object);
        }

        function go($rnum) {
            unset($_SESSION['exits']);
            require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/". $rnum . ".php");
            $r = new $rnum();
            $r->loadRoom();
            $rtxt = $r->enterText();
            $r = null;
            $_SESSION['room'] = $rnum;
            $rtn["DISPLAY"] = $rtxt;
            $rtn["ROOM"] = $rnum;
            $rtn["RESPONSE"] = "START";

            if(!$this->checklight()) {
                $rtn = $this->dbg($rtn);
            }
            return $rtn;
        }

        function getExits() {
            $exits = "Exits are ";
            $idx = 0;
            if(isset($_SESSION['exits'])) {
                foreach($_SESSION['exits'] as $key=>$value) {
                    $idx++;
                    if($idx > 1) {
                        $exits .= ", ";
                    }
                    $exits .= "<b>" . $key . "</b>";                    
                }    
            }
            if($idx == 0) {
                $exits = "There are no exits that you can see.";
            }
            return $exits;
        }

        function showInventory() {
            $items = "";
            $idx = 0;
            foreach($_SESSION['inventory'] as $key=>$value) {
                $idx++;
                $items .= $idx . ". " . $key;
                if(array_key_exists("STATUS", $value)) {
                    $items .= " (" . $value["STATUS"] . ")";
                }
                $items .= "<br />";
            }
            $rtn = array(
                "DISPLAY"=>$items
            );
            return $rtn;
        }

        function addCommand($command, $commandarray) {
            if(!array_key_exists($command, $_SESSION['commands'])) {
                $_SESSION['commands'][$command] = $commandarray;    
            }            
        }

        function addItem($keyname, $item) {
            if($this->items == null) {
                $this->items = new items();
            }
            $this->items->add($keyname, $item);
        }

        function addRoomItem($room, $item) {
            $_SESSION['roomitem'][$room] = $item;
        }

        function addExit($name, $function) {
            if(!isset($_SESSION['commands'])) {
                $_SESSION['commands'] = array();
            }
            if(!array_key_exists($name, $_SESSION['commands'])) {
                $initial = substr($name,0,1);

                $_SESSION['commands'][$name] = array("FUNCTION"=>$function);
                $_SESSION['commands']["GO ". $name] = array("FUNCTION"=>$function);
                $_SESSION['commands'][$initial] = array("FUNCTION"=>$function);
                $_SESSION['commands']["GO ". $initial] = array("FUNCTION"=>$function);
            }
            if(!isset($_SESSION['exits'])) {
                $_SESSION['exits'] = array();
            }
            if(!array_key_exists($name, $_SESSION['exits'])) {
                $_SESSION['exits'][$name] = $name;
            }
        }

        function getRoomItemStatus($room, $item) {
            $rtn = "";
            if(isset($_SESSION['roomitem'][$room][$item]['STATUS'])) {
                $rtn = $_SESSION['roomitem'][$room][$item]['STATUS'];
            }
            return $rtn;
        }

        function getItemStatus($item) {
            $rtn = "";
            if(isset($_SESSION['inventory'][$item]['STATUS'])) {
                $rtn = $_SESSION['inventory'][$item]['STATUS'];
            }
            return $rtn;
        }

        function addPoints($amount) {
            if(!isset($_SESSION['points'])) {
                $_SESSION['points'] =  $amount;
            }
            else {
                $_SESSION['points'] += $amount;
            }
        }

        function setDefaults() {            
        	$_SESSION['cmdhelp'] = array(
			    "HELP"=>"Shows the list of commands.",
			    "CLEAR"=>"Clears the screen",
                "LOOK"=>"Look at the room to get more information. Also [L].",
                "LOOK AT [object]"=>"Look at an object.",
                "TAKE [object]"=>"Take the object.",
                "USE [object]"=>"Interact with the object.",
                "PUSH [object]"=>"Push the object.",
                "MOVE [object]"=>"Moves an object.",
                "LIGHT [object]"=>"Ignites the object.",
                "INFO"=>"Displays the information about the room.",
                "INVENTORY"=>"See what you have. Also [I].",
                "DIRECTIONS"=>"Directions can be typed as NORTH,EAST,SOUTH,WEST,UP,DOWN or N,E,S,W,U,D",
			    "EXIT"=>"Exits the game."
			);

			$_SESSION['commands'] = array(
				"LOOK"=>array("DISPLAY"=>$this->look()),
                "L"=>array("DISPLAY"=>$this->look()),
                "LOOK AT"=>array("DISPLAY"=>LAW),
                "INVENTORY"=>array("FUNCTION"=>"room::showInventory"),
                "I"=>array("FUNCTION"=>"room::showInventory"),
                "INFO"=>array("DISPLAY"=>$this->enterText()),
				"EXIT"=>array("RESPONSE"=>"EXIT","DISPLAY"=>""),
                "LOOK WEST"=>array("DISPLAY"=>LOOKDIRECTION),
                "LOOK NORTH"=>array("DISPLAY"=>LOOKDIRECTION),
                "LOOK SOUTH"=>array("DISPLAY"=>LOOKDIRECTION),
                "LOOK EAST"=>array("DISPLAY"=>LOOKDIRECTION)
			);

            if(!isset($_SESSION['inventory'])) {
                $_SESSION['inventory'] = array();
            }

            if(!isset($_SESSION['exits'])) {
                $_SESSION['exits'] = array();
            }

            if(!isset($_SESSION['doors'])) {
                $_SESSION['doors'] = array();
            }

            if(!isset($_SESSION['roomitem'])) {
                $_SESSION['roomitem'] = array();
            }
        }

        function restart() {
            unset($_SESSION['dbg']);
            unset($_SESSION['dbgshown']);
            unset($_SESSION['konami']);
            unset($_SESSION['winner']);
            unset($_SESSION['roomitem']);
            unset($_SESSION['doors']);
            unset($_SESSION['exits']);
            unset($_SESSION['inventory']);
            unset($_SESSION['eog']);
            unset($_SESSION['nc']);
            unset($_SESSION['laptop']);
            $_SESSION['points'] = 0;
            return $this->go("r1");
        }

        function dbgCommands() {
            unset($_SESSION['cmdhelp']);
            $_SESSION['cmdhelp'] = array(
                "HELP"=>"Shows the list of commands.",
                "RESTART"=>"Restarts the game.",
                "EXIT"=>"Exits the game."
            );

            unset($_SESSION['commands']);
            $_SESSION['commands'] = array(
                "RESTART"=>array("FUNCTION"=>"room::restart"),
                "EXIT"=>array("RESPONSE"=>"EXIT","DISPLAY"=>"")
            );
        }

        function endgame() {
            unset($_SESSION['inventory']);
            unset($_SESSION['exits']);
            unset($_SESSION['doors']);
            unset($_SESSION['roomitem']);
            $this->dbgCommands();
        }

        function dbg($rtn) {
            $_SESSION['dbg'] = true;
            if(!isset($_SESSION['dbgshown'])) {
                $rtn["DISPLAY"] .= BR . BR . GRUE . BR . BR . DBG . BR . BR . RESTART;
                $_SESSION['dbgshown'] = true;
            }
            $rtn["RESPONSE"]  = "DBG";            
            unset($_SESSION['inventory']);
            unset($_SESSION['exits']);
            unset($_SESSION['doors']);
            unset($_SESSION['roomitem']);
            $_SESSION['points'] = -1000;
            $this->dbgCommands();
            $this->add("DBG!");
            return $rtn;
        }

        function exitGame() {
            unset($_SESSION['inventory']);
            unset($_SESSION['exits']);
            unset($_SESSION['doors']);
            unset($_SESSION['roomitem']);
            unset($_SESSION['dbgshown']);
        	$this->setDefaults();
        }

        function add($command) {
            $page = $_SERVER['SCRIPT_FILENAME'];
            $command = trim(preg_replace('/\s+/', ' ', $command));
            $dateformat = date('mdY');
            $log = $_SERVER['DOCUMENT_ROOT'] . "/../logs/lork.log";
            $date = date('m/d/Y h:i a');
            $remip = $_SERVER['REMOTE_ADDR'];
            $msg = "[$date]:[$remip]:[" . $page . "]:[room: " . (isset($_SESSION['room']) ? $_SESSION['room'] : "") . "] - $command\n";

            error_log($msg, 3, $log);
        }
    }
?>