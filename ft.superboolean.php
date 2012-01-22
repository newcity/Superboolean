<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Superboolean_ft extends EE_Fieldtype {

    var $info = array(
        'name'      => 'SuperBoolean',
        'version'   => '1.0'
    );

    // --------------------------------------------------------------------

    function display_field($data)
    {
		$options = array(
		                  '0|'.$this->EE->input->get('channel_id')  => 'No',
		                  '1|'.$this->EE->input->get('channel_id')    => 'Yes',
		);
		$output = form_dropdown($this->field_name, $options, $data);
		
		return $output; 
        
    }

	
	function post_save($data){
		if ($data) {
			list($superboolean,$channel_id) = explode('|', $data);
			if ($superboolean==1 && is_numeric($this->EE->input->post('channel_id')) && is_numeric($this->settings['entry_id']) ) {	
				$sql = 'update exp_channel_data set '.$this->field_name.' = \'\' where channel_id='.$this->EE->input->post('channel_id').' and entry_id != '.$this->settings['entry_id'];
				$query = $this->EE->db->query($sql);		
			}
		}
		
		
	}
}
