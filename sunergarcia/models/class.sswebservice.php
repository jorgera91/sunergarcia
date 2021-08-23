<?php

header('Content-Type: text/html; charset=utf-8'); 
mb_internal_encoding("UTF-8");
include_once(dirname(__FILE__).'/json.php');

class SSWebService {
    var $methods;
    var $json;
   
    function initialize() {
        $this->json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
    }
   
    /*
    add a function to the server, so it can be accessed
    */
    function register($name) {
        $this->methods[$name] = true;
    }
   
    /*
    set a registered function to be inaccessible
    */
    function deregister($name) {
        $this->methods[$name] = false;
    }
   
    /*
    execute the given method, passing its single parameter
    JSON-encodes the return value, which should be an object or associative array
    */
    function call($name, $param) {
        if ($this->methods[$name] == true) {
            $evalstring = $name."(\$param);";
            eval("\$rval=".$evalstring.";");
            return json_encode($rval);
        }
    }
   
    /*
    decode the JSON param into a native object, and call the given method
    return the JSON-encoded object to the browser via echo
    */
    function serve($method, $param, $stripslashes = true) {
        if ($stripslashes) {
            $param = stripslashes($param);
        }
        $obj = $this->json->decode($param);
        $res = $this->call($method, $obj);
        echo $res;
    }
}

?>