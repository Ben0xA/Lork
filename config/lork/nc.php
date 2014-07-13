<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/knockknock.php");
    class nc
    {
        public static function typepass($password) {
            $rtn = array("DISPLAY"=>"");
            $knock = new knockknock();
            $accesscode = $knock->getaccess();
            if($password == $accesscode) {
                $_SESSION['winner'] = true;
            }
            else {
                $rtn["DISPLAY"] = NCFAIL;
                $_SESSION['eog'] = true;
            }
            return $rtn;
        }
    }
?>