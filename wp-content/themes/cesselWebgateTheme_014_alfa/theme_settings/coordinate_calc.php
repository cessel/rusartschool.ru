<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 08.08.2021
 * Time: 7:30
 */

require_once(get_template_directory().'/lib/phpgeo/vendor/autoload.php');
use Location\Coordinate;
use Location\Distance\Vincenty;

function coordinate_calc($lats,$lons) {
	$coordinate1 = new Coordinate($lats[0],$lons[0]);
	$coordinate2 = new Coordinate($lats[1],$lons[1]);

	$calculator = new Vincenty();

	return $calculator->getDistance($coordinate1, $coordinate2);
}
