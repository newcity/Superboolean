<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Superboolean - set one while unsetting all others in a channel
 *
 * @author Phil Pelanne
 */
class Superboolean_ft extends EE_Fieldtype {

    var $info = array(
        'name'      => 'SuperBoolean',
        'version'   => '1.0'
    );

    // --------------------------------------------------------------------
	/**
	 * Display Field in Control Panel
	 *
	 * @param string $data 
	 * @return void
	 */
    function display_field($data)
    {
		$options = array(
		                  '0|'.$this->EE->input->get('channel_id')  => 'No',
		                  '1|'.$this->EE->input->get('channel_id')    => 'Yes',
		);
		$output = form_dropdown($this->field_name, $options, $data);
		
		return $output; 
        
    }

	/**
	 * Unset all the other entries in the channel after save
	 *
	 * @param string $data 
	 * @return void
	 */
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
