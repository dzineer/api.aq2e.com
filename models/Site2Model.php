<?php

class Site2Model extends ResourceModel {

	private $CI;

	function __construct()
	{
	    // Call the Model constructor
	    parent::__construct();

		$this->Delete = 0;
		$this->CI =& get_instance();
		$this->mssql = $this->load->database ( 'my_mssql', TRUE );
	}

	function search( $siteNum ) {
		
		$this->results = array();
		
		$tsql = sprintf("
			SELECT aq2e.site_num
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
			, aq2e.contact_fname + ' ' + aq2e.contact_lname AS AgentName
			, aq2e.site_title_text
			, aq2e.aq_site_url
			, aq2e.aq_layout
			, aq2e.aq_style
			, aq2e.aq_site_loginId
			, aq2e.aq_site_pwrd
			, aq2e.aq_admin_pwrd
			, aq2e.aq_trial_start_date
			, aq2e.aq_trial_expire_date
			, (CASE WHEN aq2e.aq_trial_expire_date IS NULL
			THEN
				0
			ELSE
				DATEDIFF(day, GETDATE(), aq2e.aq_trial_expire_date)
			END ) AS daysLeft
			, aq2e.aq_is_ga_yn
			, aq2e.aq_ga_site_num
			, aq2e.aq_site_url
			, aq2e.facebook_link
			, aq2e.twitter_link
			, aq2e.site_title_text
			, aq2e.header_choice
			, aq2e.logo_option
			, sd.subdomain AS subdomain
			, gasite.contact_fname + ' ' + gasite.contact_lname AS GAgentName
			, gasite.email_text AS GAEmail
			, gasite.company_name AS GACompany_name
			
			FROM [aqprod].[dbo].[ins112_aq2e_site] aq2e
			INNER JOIN [aqprod].[dbo].[inst113_ga_site_subdomain] sd ON (sd.site_num = aq2e.aq_ga_site_num)
			INNER JOIN [aqprod].[dbo].[ins112_aq2e_site] gasite ON (gasite.site_num = aq2e.aq_ga_site_num)
			WHERE aq2e.site_num = %s AND aq2e.aq_site_status_code <> 33", $siteNum);

		//print "<pre>tsql: ".$tsql;
		//print "<br>";
		//exit(0);
		
		$query = $this->mssql->query( $tsql );
		
	    foreach ( $query->result_array() as $row ){
	        $this->results[] = $row;
	       // print print_r($this->results,true);
	    }
		
        $this->results = array_pop($this->results);
        return $this->results;
	}

    function getAll() {
        $this->results = array();

        $tsql = "
            SELECT aq2e.site_num
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
              , aq2e.contact_fname + ' ' + aq2e.contact_lname AS AgentName
              , aq2e.site_title_text
              , aq2e.aq_site_url
              , aq2e.aq_layout
              , aq2e.aq_style
              , aq2e.aq_site_loginId
              , aq2e.aq_site_pwrd
              , aq2e.aq_admin_pwrd
              , aq2e.aq_trial_start_date
              , aq2e.aq_trial_expire_date
              , (CASE WHEN aq2e.aq_trial_expire_date IS NULL
                THEN
                    0
                ELSE
                    DATEDIFF(day, GETDATE(), aq2e.aq_trial_expire_date)
                END ) AS daysLeft
              , aq2e.aq_is_ga_yn
              , aq2e.aq_ga_site_num
              , aq2e.aq_site_url
              , aq2e.facebook_link
              , aq2e.twitter_link
              , aq2e.site_title_text
              , aq2e.header_choice
              , aq2e.logo_option
              , sd.subdomain AS subdomain
              , gasite.contact_fname + ' ' + gasite.contact_lname AS GAgentName
              , gasite.email_text AS GAEmail
              , gasite.company_name AS GACompany_name
              
              FROM [aqprod].[dbo].[ins112_aq2e_site] aq2e
              INNER JOIN [aqprod].[dbo].[inst113_ga_site_subdomain] sd ON (sd.site_num = aq2e.aq_ga_site_num)
              INNER JOIN [aqprod].[dbo].[ins112_aq2e_site] gasite ON (gasite.site_num = aq2e.aq_ga_site_num)
              WHERE aq2e.aq_site_status_code <> 33";

        //print "<pre>tsql: ".$tsql;
        //print "<br>";
        //exit(0);

        /* Execute the query. */
        $query = $this->mssql->query($tsql);
	
        foreach ( $query->result_array() as $row ){
	        $this->results[] = $row;
	        // print print_r($this->results,true);
        }
        
        return $this->results;
    }	
	
}
?>