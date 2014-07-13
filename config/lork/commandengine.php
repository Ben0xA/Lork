<?php
    class commandengine
    {
        function  __construct() {
            if(!isset($_SESSION['commands'])) {
                $this->setDefaults();    
            }            
        }

        public function getHelp() {
        	$rtn = "<table cellpadding=0 cellspacing=0 border=0>";
			foreach($_SESSION['cmdhelp'] as $key=>$value) {
				$rtn .= "<tr><td width=250><b>" . $key . "</b>:</td><td>" . $value . "</td></tr>";
			}
			$rtn . "</table>";
            return $rtn;
        }

        public function getCommand($command) {
            $command = substr($command, 0, MAXSTRLEN);        	
            $base = BR . PROMPT . $command . BR;
            $rtn = json_encode(array("DISPLAY"=>CNF, "BASE"=>$base, "ROOM"=>(isset($_SESSION['room']) ? $_SESSION['room'] : ""), "POINTS"=>(isset($_SESSION['points']) ? $_SESSION['points'] : 0)));
            $rtnarr = array();
            $room = null;
            if(isset($_SESSION['room'])) {
                $r = $_SESSION['room'];
                require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/" . $r . ".php");
                $room = new $r();                
                if($room != null) {
                    if($command == "EXIT") {
                        $this->setDefaults();
                        unset($_SESSION['score']);
                        unset($_SESSION['room']);
                        unset($_SESSION['inventory']);
                        unset($_SESSION['exits']);
                        unset($_SESSION['points']);
                        unset($_SESSION['doors']);
                        unset($_SESSION['roomitem']);
                        $rtn = strip_tags(json_encode(array("RESPONSE"=>"EXIT","DISPLAY"=>WELCOME . BR . SWPAG . BR,"ROOM"=>"","POINTS"=>(isset($_SESSION['points']) ? $_SESSION['points'] : 0))), ALLOWEDTAGS);
                    }
                    else {
                        $rtnarr = (array)$room->getCommand($command);    
                    }                    
                }
            }
            else {
                if(substr($command,0,5) == "PLAY ") {
                    $command = substr($command, 5);
                }
                if(array_key_exists($command, $_SESSION['commands'])) {
                    switch ($command) {
                        case "GLOBAL THERMONUCLEAR WAR":
                            require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/r1.php");
                            $room = new r1();
                            $_SESSION['score'] = true;
                            $_SESSION['room'] = "r1";
                            $rtn = strip_tags(json_encode(array("RESPONSE"=>"START","DISPLAY"=>$room->enterText(),"ROOM"=>$_SESSION['room'],"POINTS"=>(isset($_SESSION['points']) ? $_SESSION['points'] : 0))), ALLOWEDTAGS);
                            break;                        
                        default:
                            $rtnarr = (array)$_SESSION['commands'][$command];                                             
                            break;
                    }
                }
            }
            if($rtnarr != null) {
                if(!array_key_exists("BASE", $rtnarr)) {
                    $rtnarr["BASE"] = $base;    
                }                
                if(isset($_SESSION['room'])) {
                    $rtnarr["ROOM"] = $_SESSION['room'];    
                }
                else {
                    $rtnarr["ROOM"] = "";
                }
                $rtnarr["POINTS"] = (isset($_SESSION['points']) ? $_SESSION['points'] : 0);
                $rtn = strip_tags(json_encode($rtnarr), ALLOWEDTAGS);    
            }                   	       	
        	return $rtn;
        }

        public function setDefaults() {
        	$_SESSION['cmdhelp'] = array(
			    "HELP"=>"Shows the list of commands.",
			    "CLEAR"=>"Clears the screen",
			    "LIST GAMES"=>"Lists the games that are available to play."
			);

			$_SESSION['commands'] = array(
				"LIST GAMES"=>array("DISPLAY"=>"FALKEN'S MAZE<br />BLACK JACK<br />GIN RUMMY<br />HEARTS<br />BRIDGE<br />CHECKERS<br />CHESS<br />POKER<br />FIGHTER COMBAT<br />GUERRILLA ENGAGEMENT<br />DESERT WARFARE<br />AIR-TO-GROUND ACTIONS<br />THEATERWIDE TACTICAL WARFARE<br />THEATERWIDE BIOTOXIC AND CHEMICAL WARFARE<br />GLOBAL THERMONUCLEAR WAR"),
				"FALKEN'S MAZE"=>array("DISPLAY"=>"YOU WOULD PROBABLY GET LOST."),
				"BLACK JACK"=>array("DISPLAY"=>"YOU STINK AT BLUFFING."),
				"GIN RUMMY"=>array("DISPLAY"=>"I'D RATHER JUST DRINK THE RUM."),
				"HEARTS"=>array("DISPLAY"=>"YOU'D BLEED ALL OVER YOURSELF."),
				"BRIDGE"=>array("DISPLAY"=>"IT DOESN'T GO ANYWHERE. TRUST ME I'VE TRIED."),
				"CHECKERS"=>array("DISPLAY"=>"UGH. REALLY? NO. JUST NO."),
				"CHESS"=>array("DISPLAY"=>"HOW ABOUT A NICE GAME OF ... WAIT..."),
				"POKER"=>array("DISPLAY"=>"YOU STINK AT BLUFFING."),
				"FIGHTER COMBAT"=>array("DISPLAY"=>"PEW PEW. YOU LOSE!"),
				"GUERRILLA ENGAGEMENT"=>array("DISPLAY"=>"YOU FIGHT LIKE A COW!"),
				"DESERT WARFARE"=>array("DISPLAY"=>"OH, YOU WANNA BUILD SANDCASTLES HUH?!"),
				"AIR-TO-GROUND ACTIONS"=>array("DISPLAY"=>"THIS IS SKYDIVING WITHOUT A PARACHUTE."),
				"THEATERWIDE TACTICAL WARFARE"=>array("DISPLAY"=>"I DON'T WANT TO PLAY THAT."),
				"THEATERWIDE BIOTOXIC AND CHEMICAL WARFARE"=>array("DISPLAY"=>"YOU'D LOSE. CHOOSE SOMETHING ELSE."),
				"GLOBAL THERMONUCLEAR WAR"=>array("RESPONSE"=>"START","DISPLAY"=>""),
                "YES"=>array("DISPLAY"=>"HOW ABOUT YOU TRY LIST GAMES OR HELP."),
                "OK"=>array("DISPLAY"=>"HOW ABOUT YOU TRY LIST GAMES OR HELP."),
                "NO"=>array("DISPLAY"=>"FINE. IT WOULD'VE BEEN FUN. YOUR LOSS!")
			);
        }

        function exitGame() {
        	unset($_SESSION['savedata']);
        	$this->setDefaults();
        }
    }
?>