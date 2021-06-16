<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MatomoKafka;

use Piwik\Container\StaticContainer;
use Psr\Log\LoggerInterface;

class MatomoKafka extends \Piwik\Plugin
{
    protected string $pluginName = 'MatomoKafka';
    protected $logger = null;

    public function __construct($pluginName = false)

    {
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

