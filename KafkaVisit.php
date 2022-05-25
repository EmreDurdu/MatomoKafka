<?php


namespace Piwik\Plugins\MatomoKafka;


use JsonException;
use Piwik\Container\StaticContainer;
use Piwik\Tracker\Request;
use Psr\Log\LoggerInterface;
use RdKafka\Conf;
use RdKafka\Producer;

class KafkaVisit implements \Piwik\Tracker\VisitInterface
{

    private $request;
    private $topic;
    private $rk;
    protected $logger = null;

    public function __construct()
    {
        $this->logger = StaticContainer::get(LoggerInterface::class);
        $conf = new Conf();
        $conf->set('log_level', (string)LOG_DEBUG);
        $conf->set('debug', 'all');
        $rk = new Producer($conf);
        $settings = new SystemSettings();
        $rk->addBrokers($settings->brokerList->getValue());
        $this->topic = $rk->newTopic("test");
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        try {
            $json = json_encode($this->request->getParams(), JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return;
        }
        $this->topic->produce(RD_KAFKA_PARTITION_UA, 0, $json);

    }
}