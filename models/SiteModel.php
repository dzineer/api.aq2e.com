<?php

class SiteModel extends ResourceModel {

	private $CI;

	function __construct()
	{
	    // Call the Model constructor
	    parent::__construct();

		$this->Delete = 0;
		$this->CI =& get_instance();
		$this->CI->load->library('dbi');
	}

	function initDB($dbConf, $returnDatesAsString=false)
	{
//		print '<pre>dbConf SubscribersModel: '.print_r($dbConf,true);
		$this->serverName = $dbConf->serverName;
		$this->dbUser = $dbConf->dbUser;
		$this->dbPassword = $dbConf->dbPassword;
		$this->dbName = $dbConf->dbName;

		$this->CI->dbi->init($this->serverName, $this->dbUser, $this->dbPassword, true);
	//	$this->CI->dbi->connect($this->dbName);
	}

	function connectDB($dbName)
	{
		$this->CI->dbi->connect($dbName);
	}

	function adminHijack($agentId) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2esite.site_num AS AQSiteNumber, aq2esite.aq_site_status_code, aq2esite.aq_ga_site_num AS GASiteNum, gasite.subdomain
							 FROM ins112_aq2e_site aq2esite INNER JOIN inst113_ga_site_subdomain gasite
							 ON (aq2esite.aq_ga_site_num = gasite.site_num)
							 WHERE aq_site_loginId = '%s'", $agentId);
					//		 " AND (aq2esite.aq_site_status_code = 10 OR aq2esite.aq_site_status_code = 11)".
						//	 " AND (gasite.site_status_code = 10 OR gasite.site_status_code = 11)", $agentId);

			//print "<pre>tsql: ".$tsql;
		    //print "<br>";
		    // exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3. adminHijack\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function superAdminHijackGet($siteNum) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
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
		  , sd.subdomain AS subdomain
		  , gasite.contact_fname + ' ' + gasite.contact_lname AS GAgentName
		  , gasite.email_text AS GAEmail
		  , gasite.company_name AS GACompany_name
		  
		  FROM [aqprod].[dbo].[ins112_aq2e_site] aq2e
		  INNER JOIN [aqprod].[dbo].[inst113_ga_site_subdomain] sd ON (sd.site_num = aq2e.aq_ga_site_num)
		  INNER JOIN [aqprod].[dbo].[ins112_aq2e_site] gasite ON (gasite.site_num = aq2e.aq_ga_site_num)
		  WHERE aq2e.site_num = %s ", $siteNum);

			//print "<pre>tsql: ".$tsql;
			//print "<br>";
			//exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function superAdminHijack($adminId, $agentId) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2esite.site_num AS AQSiteNumber, aq2esite.aq_site_status_code, aq2esite.aq_site_loginId, aq2esite.aq_ga_site_num AS GASiteNum, gasite.aq_site_loginId, gasite.site_num, gaSubDomain.subdomain
							 FROM ins112_aq2e_site aq2esite 
							 INNER JOIN ins112_aq2e_site gasite ON (aq2esite.aq_ga_site_num = gasite.site_num)
							 INNER JOIN inst113_ga_site_subdomain gaSubDomain ON (gasite.site_num = gaSubDomain.site_num)
							 WHERE aq2esite.aq_site_loginId = '%s' AND gasite.aq_site_loginId = '%s'", $agentId, $adminId);

			print "<pre>tsql: ".$tsql;
		    print "<br>";
		    // exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3. superAdminHijack\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function superHijack($loginId) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2esite.site_num AS AQSiteNumber, aq2esite.aq_site_loginId, aq2esite.aq_site_status_code, aq2esite.aq_ga_site_num AS GASiteNum, gasite.subdomain
							 FROM ins112_aq2e_site aq2esite INNER JOIN inst113_ga_site_subdomain gasite
							 ON (aq2esite.site_num = gasite.site_num)
							 WHERE aq2esite.aq_site_loginId = '%s'", $loginId);

			//print "<pre>tsql: ".$tsql;
		    //print "<br>";
		    //exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3. superHijack\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);

	}

	function superLogin($loginId, $password) {


		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT [userId],[passwd] FROM [aqprod].[dbo].[ins132_bp_accounts]
							 WHERE [userId] = '%s'" .
							 " AND [passwd] = '%s'", $loginId, MD5($password));

			print "<pre>tsql: ".$tsql;
		    print "<br>";
		    //exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3. superLogin\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			// $this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function adminLogin($loginId, $password) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2esite.site_num AS AQSiteNumber, aq2esite.aq_site_status_code, aq2esite.aq_ga_site_num AS GASiteNum, gasite.subdomain
							 FROM ins112_aq2e_site aq2esite INNER JOIN inst113_ga_site_subdomain gasite
							 ON (aq2esite.site_num = gasite.site_num)
							 WHERE aq_site_loginId = '%s'" .
							 " AND aq_site_pwrd = '%s' AND aq2esite.aq_is_ga_yn = 'Y'", $loginId, MD5($password));

			//print "<pre>tsql: ".$tsql;
		    //print "<br>";
		    //exit(0);
/*
			if($_SERVER['REMOTE_ADDR'] == '64.239.131.130') {
			  printf("<pre><br/>result: %s", $tsql);
			  exit(0);
			}
*/
			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3. adminLogin\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function validateBasicLoginNoMD5Password($loginId, $password) {


		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2esite.site_num AS AQSiteNumber, aq2esite.aq_site_status_code, aq2esite.aq_ga_site_num AS GASiteNum, gasite.subdomain
							 FROM ins112_aq2e_site aq2esite INNER JOIN inst113_ga_site_subdomain gasite
							 ON (aq2esite.aq_ga_site_num = gasite.site_num)
							 WHERE aq_site_loginId = '%s' " .
							 " AND aq2esite.aq_is_ga_yn = 'N' ".
							 " AND aq_site_pwrd = '%s' AND (aq2esite.aq_site_status_code = 10 OR aq2esite.aq_site_status_code = 11)".
							 " AND (gasite.site_status_code = 10 OR gasite.site_status_code = 11) AND aq2esite.aq_site_status_code <> 33", $loginId, MD5($password));

		   //	print "<pre>tsql: ".$tsql;
		   //   print "<br>";
		   //   exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3. validateBasicLogin\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function validateBasicLogin($loginId, $password) {


		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2esite.site_num AS AQSiteNumber, aq2esite.aq_site_status_code, aq2esite.aq_ga_site_num AS GASiteNum, gasite.subdomain
							 FROM ins112_aq2e_site aq2esite INNER JOIN inst113_ga_site_subdomain gasite
							 ON (aq2esite.aq_ga_site_num = gasite.site_num)
							 WHERE aq_site_loginId = '%s' " .
							 " AND aq2esite.aq_is_ga_yn = 'N' ".
							 " AND aq_site_pwrd = '%s' AND (aq2esite.aq_site_status_code = 10 OR aq2esite.aq_site_status_code = 11)".
							 " AND (gasite.site_status_code = 10 OR gasite.site_status_code = 11) AND aq2esite.aq_site_status_code <> 33", $loginId, MD5($password));

		   //	print "<pre>tsql: ".$tsql;
		   //   print "<br>";
		   //   exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3. validateBasicLogin\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function validate($loginId, $password) {


		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2esite.site_num AS AQSiteNumber, aq2esite.aq_site_status_code, aq2esite.aq_ga_site_num AS GASiteNum, gasite.subdomain
							 FROM ins112_aq2e_site aq2esite INNER JOIN inst113_ga_site_subdomain gasite
							 ON (aq2esite.aq_ga_site_num = gasite.site_num)
							 WHERE aq_site_loginId = '%s' " .
							 " AND aq2esite.aq_is_ga_yn = 'Y' ".
							 "AND aq_site_pwrd = '%s' AND (aq2esite.aq_site_status_code = 10 OR aq2esite.aq_site_status_code = 11)".
							 "AND (gasite.site_status_code = 10 OR gasite.site_status_code = 11) AND aq2esite.aq_site_status_code <> 33", $loginId, MD5($password));

		//	print "<pre>tsql: ".$tsql;
		//   print "<br>";
		   // exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function getRegisteredSite($Site_Num) {


		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT site_num, aq_site_status_code FROM ins112_aq2e_site WHERE site_num = 15047 AND (aq_site_status_code = 10 OR aq_site_status_code = 11) aq_site_status_code <> 33", $Site_Num);

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function getRegisteredAgents() {


		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2e.site_num
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
			  , gasite.contact_fname + ' ' + gasite.contact_lname AS GAgentName
			  , gasite.email_text AS GAEmail
			  , gasite.company_name AS GACompany_name
			  
			  FROM [aqprod].[dbo].[ins112_aq2e_site] aq2e
			  INNER JOIN [aqprod].[dbo].[inst113_ga_site_subdomain] sd ON (sd.site_num = aq2e.aq_ga_site_num)
			  INNER JOIN [aqprod].[dbo].[ins112_aq2e_site] gasite ON (gasite.site_num = aq2e.aq_ga_site_num)
			  INNER JOIN [aqprod].[dbo].[ins049_site_status_code] sstatus ON (sstatus.site_status_code = aq2e.aq_site_status_code)
			  WHERE aq2e.aq_is_ga_yn = 'N' AND aq2e.aq_site_status_code <> 33
			   ORDER BY aq2e.aq_ga_site_num, aq2e.site_num ASC");

			//print "tsql: ".$tsql;
			//print "<br>";

			//exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return $this->results;
	}
	
	function getRegisteredAgentsByBGA($bga) {


		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2e.site_num
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
			  , aq2e.company_name
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
			  , gasite.contact_fname + ' ' + gasite.contact_lname AS GAgentName
			  , gasite.email_text AS GAEmail
			  , gasite.company_name AS GACompany_name
			  
			  FROM [aqprod].[dbo].[ins112_aq2e_site] aq2e
			  INNER JOIN [aqprod].[dbo].[inst113_ga_site_subdomain] sd ON (sd.site_num = aq2e.aq_ga_site_num)
			  INNER JOIN [aqprod].[dbo].[ins112_aq2e_site] gasite ON (gasite.site_num = aq2e.aq_ga_site_num)
			  INNER JOIN [aqprod].[dbo].[ins049_site_status_code] sstatus ON (sstatus.site_status_code = aq2e.aq_site_status_code)
			  WHERE aq2e.aq_is_ga_yn = 'N' AND gasite.company_name = '%s' aq2e.aq_site_status_code <> 33
			   ORDER BY aq2e.aq_ga_site_num, aq2e.site_num ASC", $bga);

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return $this->results;
	}	

	function getRegisteredBGAs2() {


		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT aq2e.site_num,
				   aq2e.company_name,
				   aq2e.address1_text,
				   aq2e.address2_text,
				   aq2e.city_text,
				   aq2e.state_text,
				   aq2e.zip_text,
				   aq2e.phone_text,
				   aq2e.fax_text,
				   aq2e.email_text,
				   aq2e.contact_fname,
				   aq2e.contact_lname,
				   aq2e.contact_fname + ' ' + aq2e.contact_lname AS AgentName,
				   aq2e.aq_site_url,
				   aq2e.aq_layout,
				   aq2e.aq_style,
				   aq2e.aq_site_loginId,
				   aq2e.aq_site_pwrd,
				   aq2e.aq_admin_pwrd,
				   aq2e.aq_is_ga_yn,
				   aq2e.aq_ga_site_num,
				   aq2e.aq_site_url,
				   aq2e.facebook_link,
				   aq2e.twitter_link,
				   aq2e.site_title_text,
				   aq2e.header_choice,
				   sstatus.site_status_desc AS site_status,
				   aq2e.aq_trial_start_date,
				   aq2e.aq_trial_expire_date,
				   aq2e.aq_register_date,
				   aq2e.aq_site_cancel_date,
				   sd.subdomain AS subdomain,
				   gasite.contact_fname + ' ' + gasite.contact_lname AS GAgentName,
				   gasite.email_text AS GAEmail,
				   gasite.company_name AS GACompany_name,
				   st.[site_type_id],
				   st.[site_num],
				   st.[site_type],
				   st.[created_on]
			FROM [aqprod].[dbo].[ins112_aq2e_site] aq2e
			INNER JOIN [aqprod].[dbo].[inst113_ga_site_subdomain] sd ON (sd.site_num = aq2e.aq_ga_site_num)
			INNER JOIN [aqprod].[dbo].[ins172_site_type] st ON (st.site_num = aq2e.site_num)
			INNER JOIN [aqprod].[dbo].[ins112_aq2e_site] gasite ON (gasite.site_num = aq2e.aq_ga_site_num)
			INNER JOIN [aqprod].[dbo].[ins049_site_status_code] sstatus ON (sstatus.site_status_code = aq2e.aq_site_status_code) 
			WHERE aq2e.aq_is_ga_yn = 'Y' AND aq2e.aq_site_status_code <> 33
			 ORDER BY aq2e.site_num ASC");

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return $this->results;
	}
	
	
	function getRegisteredBGAs() {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT site_num, aq_site_loginId, aq_site_pwrd, email_text, contact_fname, contact_lname FROM ins112_aq2e_site WHERE (aq_site_status_code = 10 OR aq_site_status_code = 11) AND aq_is_ga_yn = 'Y'");

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return $this->results;
	}

	function checkAvailableAccount($loginID, $GASiteID) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			// aq_site_loginId, aq_site_pwd
			
			$tsql = sprintf("SELECT site_num, aq_site_loginId, aq_site_pwrd, email_text, contact_fname + ' ' + contact_lname AS name FROM ins112_aq2e_site WHERE (aq_site_loginId = '%s' AND aq_ga_site_num = '%s') AND (aq_site_status_code = 10 OR aq_site_status_code = 11)", $loginID, $GASiteID);

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		
		if(count($this->results) == 0) {
			return NULL;
		}
		
		return array_pop($this->results);

	}

	function getBGASiteAccount($loginID) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			// aq_site_loginId, aq_site_pwd
			
			$tsql = sprintf("SELECT site_num, aq_site_loginId, aq_site_pwrd, email_text, contact_fname + ' ' + contact_lname AS name FROM ins112_aq2e_site WHERE aq_site_loginId = '%s' AND aq_is_ga_yn = 'Y' AND (aq_site_status_code = 10 OR aq_site_status_code = 11)", $loginID);

		//	print "tsql: ".$tsql;
		//	print "<br>";

			  
		/*	if($_SERVER['REMOTE_ADDR'] == '64.239.131.130') {
					print "tsql: ".$tsql;
					print "<br>";
			} */

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		
		if(count($this->results) == 0) {
			return NULL;
		}
		
		return array_pop($this->results);
	}

	function getSiteAccount($loginID) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			// aq_site_loginId, aq_site_pwd
			
			$tsql = sprintf("SELECT site_num, aq_site_loginId, aq_site_pwrd, email_text, contact_fname + ' ' + contact_lname AS name FROM ins112_aq2e_site WHERE aq_site_loginId = '%s' AND (aq_site_status_code = 10 OR aq_site_status_code = 11)", $loginID);

		//	print "tsql: ".$tsql;
		//	print "<br>";

			  
		/*	if($_SERVER['REMOTE_ADDR'] == '64.239.131.130') {
					print "tsql: ".$tsql;
					print "<br>";
			} */

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		
		if(count($this->results) == 0) {
			return NULL;
		}
		
		return array_pop($this->results);
	}

	function tagAgent($SiteNum, $tagState) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE [aqprod].[dbo].[ins112_aq2e_site]
						      SET
						      aq_tagged = %s
						      WHERE site_num = %s", $tagState, $SiteNum);

			//print "tsql: ".$tsql; exit(0);
		    //print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}
		}
	}

    // disable agent, where only we can restore them.
    // As far as the GA is concerned, the agent will have been removed.
	function removeAgent($SiteNum) {
		$this->results = array();
	//	$this->initDB(true);
		return $this->updateAgentStatus($SiteNum, '33');
	}

	function enableAgent($SiteNum) {
		$this->results = array();
	//	$this->initDB(true);
		return $this->updateAgentStatus($SiteNum, '10');
	}

	function disableAgent($SiteNum) {
		$this->results = array();
	//	$this->initDB(true);
		return $this->updateAgentStatus($SiteNum, '22');
	}

	function updateAgentStatus($SiteNum, $status) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE [aqprod].[dbo].[ins112_aq2e_site]
						      SET
						      aq_site_status_code = %s
						      WHERE site_num = %s", $status, $SiteNum);

			//print "tsql: ".$tsql; exit(0);
		    //print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}
		}
	}

	function getAgents($GASiteNum) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT 
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
						      , aq2e.contact_fname + ' ' + aq2e.contact_lname AS AgentName
						      , aq2e.aq_site_url
						      , aq2e.aq_layout
						      , aq2e.aq_style
						      , aq2e.aq_site_loginId
						      , aq2e.aq_site_pwrd
						      , aq2e.aq_admin_pwrd
						      , aq2e.aq_is_ga_yn
						      , aq2e.aq_ga_site_num
						      , aq2e.aq_site_url
						      , aq2e.aq_tagged
						      , aq2e.aq_site_status_code
							  , aq2e.site_title_text
							  , aq2e.header_choice
							  , aq2e.aq_trial_start_date
							  , aq2e.aq_trial_expire_date
							  , aq2e.aq_register_date							  
							  , lbls.LabelId
							  , ISNULL(lbls.LabelName, 'NO TAG') AS LabelName							  
							  
						      FROM [aqprod].[dbo].[ins112_aq2e_site] aq2e 
							  
							  LEFT JOIN ins120_ga_label_agent_map agent_map ON(agent_map.site_num = %s AND agent_map.agent_site_num = aq2e.site_num)
							  LEFT JOIN ins121_GALabels lbls ON(lbls.LabelId = agent_map.labelId)
						  
							  WHERE aq2e.aq_ga_site_num = %s 
							  AND aq2e.aq_is_ga_yn = 'N'
							  AND aq2e.aq_site_status_code <> 33", $GASiteNum, $GASiteNum);

			//print "<pre>tsql: ".$tsql;
			//print "<br>";
			//exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return $this->results;
	}

	function getAgent($agentName, $gaSiteNo) {
		$this->results = array();
		$count = 0;
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT TOP 1
							    site2.site_num
						      , site2.company_name
						      , site2.address1_text
						      , site2.address2_text
						      , site2.city_text
						      , site2.state_text
						      , site2.zip_text
						      , site2.phone_text
						      , site2.fax_text
						      , site2.email_text
						      , site.contact_fname + ' ' + site.contact_lname
						      , site2.contact_fname + ' ' + site2.contact_lname AS AgentName
							  , site2.contact_fname + site2.contact_lname AS AgentDomain
						      , site2.aq_layout
						      , site2.aq_style
						      , site2.aq_site_loginId
						      , site2.aq_site_pwrd
						      , site2.aq_admin_pwrd
						      , site2.aq_is_ga_yn
						      , site2.aq_ga_site_num
						      , site2.aq_site_url
						      , site2.aq_tagged
						      , site2.aq_site_status_code
							  , site2.site_title_text
  							  , site2.header_choice

							  
						      FROM [aqprod].[dbo].[ins112_aq2e_site] site 
							  
							  INNER JOIN [aqprod].[dbo].[ins112_aq2e_site] site2 ON (site.site_num = site2.site_num)
							  
							  WHERE site.aq_ga_site_num = %s 
							  AND site.aq_is_ga_yn = 'N'
							  AND REPLACE (site2.contact_fname, ' ', '' ) + REPLACE (site2.contact_lname, ' ', '' ) LIKE('%s') 
							  AND site.aq_site_status_code <> 33", $gaSiteNo, $agentName);

			//print "<pre>tsql: ".$tsql;
			//print "<br>";
			//exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
					$count++;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		
		if($count == 1) {
			return array_pop($this->results);
		}
		else {
			return null;			
		}
	}

	function search( $siteNum ) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
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

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
        $this->results = array_pop($this->results);
        return $this->toJSON();
	}

    function getAll() {
        $this->results = array();
        //	$this->initDB(true);
        $this->CI->dbi->connect($this->dbName);

        if($this->CI->dbi->isConnected())
        {
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
            $stmt = $this->CI->dbi->query($tsql);
            if( $stmt === false )
            {
                echo "Error in executing statement 3.\n";
                die( print_r( sqlsrv_errors(), true));
            }

            do {
                while ($row = $this->CI->dbi->fetch_array()){
                    $this->results[] = $row;
                    // print print_r($this->results,true);
                }
            }
            while ( $this->CI->dbi->next_result() );

            /*Free the statement and connection resources. */
            $this->CI->dbi->free_stmt();
            // $this->CI->dbi->close();
        }
        return $this->toJSON();
    }	

	function getNoPrePasswordMD5($siteNum) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
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

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			// $this->CI->dbi->close();
		}
		return array_pop($this->results);
	}

	function updateGAProfileContact($siteNum, $company, $fname, $lname, $email, $phone) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET
			[company_name]='%s',
			[contact_fname]='%s',
			[contact_lname]='%s',
			[email_text]='%s',
			[phone_text]='%s'
			WHERE site_num=%s",

			 $company, $fname, $lname, $email, $phone, $siteNum) ;

	//		print "tsql: ".$tsql;
	//		print "<br>";
   //			exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}
	
	function updateLogin($siteNum, $pwd) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		$pwd = md5($pwd);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET
			  aq_site_pwrd = '%s'
			 WHERE site_num=%s", $pwd, $siteNum) ;

//			print "tsql: ".$tsql;
//			print "<br>";
//   			exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}	

	function updateSiteTitle($siteNum, $title) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET
			  site_title_text = '%s'
			 WHERE site_num=%s", $title, $siteNum) ;

//			print "tsql: ".$tsql;
//			print "<br>";
//   			exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}

	function updateHeaderChoice($siteNum, $choice) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);


		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET
			  header_choice = %s
			 WHERE site_num=%s", $choice, $siteNum) ;

//			print "tsql: ".$tsql;
//			print "<br>";
//   			exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}

    function updateLogoOption($siteNum, $option) {
        $this->results = array();
        //	$this->initDB(true);
        $this->CI->dbi->connect($this->dbName);


        if($this->CI->dbi->isConnected())
        {
            $tsql = sprintf("UPDATE ins112_aq2e_site SET
			  logo_option = '%s'
			 WHERE site_num=%s", $option, $siteNum) ;

//			print "tsql: ".$tsql;
//			print "<br>";
//   			exit(0);

            /* Execute the query. */
            $stmt = $this->CI->dbi->query($tsql);
            if( $stmt === false )
            {
                echo "Error in executing statement 3.\n";
                die( print_r( sqlsrv_errors(), true));
            }

            /*Free the statement and connection resources. */
            // $this->CI->dbi->close();
        }
    }

	function updateProfileContact($siteNum, $companyName, $fname, $lname, $email, $phone) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET
			[company_name]='%s',
			[contact_fname]='%s',
			[contact_lname]='%s',
			[email_text]='%s',
			[phone_text]='%s'
			
			WHERE site_num=%s",

			 $companyName, $fname, $lname, $email, $phone, $siteNum);

			//print "tsql: ".$tsql;
			//print "<br>";
   			//exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}


	function updateProfileFacebookAndTwitter($siteNum, $facebook, $twitter) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET
			[facebook_link]='%s',
			[twitter_link]='%s'
			
			WHERE site_num=%s",

			 $facebook, $twitter, $siteNum);

			//print "tsql: ".$tsql;
			//print "<br>";
   			//exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}

	function updateProfileAddr($siteNum, $street, $city, $state, $zip) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET
			[address1_text]='%s',
			[city_text]='%s',
			[state_text]='%s',
			[zip_text]='%s'
			WHERE site_num=%s",

			 $street, $city, $state, $zip, $siteNum) ;

	//		print "tsql: ".$tsql;
	//		print "<br>";
   //			exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}

	function updateWebAddr($siteNum, $url) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET
			[aq_site_url]='%s'
			WHERE site_num=%s",

			 $url, $siteNum) ;

	//		print "tsql: ".$tsql;
	//		print "<br>";
   //			exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}

	function enableSite($siteNum) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET [aq_site_status_code] = 10 
			                  WHERE site_num=%s", $siteNum) ;

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			$this->CI->dbi->close();
		}			
	}

	function disableSite($siteNum) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET [aq_site_status_code] = 33 
			                  WHERE site_num=%s", $siteNum) ;

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}			
	}
	
	function clearTrialState($siteNum) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET [aq_trial_start_date] = NULL
			                                           , [aq_trial_expire_date] = NULL 
			                  WHERE site_num=%s", $siteNum) ;

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}			
	}	

	function setRegisteredDate($siteNum) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET [aq_register_date] = GETDATE() WHERE site_num=%s", $siteNum) ;

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}			
	}	

	function update($siteNum, $data) {
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("UPDATE ins112_aq2e_site SET [address1_text]='%s',
			[city_text]='%s',
			[state_text]='%s',
			[zip_text]='%s',
			[phone_text]='%s',
			[company_name]='%s',
			[email_text]='%s',
			[contact_fname]='%s',
			[contact_lname]='%s',
			[aq_site_loginId]='%s',
			[aq_site_pwrd]='%s',
			[aq_is_ga_yn]='%s',
		    [aq_site_url]='%s',
			[aq_ga_site_num]='%s',
			[aq_register_date] = getdate()
			
			WHERE site_num=%s",

			  $data->Address1,$data->City,$data->StateName,$data->Zipcode,
			  $data->PHNUM, $data->CompanyName, $data->Email,$data->FirstName,$data->LastName,
			  $data->LoginId, $data->Password, $data->isGA, $data->Domain, $data->GASiteNum, $siteNum) ;

		//	print "tsql: ".$tsql;
		//	print "<br>";

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
				 print "<pre>tsql: ".print_r($siteNum,true);
				 print "<pre>tsql: ".$tsql;
			     die( print_r( sqlsrv_errors(), true));
			}

			/*Free the statement and connection resources. */
			// $this->CI->dbi->close();
		}
	}

	function getUser($siteNum, $gaSiteNum) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql = sprintf("SELECT site_num, aq_site_status_code, zip_text, phone_text, contact_fname, contact_lname, contact_fname + ' ' + contact_lname AS fullname, aq_site_loginId
			                   FROM ins112_aq2e_site ".
							 " WHERE site_num = %s ".
							 "  AND aq_is_ga_yn = 'N' ".
							 " AND aq_ga_site_num = %s" .
							 " AND (aq_site_status_code = 10 OR aq_site_status_code = 11)",
							 $siteNum, $gaSiteNum);

		   // print "<pre>tsql: ".$tsql;
		   // print "<br>";
		   // exit(0);

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( sqlsrv_errors(), true));
			}

			do {
			    while ($row = $this->CI->dbi->fetch_array()){
			        $this->results[] = $row;
			       // print print_r($this->results,true);
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
		//	$this->CI->dbi->close();
		}
		return array_pop($this->results);

	}		
}
?>