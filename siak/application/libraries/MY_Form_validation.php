<?php if ( defined('BASEPATH') === FALSE ) exit('No direct script access allowed');
// this is used as to extend the base form validation class, 

class MY_Form_validation extends CI_Form_validation
{

    function __construct($rules = array())
    {
        parent::__construct($rules);
    }

    public function is_db1_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->DB1)
            ? ($this->CI->DB1->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
            : FALSE;
    }
    public function amount_okay($str, $field)
    {
        if ($this->CI->functionscore->countDecimal($str) > $field) {
            return FALSE;
        }else{
            return TRUE;
        }

    }
}