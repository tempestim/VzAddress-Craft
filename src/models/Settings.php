<?php

/**
 * VZ Address plugin for Craft CMS 3.x
 *
 * A simple address field for Craft.
 *
 * @link      http://elivz.com
 * @copyright Copyright (c) 2019 Eli Van Zoeren
 */

namespace elivz\vzaddress\models;

use craft\base\Model;

/**
 * VzAddress Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Eli Van Zoeren
 * @package   VzAddress
 * @since     2.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $googleApiKey = '';

    /**
     * @var string
     */
    public $googleServerApiKey = '';

    /**
     * @var string
     */
    public $hereAppId = '';

    /**
     * @var string
     */
    public $hereAppCode = '';

    /**
     * @var string
     */
    public $hereJsAppId = '';

    /**
     * @var string
     */
    public $hereJsApiKey = '';

    /**
     * @var string
     */
    public $bingApiKey = '';

    /**
     * @var string
     */
    public $mapquestApiKey = '';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            ['googleApiKey', 'string'],
            ['googleServerApiKey', 'string'],
            ['hereAppCode', 'string'],
            ['hereJsAppId', 'string'],
            ['hereJsApiKey', 'string'],
            ['bingApiKey', 'string'],
            ['mapquestApiKey', 'string'],
        ];
    }
}
