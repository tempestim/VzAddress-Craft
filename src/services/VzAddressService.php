<?php

/**
 * VZ Address plugin for Craft CMS 3.x
 *
 * A simple address field for Craft.
 *
 * @link      http://elivz.com
 * @copyright Copyright (c) 2019 Eli Van Zoeren
 */

namespace elivz\vzaddress\services;

use craft\base\Component;
use elivz\vzaddress\models\Address;
use elivz\vzaddress\VzAddress;
use yii\base\UserException;

/**
 * VzAddressService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Eli Van Zoeren
 * @package   VzAddress
 * @since     2.0.0
 */
class VzAddressService extends Component
{
    // Private Variables
    // =========================================================================

    /**
     * @var array   Settings
     */
    public $_settings;

    /**
     * @var array   Countries
     */
    public $countries;


    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        $this->_settings = VzAddress::getInstance()->getSettings();
        $this->countries = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'countries.php';
    }

    /**
     * Method to geocode the given address string into a lat/lng coordinate pair
     *
     * @return array The lat/lng pair in an array
     * @var string $address The address string
     */
    public function geocodeAddress(Address $address): array
    {
        $coords = [
            'latitude' => null,
            'longitude' => null,
        ];

        // Get the API key, either from the template params or the plugin config
        $key = trim($this->_settings->googleServerApiKey ?? $this->_settings->googleApiKey ?? null);

        if (empty($key)) {
            return $coords;
        }

        $url = 'https://maps.googleapis.com/maps/api/geocode/json';
        $params = http_build_query([
            'key' => $key,
            'address' => (string)$address
        ]);

        // get the json response
        $response = json_decode(file_get_contents($url . '?' . $params), true);

        // Response status will be 'OK' if able to geocode given address
        if ($response['status'] == 'OK') {
            $lat = $response['results'][0]['geometry']['location']['lat'];
            $lng = $response['results'][0]['geometry']['location']['lng'];

            // verify if data is complete
            if ($lat && $lng) {
                $coords = [
                    'latitude' => $lat,
                    'longitude' => $lng,
                ];
            }
        } elseif (isset($response['error_message'])) {
            throw new UserException('Error while geocoding address: ' . $response['error_message']);
        }

        return $coords;
    }
}
