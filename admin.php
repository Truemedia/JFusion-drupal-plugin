<?php
function loadSetup($storePath) {
        //check for trailing slash and generate file path
        if (substr($storePath, -1) == DS) {
            $myfile = $storePath . 'sites/default/settings.php';
        } else {
            $myfile = $storePath . DS . 'sites/default/settings.php';
        }
        if (($file_handle = @fopen($myfile, 'r')) === false) {
            JError::raiseWarning(500, JText::_('WIZARD_FAILURE') . ": $myfile " . JText::_('WIZARD_MANUAL'));
            $result = false;
            return $result;
        } else {
            //parse the file line by line to get only the config variables
			$config = array();
            $file_handle = fopen($myfile, 'r');
            while (!feof($file_handle)) {
                $line = fgets($file_handle);
                if (strpos($line, 'define(') === 0 && count($config) <= 8) {
                    /* extract the name and value, it was coded to avoid the use of eval() function */
                    // name
                    $vars_strt[0] = strpos($line, "'");
                    $vars_end[0] = strpos($line, "',");
                    $name = trim(substr($line, $vars_strt[0], $vars_end[0] - $vars_strt[0]), "'");     
                    // value
                    $vars_strt[1] = strpos($line, " '");
                    $vars_strt[1]++;
                    $vars_end[1] = strpos($line, "')");
                    $value = trim(substr($line, $vars_strt[1], $vars_end[1] - $vars_strt[1]), "'");
                    if($name == "_DB_TYPE_")
                    {
                     $value = strtolower($value);
                    }    
                    $config[$name] = $value;

                }
            }
	        fclose($file_handle);
	    }
        return $config;
	}
?>