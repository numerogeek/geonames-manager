<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Geonames_manager extends Module {

	public $version = 0.1;
	public $module_name = "geonames_manager";

	public function info()
	{
		return array (
  'name' => 
  array (
    'en' => 'Geonames Manager',
    'fr' => 'Geonames Manager',
  ),
  'description' => 
  array (
    'en' => 'Handle the databases from Geonames',
    'fr' => 'Handle the databases from Geonames',
  ),
  'backend' => true,
  'plugin' => true,
  'menu' => 'utilities',
  'sections' => array(
	'geoname' => array(
		//'name' 	=> $this->module_name.':title:import',
		//'uri' 	=> 'admin/'.$this->module_name.'/import',
		'shortcuts' => array(
			'geoname:import' => array(
				'name' 	=> 'geoname:button:import',
				'uri' 	=> 'admin/'.$this->module_name.'/import',
				'class' => 'add'
				)
			)
		)
	),
);
	}

	public function install()
	{
		$this->load->driver('Streams');

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Add Streams - geoname
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $stream_slug = "geoname";
		if($this->streams->streams->add_stream('lang:'. $this->module_name.':title:'.$stream_slug,	$stream_slug,	 $this->module_name,	$this->module_name.'_',	null)==true)
		{
			$stream_id = $this->db->where('stream_namespace', $this->module_name)->where('stream_slug', $stream_slug)->limit(1)->get('data_streams')->row()->id;
			$this->db->insert('settings', array(
				'slug'			=> $stream_slug.'_stream_id',
				'title'			=> $this->module_name.' '.$stream_slug.' stream id',
				'description'	=>  $this->module_name.' '.$stream_slug.'stream id holder',
				'`default`'		=> '0',
				'`value`'		=> $stream_id,
				'type'			=> 'text',
				'`options`'		=> '',
				'is_required'	=> 1,
				'is_gui'		=> 0,
				'module'		=> $this->module_name
			));
			$stream_id=null;
		}


		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Add Fields Geoname
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$field_slug = "name";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 200
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "asciiname";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 200
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "alternatenames";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'textarea',
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "latitude";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 200
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "longitude";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 200
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "feature_class";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 1
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "feature_code";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 10
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "country_code";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 2
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "cc2";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 60
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}

		$field_slug = "admin1_code";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 20
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "admin2_code";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 80
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	
		
		$field_slug = "admin3_code";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 20
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	
		
		$field_slug = "admin4_code";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 20
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	
		
		$field_slug = "population";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 8
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "elevation";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 8
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "dem";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 8
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "timezone";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 40
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	

		$field_slug = "modification_date";
		if($this->db->where('field_namespace', $this->module_name)->where('field_slug', $field_slug)->limit(1)->get('data_fields')->num_rows()==null)
		{
			$field = array(
				'name'				=> 'lang:'.$this->module_name.':fields:'.$field_slug,
				'slug'				=> $field_slug,
				'namespace'			=> $this->module_name,
				'type'				=> 'text',
				'extra'				=> array(
					'max_length'		=> 40
				),
				'assign'			=> $stream_slug,
				'title_column'		=> false,
				'required'			=> false,
				'unique'			=> false
			);
			$this->streams->fields->add_field($field);
		}	
		return true;

	}

	public function uninstall()
	{
		$this->load->driver('Streams');
		$this->load->library('files/files');

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Delete the Uploads folder and remove its ID in the settings table
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if(Files::delete_folder(Settings::get($this->module_name.'_folder'))==true)
		{
			$this->db->delete('settings', array('module' => $this->module_name));
		}		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Remove Streams News
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$this->streams->utilities->remove_namespace($this->module_name);
		return true;
	}

	public function upgrade($old_version)
	{
		return TRUE;
	}

	public function help()
	{
	}
}
/* End of file details.php */
?>