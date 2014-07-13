<?php
    class items
    {
        public static function on($item) {           
            $_SESSION['inventory'][$item]['STATUS'] = ON;
        }

        public static function off($item) {           
            $_SESSION['inventory'][$item]['STATUS'] = OFF;
            if(isset($_SESSION['darkroom']) && $_SESSION['darkroom']) {
                if(items::nolight()) {
                    $_SESSION['dbg'] = true;
                }
            }
        }

        public static function ignite($item) {           
            $_SESSION['inventory'][$item]['STATUS'] = LIT;
        }

        public static function extinguish($item) {           
            $_SESSION['inventory'][$item]['STATUS'] = UNLIT;
            if(isset($_SESSION['darkroom']) && $_SESSION['darkroom']) {
                if(items::nolight()) {
                    $_SESSION['dbg'] = true;
                }
            }
        }

        public static function add($keyname, $item) {
            $_SESSION['inventory'][$keyname] = $item;
        }
    	
        static function nolight() {
            $status = true;
            if(isset($_SESSION['inventory'])) {
                foreach($_SESSION['inventory'] as $key=>$value) {
                    if(array_key_exists("STATUS", $value)) {
                        if($value['STATUS'] == ON || $value['STATUS'] == LIT) {
                            $status = false;
                        }
                    }
                }
            }
            return $status;
        }
    }
?>