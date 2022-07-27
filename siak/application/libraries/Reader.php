<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reader {

    var $fields;            /** columns names retrieved after parsing */ 
    var $separator  =   ';';    /** separator used to explode each line */
    var $enclosure  =   '"';    /** enclosure used to decorate each field */

    var $max_row_size   =   4096;    /** maximum row size to be used for decoding */

    function parse_file($p_Filepath, $getKeys = false)
    {
        $file           =   fopen($p_Filepath, 'r');
        $this->fields   =   fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);
        $keys_values    =   explode(',',$this->fields[0]);

        $content        =   array();
        $keys           =   $this->escape_string($keys_values);

        if ($getKeys) {
            $keys_values = array();
            foreach ($keys as $key => $value) {
                $from = array(" ", "/");
                $to = array("_", "_");
                // $keys_values[$key] = strtolower(str_replace($from, $to, $value));
                $keys_values[strtolower(str_replace($from, $to, $value))] = $value;
                // $keys_values[$key] = $value;
            }
            return $keys_values;
        }

        $i  =   1;
        while(($row = fgetcsv($file, $this->max_row_size)) != false ) 
        {
            if( $row != null ) { // skip empty lines
                $values = $row;
                if(count($keys) == count($values)){
                    $arr = array();
                    $new_values = array();
                    $new_values = $this->escape_string($values);
                    for($j=0;$j<count($keys);$j++){
                        $from = array(" ", "/");
                        $to = array("_", "_");
                        $key = strtolower(str_replace($from, $to, $keys[$j]));                        
                        if($keys[$j] != ""){
                            $arr[$key] = $new_values[$j];
                        }
                    }
                    $content[$i]    =   $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }

    function escape_string($data)
    {
        $result =   array();
        foreach($data as $row){
            $result[]   =   str_replace('"', '', $row);
        }
        return $result;
    }   
}
?>