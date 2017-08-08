<?php

class Site_model extends ResourceModel {

	private $CI;
	private $Delete;
	private $aqprodDB;

	function __construct()
	{
	    // Call the Model constructor
	    parent::__construct();
       //  $this->CI =& get_instance();
	    $this->aqprodDB = $this->load->database('aqprod_db', true);

		$this->Delete = 0;
	}


	function get_all_sites2() {

        return $this->aqprodDB->select('
                aq2e.site_num
			  , aq2e.company_name
			  , aq2e.address1_text
			  , aq2e.address2_text
			  , aq2e.city_text
			  , aq2e.state_text
			  , aq2e.zip_text
			  , aq2e.phone_text
			  , aq2e.fax_text
			  , aq2e.email_text
			  , aq2e.contact_fname
			  , aq2e.contact_lname
			  , aq2e.contact_fname + \' \' + aq2e.contact_lname AS AgentName
			  , aq2e.aq_site_url
			  , aq2e.aq_layout
			  , aq2e.aq_style
			  , aq2e.aq_site_loginId      
			  , aq2e.aq_site_pwrd
			  , aq2e.aq_admin_pwrd
			  , aq2e.aq_is_ga_yn
			  , aq2e.aq_ga_site_num
			  , aq2e.aq_site_url
			  , aq2e.facebook_link
			  , aq2e.twitter_link
			  , aq2e.site_title_text
			  , aq2e.header_choice
			  , sstatus.site_status_desc AS site_status
			  , aq2e.aq_trial_start_date
			  , aq2e.aq_trial_expire_date
			  , aq2e.aq_register_date
			  , aq2e.aq_site_cancel_date
			  , sd.subdomain AS subdomain
			  , gasite.contact_fname + \' \' + gasite.contact_lname AS GAgentName
			  , gasite.email_text AS GAEmail
			  , gasite.company_name AS GACompany_name        
        ')
        ->from('ins112_aq2e_site aq2e')
        ->join('inst113_ga_site_subdomain sd', 'sd.site_num = aq2e.aq_ga_site_num', 'inner')
        ->join('ins112_aq2e_site gasite', 'gasite.site_num = aq2e.aq_ga_site_num', 'inner')
        ->join('ins049_site_status_code sstatus', 'sstatus.site_status_code = aq2e.aq_site_status_code', 'inner')
        ->where( array('aq2e.aq_is_ga_yn' => 'N', 'aq2e.aq_site_status_code !=' => 33) )
        ->order_by( 'aq2e.aq_ga_site_num', 'ASC' )
        ->order_by( 'aq2e.site_num', 'ASC' )
        ->get();

	}

    /*
     * Get site by site_num
     */
    function get_site( $site_num )
    {
        $this->aqprodDB = $this->load->database('aqprod_db', true);

      //  $this->aqprodDB->conn_id->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $res = $this->aqprodDB->select('
                aq2e.site_num
			  , aq2e.company_name
			  , aq2e.address1_text
			  , aq2e.address2_text
			  , aq2e.city_text
			  , aq2e.state_text
			  , aq2e.zip_text
			  , aq2e.phone_text
			  , aq2e.fax_text
			  , aq2e.email_text
			  , aq2e.contact_fname
			  , aq2e.contact_lname
			  , aq2e.contact_fname + \' \' + aq2e.contact_lname AS AgentName
			  , aq2e.aq_site_url
			  , aq2e.aq_layout
			  , aq2e.aq_style
			  , aq2e.aq_site_loginId      
			  , aq2e.aq_site_pwrd
			  , aq2e.aq_admin_pwrd
			  , aq2e.aq_is_ga_yn
			  , aq2e.aq_ga_site_num
			  , aq2e.aq_site_url
			  , aq2e.facebook_link
			  , aq2e.twitter_link
			  , aq2e.site_title_text
			  , aq2e.header_choice
			  , sstatus.site_status_desc AS site_status
			  , aq2e.aq_trial_start_date
			  , aq2e.aq_trial_expire_date
			  , aq2e.aq_register_date
			  , aq2e.aq_site_cancel_date
			  , sd.subdomain AS subdomain
			  , gasite.contact_fname + \' \' + gasite.contact_lname AS GAgentName
			  , gasite.email_text AS GAEmail
			  , gasite.company_name AS GACompany_name        
        ')
            ->from('ins112_aq2e_site aq2e')
            ->join('inst113_ga_site_subdomain sd', 'sd.site_num = aq2e.aq_ga_site_num', 'inner')
            ->join('ins112_aq2e_site gasite', 'gasite.site_num = aq2e.aq_ga_site_num', 'inner')
            ->join('ins049_site_status_code sstatus', 'sstatus.site_status_code = aq2e.aq_site_status_code', 'inner')
            ->where( array( 'aq2e.site_num' => intval($site_num), 'aq2e.aq_is_ga_yn' => 'N', 'aq2e.aq_site_status_code !=' => 33 ) )
            ->order_by( 'aq2e.aq_ga_site_num', 'ASC' )
            ->order_by( 'aq2e.site_num', 'ASC' )->get();

            $res = $res->result_array();

        return $res[ 0 ];

      //  echo $this->aqprodDB->last_query();
    }

    /*
     * Get all sites
     */
    function get_all_sites()
    {
        return $this->aqprodDB->get('ins112_aq2e_site')->result_array();
    }

    /*
     * function to add new site
     */
    function add_site($params)
    {
        $this->aqprodDB->insert('ins112_aq2e_site',$params);
        return $this->db->insert_site_num();
    }

    /*
     * function to update site
     */
    function update_site($site_num,$params)
    {
        $this->aqprodDB->where('site_num',$site_num);
        $response = $this->aqprodDB->update('ins112_aq2e_site',$params);
        if($response)
        {
            return "site updated successfully";
        }
        else
        {
            return "Error occuring while updating site";
        }
    }

    /*
     * function to delete site
     */
    function delete_site($site_num)
    {
        $response = $this->aqprodDB->delete('ins112_aq2e_site',array('site_num'=>$site_num));
        if($response)
        {
            return "site deleted successfully";
        }
        else
        {
            return "Error occuring while deleting site";
        }
    }
	
}
?>