<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\KafkaProducer;

use GeoIp2\Util;
use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Tracker;
use Piwik\Tracker\RequestSet;
use Psr\Log\LoggerInterface;
use Piwik\Plugins\KafkaProducer\Utils;

class KafkaProducer extends \Piwik\Plugin
{
    protected $pluginName = 'KafkaProducer';
    protected $logger = null;
    protected $http = null;

    public function __construct($pluginName = false)

    {
        Utils::console_log("deneme");
        $this->logger = StaticContainer::get(LoggerInterface::class);
        parent::__construct($pluginName);
    }

    public function registerEvents(): array
    {
        return [
            'Tracker.newHandler' => 'changeHandler',
            'CronArchive.getArchivingAPIMethodForPlugin' => 'getArchivingAPIMethodForPlugin',
        ];
    }

    public function changeHandler(&$handler)
    {
        $handler = new RequestHandler();
    }

    // support archiving just this plugin via core:archive
    public function getArchivingAPIMethodForPlugin(&$method, $plugin)
    {
        if ($plugin == 'KafkaProducer') {
            $method = 'KafkaProducer.getExampleArchivedMetric';
        }
    }

}

