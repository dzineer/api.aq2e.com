<?php

class DB_Aqtqe2011SpModel extends CI_Model {

	var $Banner; var $CompanyFK; var $Description; var $PolicyDetails; var $ProductNameFK; var $TokenPK;
	var $UnderwritingGuidelinesURL; var $Table; var $Tokens; var $Token; var $Record; var $Delete;
	var $Debug; var $connectionInfo; var $serverName; var $dbName; var $dbUser; var $dbPassword;
	var $SubscriberFK;

	private $CI;

	function __construct()
	{
	    // Call the Model constructor
	    parent::__construct();

		$this->Delete = 0;
		$this->CI =& get_instance();
		$this->CI->load->library('DBDbi');
	}

	function initDB($dbConf, $returnDatesAsString=false)
	{
		//print '<pre>dbConf Aqtqe2011spModel: '.print_r($dbConf,true);
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

	function sp_getAdminProfileInformation($AQSiteNumber, $TeaserURL)
	{
		$result = array();
		$this->connectDB($this->dbName);

		//printf("\nAQSiteNumber: %s, Length TeaserURL: %s\n",$AQSiteNumber, strlen($TeaserURL));

		if($this->CI->dbi->isConnected())
		{
			$tsql_callSP = "getGAProfileInformation";

			$params[] = new DBDBParam('ziAQSiteNumber',$AQSiteNumber,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsSourceDomain',$TeaserURL,'SQLVARCHAR',false,false,30);

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
			    //   printf("<br><pre>Subscriber Info: %s<br>" ,print_r($result,true));
			    }
			}
			while ( $this->CI->dbi->next_result() );

			/*Free the statement and connection resources. */
			$this->CI->dbi->free_stmt();
			$this->CI->dbi->close();
		}
		return array_pop($result);
	}

	function sp_getAgentSubscriberInformation($AQSiteNumber, $TeaserURL)
	{
		$result = array();
		$this->connectDB($this->dbName);

		//printf("\nAQSiteNumber: %s, Length TeaserURL: %s\n",$AQSiteNumber, strlen($TeaserURL));

		if($this->CI->dbi->isConnected())
		{
			$tsql_callSP = "getAgentSubscriberInformation";

			$params[] = new DBDBParam('ziAQSiteNumber',$AQSiteNumber,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsSourceDomain',$TeaserURL,'SQLVARCHAR',false,false,30);

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
			    //   printf("<br><pre>Subscriber Info: %s<br>" ,print_r($result,true));
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
		$this->connectDB($this->dbName);
		if($this->CI->dbi->isConnected())
		{
			$tsql_callSP = "generateAgentsQuoteRequestResponse";

/*
 *
Use:
SQLVARCHAR for binary
SQLINT4 for datetime
SQLFLT8 for decimal
SQLVARCHAR for image
SQLFLT8 for money
SQLCHAR for nchar
SQLTEXT for ntext
SQLFLT8 for numeric
SQLVARCHAR for nvarchar
SQLFLT8 for real
SQLINT4 for smalldatetime
SQLFLT8 for smallmoney
SQLVARCHAR for sql_variant
SQLINT4 for timestamp
SQLVARCHAR for varbinary
 *
 */

			$params[] = new DBDBParam('zdBirthday',$Birthday,'SQLVARCHAR',false,false,0);
			$params[] = new DBDBParam('ziCoverageAmount',$CoverageAmount,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsGender',$Gender,'SQLCHAR',false,false,1);
			$params[] = new DBDBParam('ziPremiumPeriod',$PremiumPeriod,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsStateAbbreviation',$StateAbbreviation,'SQLVARCHAR',false,false,2);
			$params[] = new DBDBParam('ziSubscriberPK',$SubscriberPK,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('ziTermYears',$TermYears,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsTobacco',$Tobacco,'SQLVARCHAR',false,false,1);

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
		$this->connectDB($this->dbName);
		if($this->CI->dbi->isConnected())
		{
			$tsql_callSP = "getDetailedPolicyInformation";

			$params[] = new DBDBParam('zdBirthday',$Birthday,'SQLVARCHAR',false,false,0);
			$params[] = new DBDBParam('ziCoverageAmount',$CoverageAmount,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsGender',$Gender,'SQLCHAR',false,false,1);
			$params[] = new DBDBParam('ziPremiumPeriod',$PremiumPeriod,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsStateAbbreviation',$StateAbbreviation,'SQLVARCHAR',false,false,2);
			$params[] = new DBDBParam('ziSubscriberPK',$SubscriberPK,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('ziTermYears',$TermYears,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsTobacco',$Tobacco,'SQLVARCHAR',false,false,1);
			$params[] = new DBDBParam('ziPolicyPK',$PolicyPK,'SQLFLT8',false,false,0);

		//	print printf("<br/><pre>params: %s",print_r($params,true));

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

	function sp_getDetailedPolicyInformation($Birthday, $CoverageAmount, $Gender, $PremiumPeriod,
	                                         $StateAbbreviation, $SubscriberPK, $TermYears, $Tobacco, $PolicyPK)
	{
		$result = array();
		$this->connectDB($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql_callSP = "getDetailedPolicyInformation";

			$params[] = new DBDBParam('zdBirthday',$Birthday,'SQLVARCHAR',false,false,0);
			$params[] = new DBDBParam('ziCoverageAmount',$CoverageAmount,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsGender',$Gender,'SQLCHAR',false,false,1);
			$params[] = new DBDBParam('ziPremiumPeriod',$PremiumPeriod,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsStateAbbreviation',$StateAbbreviation,'SQLVARCHAR',false,false,2);
			$params[] = new DBDBParam('ziSubscriberPK',$SubscriberPK,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('ziTermYears',$TermYears,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsTobacco',$Tobacco,'SQLVARCHAR',false,false,1);
			$params[] = new DBDBParam('ziPolicyPK',$PolicyPK,'SQLFLT1',false,false,0);

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

	function sp_AddBannerProgramSubscriber($AQ_Site_Num, $aqtqe)
	{
		$result = array();
		$this->connectDB($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			$tsql_callSP = "AddBannerProgramSubscriber";

			//printf("<pre>%s", $aqtqe->GASiteNum); exit(0);

			$params[] = new DBDBParam('ziAQSiteNumber',$AQ_Site_Num,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('ziGASiteNumber',$aqtqe->GASiteNum,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('zsDomainName',$aqtqe->Domain,'SQLVARCHAR',false,false,128);
			$params[] = new DBDBParam('zsStateAbbreviation',$aqtqe->StateAbbr,'SQLVARCHAR',false,false,2);
			$params[] = new DBDBParam('zsStateName',$aqtqe->StateName,'SQLVARCHAR',false,false,24);
			$params[] = new DBDBParam('zsTQEURI',$aqtqe->WidgetURL,'SQLVARCHAR',false,false,64);
			$params[] = new DBDBParam('ziTypeStatus',10,'SQLFLT8',false,false, 0);
			
			//printf("<pre>%s", print_r($params,true));
			

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
		$this->connectDB($this->dbName);

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
			$tsql_callSP = "generateQuoteRequestResponse";

			$params[] = new DBDBParam('Birthday',$v1,'SQLVARCHAR',false,false,0);
			$params[] = new DBDBParam('CoverageAmount',$v2,'SQLVARCHAR',false,false,0);
			$params[] = new DBDBParam('Gender',$v3,'SQLVARCHAR',false,false,0);
			$params[] = new DBDBParam('PremiumPeriod',$v4,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('StateAbbreviation',$v5,'SQLVARCHAR',false,false,0);
			$params[] = new DBDBParam('SubscriberPK',$v6,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('TermYears',$v7,'SQLFLT8',false,false,0);
			$params[] = new DBDBParam('Tobacco',$v8,'SQLVARCHAR',false,false,0);

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