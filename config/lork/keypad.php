<?php
    class keypad
    {
        public static function usekeypad() {
            if(isset($_SESSION['doors']['r4']) && $_SESSION['doors']['r4']) {
                $rtn = array(
                    "DISPLAY"=>ALREADYOPEN
                );
            }   
            else {
                $_SESSION['keypad'] = true;
                $rtn = array(
                    "DISPLAY"=>KEYPADUSE
                );    
            }        
            
            return $rtn;
        }

        public static function typeName($name) {
            $name = trim($name);
            $rtn = array();            
            if($name == "ADMIN") {
                $rtn["DISPLAY"] = KEYPADNOADMIN;
            }
            else {
                $name = trim(substr($name,0,20));
                $rtn["DISPLAY"] = KEYPADNAME . $name;
                if($name == "ADMIN") {
                    unset($_SESSION['keypad']);
                    $_SESSION['doors']['r4'] = true;
                    $rtn["DISPLAY"] .= KEYPADDGRANTED . BR . BR . FLAG1;
                }
                else {
                    $rtn["DISPLAY"] .= KEYPADDENIED;
                }
            }            
            return $rtn;
        }
    }
?>