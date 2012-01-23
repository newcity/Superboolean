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
	 * @access	public
	 * @param string $data 
	 * @return string $output
	 */
    function display_field($data)
    {
		$options = array(
		                  '0|'.$this->EE->input->get('channel_id')  => $this->settings['false_label'],
		                  '1|'.$this->EE->input->get('channel_id')    => $this->settings['true_label'],
		);
		$output = form_dropdown($this->field_name, $options, $data);
		
		return $output; 
        
    }

	/**
	 * Unset all the other entries in the channel after save
	 *
	 * @access	public
	 * @param string $data 
	 * @return void
	 */
	function post_save($data){
		if ($data) {
			list($superboolean,$channel_id) = explode('|', $data);
			if ($superboolean==1 && is_numeric($this->EE->input->post('channel_id')) && is_numeric($this->settings['entry_id']) ) {	
				$this->EE->db->where('channel_id', $this->EE->input->post('channel_id'));
				$this->EE->db->where('entry_id !=', $this->settings['entry_id']);
				$this->EE->db->update('exp_channel_data', array($this->field_name => ''));
			}
		}
	}
	
	
	/**
	 * Display Settings Screen - allow admin to set meaningful lables for boolean
	 *
	 * @access	public
	 * @return	default global settings
	 *
	 */
	function display_settings($data)
	{
		$true_label	= isset($data['true_label']) ? $data['true_label'] : 'Yes';
		$false_label	= isset($data['false_label']) ? $data['false_label'] : 'No';

		$this->EE->table->add_row(
			lang('True Label','true_label'),
			form_input('true_label', $true_label)
		);
		
		$this->EE->table->add_row(
			lang('False Label','false_label'),
			form_input('false_label', $false_label)
		);
		
	}
	
	// --------------------------------------------------------------------

	/**
	 * Save Settings - saves individual settings to database
	 *
	 * @access	public
	 * @return	field settings
	 *
	 */
	function save_settings($data)
	{
		return array(
			'true_label'	=> $this->EE->input->post('true_label'),
			'false_label'	=> $this->EE->input->post('false_label'),
		);
	}
	
}
