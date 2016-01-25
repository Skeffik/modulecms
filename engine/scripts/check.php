<?php
//include protection
/* Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */

defined('_CMSEXEC') or die('Restricted access');

function clientip(){
 global $realip;
    $realip="";
    
    $REMOTE_ADDR_CL = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '').
    (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != 'unknown' ? ' FW: '.$_SERVER['HTTP_X_FORWARDED_FOR'] : '').
    (isset($_SERVER['HTTP_CLIENT_IP']) ? ' CLIENT_IP: '.$_SERVER['HTTP_CLIENT_IP'] : '').
    (isset($_SERVER['HTTP_VIA']) ? ' VIA: '.$_SERVER['HTTP_VIA'] : '');

    if(isset($HTTP_SERVER_VARS)) {
        if(isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])){
            $realip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
        }
        elseif(isset($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])) {
            $realip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
        }
        else{
            $realip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
        }
    }
    else{
        if(getenv('HTTP_X_FORWARDED_FOR')){$realip = getenv('HTTP_X_FORWARDED_FOR');}
        elseif (getenv('HTTP_CLIENT_IP')){$realip = getenv('HTTP_CLIENT_IP');}
        else {
            $realip = getenv( 'REMOTE_ADDR' );
            //print_r ($_SERVER);
            //$_SERVER['HTTP_X_FORWARDED_FOR'];
            //$_SERVER['REMOTE_ADDR'];
            //$_SERVER['HTTP_X_REAL_IP'];
        }
    }
   /* return $realip;*/
}

function checkurlrequest($icheck){
	if (strpos($_SERVER['REQUEST_URI'],$icheck)) die(require_once ('engine/errors/404.html'));
}

?>