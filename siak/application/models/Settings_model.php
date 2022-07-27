<?php 
Class Settings_model extends CI_Model
{
    public function getSettings()
    {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    } 
  
    public function updateSettings($data)
    {
        $q = $this->db->update('settings', $data);
      	if ($q) {
      		return TRUE;
      	}else
            return FALSE;
    } 
    public function getAccounts($numrows = false){
        $q = $this->db->get('accounts');

        if ($numrows == true && $q->num_rows() > 0) {
            return true;
        }elseif($q->num_rows() > 0){
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getAccountByID($id){
        $this->db->where('id', $id);
        $q = $this->db->get('accounts');
        return $q->row();
    }
    public function getAccountsOfLoggedInUser(){
        $user = $this->session->userdata('user');
        if ($user->all_accounts) {
            $q = $this->db->get('accounts');
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
        }else{
            $accessible = json_decode($user->accounts);
            $a = 0;
            while ($a < count($accessible)) {
                if ($a == 0) {
                    $this->db->where('id', $accessible[$a]);
                }
                $this->db->or_where('id', $accessible[$a]);
                $a++;
            }
            $q = $this->db->get('accounts');
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
        }
    }

    /* Add a Log entry */
    public function add_log($message, $level) {
        if ($this->mSettings->enable_logging !== 1) {
                return false;
        }
        $now = new DateTime();
        
        $logentry = array(
                'level'         => $level,
                'date'          => $now->format('Y-m-d H:i:s'),
                'host_ip'       => $_SERVER['REMOTE_ADDR'],
                'user_id'       => $this->session->userdata('user')->id,
                'url'           => current_url(),
                'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
                'message'       => $message,
        );
        $this->DB1->insert('logs', $logentry);
        return true;
    }
    public function getGroupPermissions($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTagNameByID($id)
    {
        $q = $this->DB1->get_where('tags', array('id'=>$id));
        if ($q->num_rows() > 0) {
            return $q->row()->title;
        }
        return 'No Tag';
    }
}
?>