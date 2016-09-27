<?php

class Mcrud extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function create($data){
        $this->db->INSERT('import', $data);
        if ($this->db->affected_rows() > 0){
            return TRUE;
        }  else {
            return FALSE;
        }
    }
}
