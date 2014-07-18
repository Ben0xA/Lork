<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/commandengine.php");
    class textengine
    {
        private $cmds;

        function  __construct() {
            $this->cmds = new commandengine();
        }

        public function getText() {
            $rtn = "";
            if(isset($_SESSION['txt'])) {
                $command = substr(strtoupper($_SESSION['txt']), 0, MAXSTRLEN);
                $base = BR . PROMPT . $command . BR;
                $this->add($command);
                $rtn = json_encode(array("DISPLAY"=>CNF, "BASE"=>$base), JSON_UNESCAPED_SLASHES);
                switch($command) {
                    case "HELP":
                        $rtn = strip_tags(json_encode(array("DISPLAY"=>$this->cmds->getHelp(),"BASE"=>$base,"ROOM"=>(isset($_SESSION['room']) ? $_SESSION['room'] : ""),"POINTS"=>(isset($_SESSION['points']) ? $_SESSION['points'] : 0)), JSON_UNESCAPED_SLASHES), ALLOWEDTAGS);
                        break;
                    default:
                        $rtn = strip_tags($this->cmds->getCommand($command), ALLOWEDTAGS);                       
                }                
                unset($_SESSION['txt']);
            }
            else {
                $rtn = strip_tags(WELCOME . BR . SWPAG . BR, ALLOWEDTAGS);
            }
            $rtn = str_replace("  ", "&nbsp;&nbsp;", $rtn);
            return $rtn;
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
