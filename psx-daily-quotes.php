<?php
/**
 * @package PSX-Daily-Quotes
 * @version 1.0
 */
/*
Plugin Name: PSX Daily Quotes
Plugin URI: 
Description: This plugin fethes the PSX data in JSON and renders it on your web page
Author: Adeel Sarfraz
Version: 1.0
Author URI: https://www.adeelsarfaraz.com
Text Domain: psx-daily-quotes
*/

add_shortcode( 'psx-daily-quote', 'show_quotes' );

function show_quotes() {
	if (is_admin()) {
		// do nothing 
	}
	else {
		$response = wp_remote_get('https://www.adeelsarfaraz.com/psx/');
		if ( is_array( $response ) ) {
		  $header = $response['headers'];
		  $json_str = $response['body'];
		  $arr = json_decode($json_str, true);
		  $strTable = '<style type="text/css">th { background-color:#000000; color: #ffffff; } .sector-name { background-color:#c0c0c0; }</style>
					   <table border="0">
						<thead>
							<th>Code</th>					
							<th>Company</th>
							<th>Open</th>
							<th>High</th>
							<th>Low</th>
							<th>Close</th>
							<th>Change</th>																														
						</thead>
						<tbody>';
						
		  foreach($arr as $nam => $val) {
				$strTable .= '<tr>
								<td class="sector-name" colspan="7">'.$nam.'</td>
							  </tr>';
				foreach($val as $subnam => $subval) {			  
					$strTable .= '<tr>
									<td>'.$subnam.'</td>
									<td>'.$subval['sname'].'</td>
									<td>'.$subval['oprice'].'</td>
									<td>'.$subval['hprice'].'</td>
									<td>'.$subval['lprice'].'</td>
									<td>'.$subval['cprice'].'</td>
									<td>'.$subval['change'].'</td>																																																
								  </tr>';				
				}
		  }				
			$strTable .= '</tbody></table>';
					 
		  echo $strTable;
	   		  
		}	
	}	
}