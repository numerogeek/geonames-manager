<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	protected $section ='geoname'; //is also the stream Slug
	protected $namespace = 'geonames_manager';

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('Streams');
        $this->lang->load('geonames_manager');
        $this->lang->load('import');
        $this->load->helper('import');
    }

    public function index()
    {
         $extra = 
         array(
         'title'				=> lang($this->namespace.':title:'.$this->section.':create'),
         'buttons' => array(
        array(
            'label'     => lang('global:edit'),
            'url'       => 'admin/'.$this->namespace.'/edit/-entry_id-'
        ),
        array(
            'label'     => lang('global:delete'),
            'url'       => 'admin/'.$this->namespace.'/delete/-entry_id-',
            'confirm'   => true
        )));

	     $this->streams->cp->entries_table($this->section, $this->namespace, $pagination = 50, $pagination_uri = '/admin/geonames_manager/index/', $view_override = true, $extra);
    }

    public function create()
	{
		
		$extra = array(
			'return'			=> 'admin/'.$this->namespace,
			'success_message'	=> lang($this->namespace.':messages:'.$this->section.':success:create'),
			'failure_message'	=> lang($this->namespace.':messages:'.$this->section.':failure:create'),
			'title'				=> lang($this->namespace.':title:'.$this->section.':create')
		);
		
		$this->streams->cp->entry_form($this->section, $this->namespace, 'new', NULL, $view_override = true, $extra);
	}

    public function edit($id)
    {

		$extra = array('title' =>  lang($this->namespace.':title:'.$this->section.':edit'),
		'success_message' => lang($this->namespace.':messages:'.$this->section.':edit:success'),
		'failure_message' => lang($this->namespace.':messages:'.$this->section.':edit:error'),
		'return'          => 'admin/'.$this->namespace.'/'.$this->section   );

  		echo $this->streams->cp->entry_form($this->section, $this->namespace, $mode = 'edit', $entry = $id, $view_override = true, $extra, $skips = array());
    }


    public function delete($id)
    {
        if($this->streams->entries->delete_entry($id, $this->section, $this->namespace)){
            $this->session->set_flashdata('success', lang($this->namespace.':messages:'.$this->section.':success:delete'));
        }else{
            $this->session->set_flashdata('error', lang($this->namespace.':messages:'.$this->section.':failure:delete'));
        }
        redirect('admin/'.$this->namespace.'/'.$this->section);
    }

    /**
     * Import file of cities
     *
     * @access  public
     * @return  void
     */
    public function import($id = false, $ready = false)
    {

        // what we doin?
        if ( $id )
        {
	       $data = _pre_import_csv($id); //helper        
	        // Unset the labels
	       // unset($data['entries'][0]);
	        $total = count($data['entries']);

	        // Build the batch
	        foreach ( $data['entries'] as $entry )
	        {
	            // A;dd..
	            $batch[] = array(
                    'id'    => $entry[0],
	                'created' => date('Y-m-d H:i:s'),
	                'created_by' => $this->current_user->id,
	                'ordering_count' => 0,
	                'name' => $entry[1],
	                'asciiname' => $entry[2],
	                'alternatenames' => $entry[3],
	                'latitude' => $entry[4],
	                'longitude' => $entry[5],
                    'feature_class' => $entry[6],
                    'feature_code' => $entry[7],
	                'country_code' => $entry[8],
	                'cc2' => $entry[9],
	                'admin1_code' => $entry[10],
	                'admin2_code' => $entry[11],
	                'admin3_code' => $entry[12],
	                'admin4_code' => $entry[13],
                    'population' => $entry[14],
	                'elevation' => $entry[15],
	                'dem' => $entry[16],
	                'timezone' => $entry[17],
	                'modification_date' => (isset($entry[4])?trim($entry[18]):null)
	                );
	        }

	       // Import them
	        batch_insert_update('geonames_manager_geoname', $batch, array('ordering_count'));

            // Way to go!
            $this->session->set_flashdata('success',lang('import:success_importation'));
            redirect('admin/geonames_manager');
        }
        else
        {
            // Chosen?
            if ( isset($_POST['file_id']) )
            {
                redirect(current_url().'/'.$_POST['file_id']);
                return false;
            }
            
            // Get files
	        $data['files'] = array();
       
	        //Query / loop
	        foreach($this->db->select('id, name')->where('extension', '.txt')->get('files')->result() as $row)
	        {
	            $data['files'][$row->id] = $row->name;
	        }	        
	        $this->template->build('admin/import/choose_csv', $data);
        }
    }


}
?>