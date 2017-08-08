<?php

class Aqtqe2011 extends CI_Model {

	var $Banner; var $CompanyFK; var $Description; var $PolicyDetails; var $ProductNameFK; var $TokenPK;
	var $UnderwritingGuidelinesURL; var $Table; var $Tokens; var $Token; var $Record; var $Delete;
	var $Debug; var $connectionInfo; var $serverName; var $dbName; var $dbUser; var $dbPassword;

	private $CI;

	function __construct()
	{
	    // Call the Model constructor
	    parent::__construct();

		$this->serverName = "172.31.38.191";

		$this->dbName = "AQTQE2011";
		$this->dbUser = "sa";
		$this->dbPassword = "aqsql";

		$this->connectionInfo = array( "Database" => $this->dbName, "UID" => $this->dbUser, "PWD" => $this->dbPassword);
		$this->Delete = 0;
		$this->CI =& get_instance();
		$this->CI->load->library('DBDbi');
		$this->initDB(false);
	}

	function initDB($returnDatesAsString=false)
	{
		$this->CI->dbi->init($this->serverName, $this->dbUser, $this->dbPassword, true);
		$this->CI->dbi->connect($this->dbName);
	}

	function connectDB($dbName)
	{
		$this->CI->dbi->connect($dbName);
	}

	function sp_getSubscriberInformation($AQSiteNumber, $TeaserURL)
	{
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
			$Birthday = mysql_real_escape_string($AQSiteNumber);
			$CoverageAmount = mysql_real_escape_string($TeaserURL);

			$tsql_callSP = "{call getAgentSubscriberInformation(?,?)}";

			$params = array(
                 $AQSiteNumber, $TeaserURL
               );

				/* Execute the query. */
				$stmt = $this->CI->dbi->call_sp($tsql_callSP, $params);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

	//			echo "Rows affectd: ".sqlsrv_rows_affected($stmt)."-----\n";

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ( $this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		return array_pop($result);
	}

/*
 *
 *
  @zdBirthday			datetime,
  @ziCoverageAmount		integer,    -- In thousands (dollars)
  @zsGender				char(1),    -- (F)emale / (M)ale
  @ziPremiumPeriod		integer,    -- 0=Annual, 1=Monthly, 2=Quarterly, 3=Semiannually
  @zsStateAbbreviation	char(2),
  @ziSubscriberPK		integer,	-- NOT USED
  @ziTermYears			integer,
  @zsTobacco			char(1) *
 *
 */

	function sp_generateQuoteRequestResponse($Birthday, $CoverageAmount, $Gender, $PremiumPeriod,
	                                         $StateAbbreviation, $SubscriberPK, $TermYears, $Tobacco )
	{
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');
		if($this->CI->dbi->isConnected())
		{
			$Birthday = mysql_real_escape_string($Birthday);
			$CoverageAmount = mysql_real_escape_string($CoverageAmount);
			$Gender = mysql_real_escape_string($Gender);
			$PremiumPeriod = mysql_real_escape_string($PremiumPeriod);
			$StateAbbreviation = mysql_real_escape_string($StateAbbreviation);
			$SubscriberPK = mysql_real_escape_string($SubscriberPK);
			$TermYears = mysql_real_escape_string($TermYears);
			$Tobacco = mysql_real_escape_string($Tobacco);

			$tsql_callSP = "{call generateQuoteRequestResponse(?,?,?,?,?,?,?,?)}";

			$params = array(
                 $Birthday, $CoverageAmount, $Gender, $PremiumPeriod,
	             $StateAbbreviation, $SubscriberPK, $TermYears, $Tobacco
               );

				/* Execute the query. */
				$stmt = $this->CI->dbi->call_sp($tsql_callSP, $params);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r( $this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ( $this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		return $result;
	}

	function sp_getUnderwritingGuidelines($Birthday, $CoverageAmount, $Gender, $PremiumPeriod,
	                                      $StateAbbreviation, $SubscriberPK, $TermYears, $Tobacco, $PolicyPK)
	{
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');
		if($this->CI->dbi->isConnected())
		{
			$Birthday = mysql_real_escape_string($Birthday);
			$CoverageAmount = mysql_real_escape_string($CoverageAmount);
			$Gender = mysql_real_escape_string($Gender);
			$PremiumPeriod = mysql_real_escape_string($PremiumPeriod);
			$StateAbbreviation = mysql_real_escape_string($StateAbbreviation);
			$SubscriberPK = mysql_real_escape_string($SubscriberPK);
			$TermYears = mysql_real_escape_string($TermYears);
			$Tobacco = mysql_real_escape_string($Tobacco);
			$PolicyPK = mysql_real_escape_string($PolicyPK);

			$tsql_callSP = "{call getDetailedPolicyInformation(?,?,?,?,?,?,?,?,?)}";

			$params = array(
                 $Birthday, $CoverageAmount, $Gender, $PremiumPeriod,
	             $StateAbbreviation, $SubscriberPK, $TermYears, $Tobacco, $PolicyPK
               );

				/* Execute the query. */
				$stmt = $this->CI->dbi->call_sp($tsql_callSP, $params);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r( $this->CI->dbi->errors(), true));
				}

		//		echo "Rows affectd: ".sqlsrv_rows_affected($stmt)."-----\n";

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ( $this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		return array_pop($result);
	}

	function setSubscribedCompany($SubscriberFK, $CompanyFK, $FlagState) {
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$SubscriberFK = mysql_real_escape_string($SubscriberFK);
				$CompanyFK = mysql_real_escape_string($CompanyFK);
				$FlagState = mysql_real_escape_string($FlagState);

				if($FlagState == $this->Delete) {
					$tsql = sprintf("DELETE FROM SubscriberCompanies_New "
		    					   ." WHERE (SubscriberFK = %s) AND (companyFK = %s)", $SubscriberFK, $CompanyFK);
				}
				else {
					$tsql = sprintf("INSERT INTO SubscriberCompanies_New (CompanyFK, SubscriberFK) "
		    					   ." VALUES (%s,%s)", $CompanyFK, $SubscriberFK);
				}

				print $tsql;

				/* Execute the query. */
				$this->CI->dbi->begin_transaction();
				$stmt = $this->CI->dbi->query($tsql);
				$this->CI->dbi->commit();

				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r( $this->CI->dbi->errors(), true));
				}

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
	}

	function avaliableSubDomain($url) {
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
			$url = mysql_real_escape_string($url);
			$tsql = sprintf("SELECT COUNT(*) AS i FROM inst113_ga_site_subdomain WHERE subdomain='%s'", $url);

	//		print $tsql;

			/* Execute the query. */
			$stmt = $this->CI->dbi->query($tsql);
			if( $stmt === false )
			{
			     echo "Error in executing statement 3.\n";
			     die( print_r( $this->CI->dbi->errors(), true));
			}

			$row = $this->CI->dbi->fetch_array();

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			$this->CI->dbi->close();

			if($row['i'] == 0) {
				return true;
			}
			else {
				return false;
			}
		}
	}

	function setSubscribedLicense($SubscriberPK , $StateAbbr, $StateName, $LicenseNumber, $Action) {
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$SubscriberPK = mysql_real_escape_string($SubscriberPK);
				$StateAbbr = mysql_real_escape_string($StateAbbr);
				$StateName = mysql_real_escape_string($StateName);
				$LicenseNumber = mysql_real_escape_string($LicenseNumber);
				$Action = mysql_real_escape_string($Action);

				if($Action == 'update') {
					$tsql = sprintf("UPDATE SubscriberStates_New SET License='%s' "
		    					   ." WHERE (SubscriberFK = %s) AND (StateAbbreviation = '%s')", $LicenseNumber, $SubscriberPK, $StateAbbr);
				}
				else if($Action == 'delete') {
					$tsql = sprintf("DELETE FROM SubscriberStates_New "
		    					   ." WHERE SubscriberFK = %s AND StateAbbreviation = '%s'",  $SubscriberPK, $StateAbbr);
				}
				else if($Action == 'add') {
					$tsql = sprintf("INSERT INTO SubscriberStates_New (License, StateAbbreviation, StateName, SubscriberFK) "
		    					   ." VALUES('%s', '%s', '%s', %s)",  $LicenseNumber, $StateAbbr, $StateName, $SubscriberPK);
				}

				print $tsql;

				$this->CI->dbi->begin_transaction();

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);

				$this->CI->dbi->commit();

				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r( $this->CI->dbi->errors(), true));
				}

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
	}

	function getLicenses($SubscriberPK) {
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$SubscriberPK = mysql_real_escape_string($SubscriberPK);

				$tsql = sprintf("SELECT License, StateAbbreviation, StateName FROM SubscriberStates_New"
							    ." WHERE (SubscriberFK = %s)", $SubscriberPK);
				// print $tsql;

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ( $this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		return $result;
	}

	function getLicense($SubscriberPK, $StateAbbr) {
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$SubscriberPK = mysql_real_escape_string($SubscriberPK);
				$StateAbbr = mysql_real_escape_string($StateAbbr);

				$tsql = sprintf("SELECT License, StateAbbreviation, StateName FROM SubscriberStates_New"
							    ." WHERE (SubscriberFK = %s) AND (StateAbbreviation = '%s')", $SubscriberPK, $StateAbbr);
				//print $tsql;

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ( $this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}

		return array_pop($result);
	}

	function getSubscriberConfiguration($AQSiteNumber) {
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$AQSiteNumber = mysql_real_escape_string($AQSiteNumber);

				$tsql = sprintf("SELECT "
								."  ButtonIndex, "
								."  DomainName, "
								."  LeadCaptureEnabled, "
								."  RateClassificationColorIndex, "
								."  Status, "
				                ."  SubscriberPK, "
								."  TQEURI "
								."FROM "
								."  Subscribers_New "
								."WHERE "
								."  (AQSiteNumber = %s)", $AQSiteNumber);

				//print $tsql;

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ( $this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}

		return $result;
	}

	function getSubscriberInfo($SubscriberPK) {
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$SubscriberPK = mysql_real_escape_string($SubscriberPK);

				$tsql = sprintf("SELECT "
								."  ButtonIndex, "
								."  DomainName, "
								."  LeadCaptureEnabled, "
								."  RateClassificationColorIndex, "
								."  Status, "
				                ."  SubscriberPK, "
				                ."  AQSiteNumber, "
								."  TQEURI "
								."FROM "
								."  Subscribers "
								."WHERE "
								."  (SubscriberPK = %s)", $SubscriberPK);

				//print $tsql;

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r( sqlsrv_errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ( $this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}

		return array_pop($result);
	}

	function getSubscriber($SubscriberPK) {
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$SubscriberPK = mysql_real_escape_string($SubscriberPK);

				$tsql = sprintf("SELECT c.Name, c.Active , c.NewYorkCompany, c.CompanyPK, c.BannerLogoImageURL InList = CASE WHEN (sc.CompanyFK is not null) THEN 1 ELSE 0 END FROM"
				." Companies c LEFT OUTER JOIN SubscriberCompanies_New sc ON ((sc.CompanyFK = c.CompanyPK) AND (sc.SubscriberFK = %s ))"
		    	." WHERE (c.Active > 0)"
				." ORDER BY c.Name", $SubscriberPK);

				print $tsql;

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ($this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		return $result;
	}

	function getSubscribersLot($SubscriberPK) {

		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$SubscriberPK = mysql_real_escape_string($SubscriberPK);
				$tsql = sprintf("SELECT sc.SubscriberFK,sc.CompanyFK, c.CompanyPK, c.Name, c.BannerLogoImageURL FROM SubscriberCompanies_New sc"
								." LEFT OUTER JOIN Companies c"
								." ON sc.CompanyFK = c.CompanyPK"
								." WHERE sc.SubscriberFK = %s"
								." ORDER BY CompanyFK", $SubscriberPK);

		//		print $tsql;

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ($this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}

		return $result;
	}

	function getSubscribers() {
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
				$tsql = sprintf("SELECT s.SubscriberPK, s.DomainName, s.TQEURI FROM Subscribers_New s ORDER BY DomainName ASC ");

				//print $tsql;

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ($this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}

		return $result;
	}

	function getConfiguration()
	{
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{

			$tsql = "SELECT Disclaimer, ReviewedOn FROM Configuration";

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ($this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}

		return array_pop($result);
	}

	function sp_getDetailedPolicyInformation($Birthday, $CoverageAmount, $Gender, $PremiumPeriod,
	                                         $StateAbbreviation, $SubscriberPK, $TermYears, $Tobacco, $PolicyPK)
	{
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		if($this->CI->dbi->isConnected())
		{
			$Birthday = mysql_real_escape_string($Birthday);
			$CoverageAmount = mysql_real_escape_string($CoverageAmount);
			$Gender = mysql_real_escape_string($Gender);
			$PremiumPeriod = mysql_real_escape_string($PremiumPeriod);
			$StateAbbreviation = mysql_real_escape_string($StateAbbreviation);
			$SubscriberPK = mysql_real_escape_string($SubscriberPK);
			$TermYears = mysql_real_escape_string($TermYears);
			$Tobacco = mysql_real_escape_string($Tobacco);
			$PolicyPK = mysql_real_escape_string($PolicyPK);

			$tsql_callSP = "{call getDetailedPolicyInformation(?,?,?,?,?,?,?,?,?)}";

			$params = array(
                 $Birthday, $CoverageAmount, $Gender, $PremiumPeriod,
	             $StateAbbreviation, $SubscriberPK, $TermYears, $Tobacco, $PolicyPK
               );

				/* Execute the query. */
				$stmt = $this->CI->dbi->call_sp($tsql_callSP, $params);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

	//		echo "Rows affectd: ".sqlsrv_rows_affected($stmt)."-----\n";

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				       // print print_r($result,true);
				    }
				}
				while ($this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		return $result;
	}

	function get_sp()
	{
		$result = array();
		$this->initDB(true);
		$this->connectDB('AQTQE2011');

		$v1 = '8/3/1955';
		$v2 = 100;
		$v3 = 'M';
		$v4 = 0;
		$v5 = 'CA';
		$v6 = 673;
		$v7 = 20;
		$v8 = 'N';


       print "----------------------------------------------------------------------------------------------------";

		if($this->CI->dbi->isConnected())
		{

			$tsql_callSP = "{call generateQuoteRequestResponse(?,?,?,?,?,?,?,?)}";

			$params = array(
                 $v1,
                 $v2,
                 $v3,
                 $v4,
                 $v5,
                 $v6,
                 $v7,
                 $v8
               );

				/* Execute the query. */
				$stmt = $this->CI->dbi->call_sp($tsql_callSP, $params);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				echo "Rows affectd: ".$this->CI->dbi->rows_affected()."-----\n";

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $result[] = $row;
				        print print_r($result,true);
				    }
				}
				while ( sqlsrv_next_result($stmt) );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		return $this->Tokens;
	}
}
?>