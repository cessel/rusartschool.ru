<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 07.08.2021
 * Time: 12:39
 */
if(class_exists('IP_Geo_Location')) {
	class IpGeoClass extends IP_Geo_Location {
		public function getIpInfo( $inp_ip ) {

			$ip    = sanitize_text_field( $inp_ip );
			$error = "";

			// get api service
			$api_service = get_option( 'ipgeo_api_service' );
			if ( ! empty( $api_service ) ) {
				if ( $api_service == "ip-api" ) {
					$result = $this->get_result_data_api( $ip, 'ip-api' );
				} else {
					$api_token = get_option( 'ipgeo_api_token' );

					// check api token is empty or no
					if ( ! empty( $api_token ) ) {
						$result = $this->get_result_data_api( $ip, $api_service, $api_token );
					}
				}

				// return error
				if ( isset( $result['error'] ) ) {
					if ( is_array( $result['error'] ) ) {
						$error = $result['error']['title'];
					} else {
						$error = $result['error'];
					}
				}

				// show data
				if ( empty( $error ) ) {
					return $result;
				} else {
					return false;
				}
			}
		}
	}
}