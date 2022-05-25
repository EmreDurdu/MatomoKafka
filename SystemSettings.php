<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MatomoKafka;

use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\NotEmpty;
use Piwik\Validators\ValidUrl;

/**
 * Defines Settings for MatomoKafka.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{

    /** @var Setting */
    public $brokerList;
    /** @var Setting */
    public $enabled;

    protected function init()
    {

        // System setting --> textarea
        $this->brokerList = $this->createBrokerListSetting();

    }

    private function createBrokerListSetting()
    {
        $default = "localhost:9092";

        return $this->makeSetting('Broker_list', $default, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Kafka broker list:';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = "
            You can type the kafka brokers list here. If there are more than one, please separete them by ','\n
            Some examples:\n
            localhost:9092\n
            localhost:9092,10.0.0.1:9092\n
            https://aws.samplekafka.domain";
            $field->validators[] = new NotEmpty();
//            TODO: fix here // setting not working when the code below is uncommented.
//            $field->validators[] = new ValidUrl();
        });
    }
}
