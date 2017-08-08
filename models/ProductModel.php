<?php

class ProductModel extends ResourceModel {

	private $CI;
	private $hidden = [];

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

	function getSiteProduct($prodId) { // 97
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			
/*

SELECT  p.[product_num]
      , p.[sa_num]
      , p.[product_name]
      , p.[product_description]
      , p.[default_client_id]
      , p.[default_prod_fee]
      , p.[default_payment_schedule]
      , p.[prod_comp_num]
      , p.[prod_cat_num]
      , p.[logo_image]
      , p.[detail_banner_large_image]
      , p.[detail_banner_small_image]
      , p.[agent_info_page_url]
      , p.[email_file]
      , p.[mn_product_yn]
  FROM [aqprod].[dbo].[ins077_product]

*/			
				$tsql = sprintf("SELECT 
						          p.[product_num]
						        , p.[default_prod_fee]
						  
						  FROM [aqprod].[dbo].[ins077_product] AS p
						     WHERE p.[product_num]=%s ", $prodId);
				// print '<pre>'.$tsql;
				// exit(0);

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $this->results[] = $row;
				       // print print_r($this->results,true);
				    }
				}
				while ($this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		
		return array_pop($this->results);
	}

	function getSiteProducts($siteNum) { // 97
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
			
/*

SELECT  p.[product_num]
      , p.[sa_num]
      , p.[product_name]
      , p.[product_description]
      , p.[default_client_id]
      , p.[default_prod_fee]
      , p.[default_payment_schedule]
      , p.[prod_comp_num]
      , p.[prod_cat_num]
      , p.[logo_image]
      , p.[detail_banner_large_image]
      , p.[detail_banner_small_image]
      , p.[agent_info_page_url]
      , p.[email_file]
      , p.[mn_product_yn]
  FROM [aqprod].[dbo].[ins077_product]

*/			
			
				$tsql = sprintf("SELECT 
				
						   sp.[site_num]
						  , sp.[product_num]
						  , sp.[client_id]
						  , sp.[login]
						  , sp.[password]
						  , sp.[product_fee]
						  , sp.[payment_schedule]
						  , sp.[next_bill_date]
						  , sp.[billing_on_hold_yn]
						  , sp.[paid_for_by_affiliate_yn]
						  , sp.[status]
						  , p.[product_num]
						  , p.[sa_num]
						  , p.[product_name]
						  , p.[product_description]
						  , p.[default_client_id]
						  , p.[default_prod_fee]
						  , p.[default_payment_schedule]
						  , p.[prod_comp_num]
						  , p.[prod_cat_num]
						  , p.[logo_image]
						  , p.[detail_banner_large_image]
						  , p.[detail_banner_small_image]
						  , p.[agent_info_page_url]
						  , p.[email_file]
						  , p.[mn_product_yn]	
						  , up.[product_upgrade_to_num]						 
						  
						  FROM [aqprod].[dbo].[ins078_site_product] AS sp
						   LEFT OUTER JOIN [aqprod].[dbo].[ins077_product] AS p ON sp.[product_num] = p.[product_num]
						   LEFT OUTER JOIN [aqprod].[dbo].[ins169_product_upgrade] AS up ON sp.[product_num] = up.[product_num]

						     WHERE (site_num = %s) ", $siteNum);

				// print '<pre>'.$tsql;
				
				// exit(0);

				/* Execute the query. */
				$stmt = $this->CI->dbi->query($tsql);
				if( $stmt === false )
				{
				     echo "Error in executing statement 3.\n";
				     die( print_r($this->CI->dbi->errors(), true));
				}

				do {
				    while ($row = $this->CI->dbi->fetch_array()){
				        $this->results[] = $row;
				       // print print_r($this->results,true);
				    }
				}
				while ($this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}
		return $this->results;
	}
	
	function upgradeProduct($siteNum, $prodId, $newProdId, $newProdFee) {

		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
		
			//$this->encryptedCCNo = $ccNo;
			
		//	$subdomain = mysql_real_escape_string($subdomain);
		
			$tsql = sprintf("UPDATE [aqprod].[dbo].[ins078_site_product] SET [product_num]=%s, [product_fee]=%s, [next_bill_date] = GETDATE() WHERE [site_num]=%s AND [product_num]=%s", 
					 $newProdId, $newProdFee, $siteNum, $prodId);

			// print $tsql;
			// exit(0);
		
			if($_SERVER['REMOTE_ADDR'] == '64.239.131.130') {
				// print $tsql;exit(0);
			}

			/* Execute the query. */
		//	$this->addGASite();
			$stmt = $this->CI->dbi->query($tsql);

			// if activate is true, enable website

			if( $stmt === false )
			{
			     echo "Error in executing statement 3. Billing::update\n";
			     die( print_r( $this->CI->dbi->errors(), true));
			}

			/*Free the statement and connection resources. */
//			$this->CI->dbi->free_stmt();
//			$this->CI->dbi->close();
		//	print "Hey!: ".print_r($row, true);
		}
	}		

	function search($prodNum) { // 97
		$this->results = array();
	//	$this->initDB(true);
		$this->CI->dbi->connect($this->dbName);

		if($this->CI->dbi->isConnected())
		{
				$tsql = sprintf("SELECT default_prod_fee, default_payment_schedule FROM ins077_product WHERE (product_num = %s) ", $prodNum);

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
				        $this->results[] = $row;
				       // print print_r($this->results,true);
				    }
				}
				while ($this->CI->dbi->next_result() );

				/*Free the statement and connection resources. */
				$this->CI->dbi->free_stmt();
				$this->CI->dbi->close();
		}

		$this->results = array_pop($this->results);
        return $this->toJSON();
	}

    function getAll() { // 97
            $this->results = array();
            //	$this->initDB(true);
            $this->CI->dbi->connect($this->dbName);

            if($this->CI->dbi->isConnected()) {

                $tsql = "SELECT product_num, default_prod_fee, default_payment_schedule FROM ins077_product";

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
                        $this->results[] = $row;
                        // print print_r($this->results,true);
                    }
                }
                while ($this->CI->dbi->next_result() );

                /*Free the statement and connection resources. */
                $this->CI->dbi->free_stmt();
                $this->CI->dbi->close();

                return $this->toJSON();
            }



        }



    }
?>