<?php

/**
* This file is part of the GeoipCountryProvider package.
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @license MIT License
*/

namespace GeoipCountryProvider;
use \Geocoder\Provider\GeoipProvider;
use \Geocoder\Exception\NoResultException;
use \Geocoder\Exception\UnsupportedException;

/**
* @see http://php.net/manual/ref.geoip.php
*
* @author William Durand <william.durand1@gmail.com>
* @author Sam Stenvall <sam@supportersplace.com>
*/
class GeoipCountryProvider extends GeoipProvider
{
	/**
	 * {@inheritDoc}
	 */
	public function getGeocodedData($address)
	{
		if (!filter_var($address, FILTER_VALIDATE_IP)) {
            throw new UnsupportedException('The GeoipProvider does not support Street addresses.');
        }

        // This API does not support IPv6
        if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            throw new UnsupportedException('The GeoipProvider does not support IPv6 addresses.');
        }

        if ('127.0.0.1' === $address) {
            return array($this->getLocalhostDefaults());
        }

		$results = array(
			'country_name' => geoip_country_name_by_name($address),
			'country_code' => geoip_country_code_by_name($address),
		);
		
        if ($results['country_code'] === false) {
            throw new NoResultException(sprintf('Could not find %s ip address in database.', $address));
        }

        $timezone = @geoip_time_zone_by_country_and_region($results['country_code']) ?: null;

        $results = array_merge($this->getDefaults(), array(
            'country'     => $results['country_name'],
            'countryCode' => $results['country_code'],
            'timezone'    => $timezone,
        ));

        return array(array_map(function($value) {
            return is_string($value) ? utf8_encode($value) : $value;
        }, $results));
	}

}
