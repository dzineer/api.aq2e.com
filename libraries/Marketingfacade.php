<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
/*
 * Marketingfacade.php -
 *
 */

class Marketingfacade
{
	var $debug = false;

	private $CI;

	function __construct($Domain = '127.0.0.1') {
		$this->CI =& get_instance();

		$this->CI->load->model('MarketingPreferences_model', 'mpm');

		$this->Staging = $this->CI->config->item('flags')['staging'];
		$this->Debug = $this->CI->config->item('flags')['debug'];
	}

	function add_new_marketing_preference( $site_num
							      ,$permission_flags) {
		
		$this->CI->load->model('MarketingPreferences_model', 'mp');
		
		return $this->CI->mp->add_marketing_preference(
			
			[
				"site_num" => $site_num,
				"permission_flags" => $permission_flags
			]
		);
		
	}
	
	function search_marketing_preference( $id ) {
		$this->CI->load->model('MarketingPreferences_model', 'mp');
		return $this->CI->mp->get_confirmation_page( $id );
	}
	
	function get_all_marketing_preferences() {

		$this->CI->load->library('Sitefacade', null, 'site');
		
		$sites = [];
		$prefs = $this->CI->mpm->get_all_marketing_preferences();

		if ( !empty($prefs) ) {
			foreach ($prefs as $pref) {
				$site = $this->CI->site->search( $pref['site_num'] );
				$arr = [];
				// 3 both - 1 Personal Contact only, 2 - Newsletter Emails Only
				if ( $pref['permission_flags'] == '0' ) {
					$arr =  array( "Preferences" => "None", "site" => $site );
				} else if ( $pref['permission_flags'] == '1' ) {
					$arr =  array( "Preferences" => "Personal Contact Only", "site" => $site );
				} else if ( $pref['permission_flags'] == '2' ) {
					$arr =  array( "Preferences" => "Newsletter Emails Only", "site" => $site );
				}	else if ( $pref['permission_flags'] == '3' ) {
					$arr =  array( "Preferences" => "Personal Contact & Newsletter Emails", "site" => $site );
				}

				$sites[] = $arr;
			}
		}

		return $sites;
	}
	
	
  function update_marketing_preference( $id,
                                         $site_num,
                                         $permission_flags
                                       ) {
        $this->CI->load->model('MarketingPreferences_model', 'mp');
        return $this->CI->mp->update_marketing_preference(

            $id,
            [
                "site_num" => $site_num,
                "permission_flags" => $permission_flags
            ]
        );
    }

}
?>