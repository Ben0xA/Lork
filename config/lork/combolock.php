<?php
    class combolock
    {
        public static function usecombolock() {
            if(isset($_SESSION['doors']['r5']) && $_SESSION['doors']['r5']) {
                $rtn = array(
                    "DISPLAY"=>COMBOALREADYOPEN
                );
            }   
            else {
                $_SESSION['combolock'] = true;
                if(!isset($_SESSION['combotries'])) {
                    $_SESSION['combotries'] = 0;    
                }                
                $rtn = array(
                    "DISPLAY"=>COMBOLOCKUSE
                );    
            }        
            
            return $rtn;
        }

        public static function typecode($code) {
            $code = trim($code);
            $rtn = array();
            $_SESSION['combotries'] += 1;           
            if($code == "3592") {
                unset($_SESSION['combolock']);
                unset($_SESSION['combotries']);
                $_SESSION['doors']['r5'] = true;
                $rtn["DISPLAY"] = COMBOOPEN . BR . BR . FLAG2;
            }
            else {
                if($_SESSION['combotries'] >= 3) {
                    unset($_SESSION['combolock']);
                    unset($_SESSION['combotries']);
                    $rtn["DISPLAY"] = COMBOFAIL . BR . BR . COMBOTRAP;
                    $_SESSION['dbg'] = true;
                }
                else {
                    $rtn["DISPLAY"] = COMBOFAIL . BR . TRIESLEFT . (string)(3 - $_SESSION['combotries']);
                }

            }            
            return $rtn;
        }
    }
?>