<?php

use MyWikiPRO\Component\Queue\Entity\Message;
use MyWikiPRO\Component\Queue\Manager;

/**
 * Менеджер очередей / Тестирование менеджера
 *
 * Class QueueManagerTest
 * @package QueueTest\Unit\Manager
 */
class QueueManagerTest extends \Codeception\TestCase\Test
{
    /**
     * @var Manager\QueueManager
     */
    private $service;


    public function setUp()
    {
        $config  = $this->createServiceConfig();
        $factory = new Manager\QueueManagerFactory();

        $this->service = $factory->create($config);
    }

    /**
     * Переходим на следующий тест
     */
    public function tearDown()
    {
        $this->service = null;
    }

    /**
     * Создание сервиса
     */
    public function testCreateService()
    {
        $this->assertInstanceOf('\MyWikiPRO\Component\Queue\Manager\QueueManager', $this->service);

        $queue    = $this->service->getQueue('');
        $exchange = $this->service->getExchange('');

        // Публикация и выбирание из очереди
        $exchange->publish('', 'message 3', Manager\Decoder\DecoderInterface::TYPE_PLAIN, 0);

        $this->assertInstanceOf('\MyWikiPRO\Component\Queue\Entity\Message', $queue->shift());
        $this->assertInstanceOf('\MyWikiPRO\Component\Queue\Entity\Message', $queue->shift());
        $this->assertInstanceOf('\MyWikiPRO\Component\Queue\Entity\Message', $queue->shift());
        $this->assertNull($this->service->getQueue('')->shift());

        // Тестирование nack
        $exchange->publish('', 'message 4', Manager\Decoder\DecoderInterface::TYPE_PLAIN, 0);

        // Получаем и блокируем сообщение
        $message = $queue->get();
        $this->assertInstanceOf('\MyWikiPRO\Component\Queue\Entity\Message', $message);

        // Возвращаем в очередь
        $queue->unlock($message->getId());

        // И снова забираем
        $this->assertInstanceOf('\MyWikiPRO\Component\Queue\Entity\Message', $queue->shift());
        $this->assertNull($queue->shift());
    }

    /**
     * Конфигурация rabbit адаптера
     *
     * @return Manager\Adapter\Rabbit\Configuration
     */
    private function getRabbitAdapterConfig()
    {
        $adapterConfig = new Manager\Adapter\Mock\Configuration();
        $adapterConfig->setEncodedMessageCollection(new Manager\Message\EncodedMessageCollection());
        $adapterConfig->getEncodedMessageCollection()
            ->attach(new Manager\Message\EncodedMessage(new Message(1, 'message 1', 0), Manager\Decoder\DecoderInterface::TYPE_PLAIN))
            ->attach(new Manager\Message\EncodedMessage(new Message(2, 'message 2', 0), Manager\Decoder\DecoderInterface::TYPE_PLAIN));

        return $adapterConfig;
    }

    /**
     * Конфигурация для создания сервиса
     *
     * @return Manager\Configuration\Configuration
     */
    private function createServiceConfig()
    {
        $queueCollection = new Manager\Queue\ConfigurationCollection();
        $queueCollection->attach(new Manager\Queue\Configuration(''));

        $exchangeCollection = new Manager\Exchange\ConfigurationCollection();
        $exchangeCollection->attach(new Manager\Exchange\Configuration('', Manager\Exchange\ExchangeInterface::TYPE_DIRECT));

        $config = new Manager\Configuration\Configuration();
        $config
            ->setAdapterConfig($this->getRabbitAdapterConfig())
            ->setQueueCollection($queueCollection)
            ->setExchangeCollection($exchangeCollection)
            ->setBindCollection(new Manager\Bind\Collection());

        return $config;
    }
}
