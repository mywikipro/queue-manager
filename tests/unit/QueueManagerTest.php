<?php

use MyWikiPRO\Component\QueueManager\Entity\Message;
use MyWikiPRO\Component\QueueManager\Decoder\DecoderInterface;
use MyWikiPRO\Component\QueueManager\Message\EncodedMessage;
use MyWikiPRO\Component\QueueManager\QueueManagerFactory;
use MyWikiPRO\Component\QueueManager\Configuration\Configuration;
use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;
use MyWikiPRO\Component\QueueManager\Exchange;

/**
 * Менеджер очередей / Тестирование менеджера
 *
 * Class QueueManagerTest
 * @package QueueTest\Unit\Manager
 */
class QueueManagerTest extends \Codeception\TestCase\Test
{
    /**
     * @var \MyWikiPRO\Component\QueueManager\QueueManager
     */
    private $service;


    public function setUp()
    {
        $config  = $this->createServiceConfig();
        $factory = new QueueManagerFactory();

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
        $this->assertInstanceOf('\MyWikiPRO\Component\QueueManager\QueueManager', $this->service);

        $queue    = $this->service->getQueue('');
        $exchange = $this->service->getExchange('');

        // Публикация и выбирание из очереди
        $exchange->publish('', 'message 3', DecoderInterface::TYPE_PLAIN, 0);

        $this->assertInstanceOf('\MyWikiPRO\Component\QueueManager\Entity\Message', $queue->shift());
        $this->assertInstanceOf('\MyWikiPRO\Component\QueueManager\Entity\Message', $queue->shift());
        $this->assertInstanceOf('\MyWikiPRO\Component\QueueManager\Entity\Message', $queue->shift());
        $this->assertNull($this->service->getQueue('')->shift());

        // Тестирование nack
        $exchange->publish('', 'message 4', DecoderInterface::TYPE_PLAIN, 0);

        // Получаем и блокируем сообщение
        $message = $queue->get();
        $this->assertInstanceOf('\MyWikiPRO\Component\QueueManager\Entity\Message', $message);

        // Возвращаем в очередь
        $queue->unlock($message->getId());

        // И снова забираем
        $this->assertInstanceOf('\MyWikiPRO\Component\QueueManager\Entity\Message', $queue->shift());
        $this->assertNull($queue->shift());
    }

    /**
     * Конфигурация для создания сервиса
     *
     * @return Configuration
     */
    private function createServiceConfig()
    {
        return new Configuration([
            'adapter' => [
                'type' => AdapterInterface::TYPE_MOCK,
                'messages' => [
                    new EncodedMessage(new Message(1, 'message 1', 0), DecoderInterface::TYPE_PLAIN),
                    new EncodedMessage(new Message(2, 'message 2', 0), DecoderInterface::TYPE_PLAIN)
                ],
            ],
            'queues' => [
                'name' => 'queue1',
            ],
            'exchanges' => [
                'name' => 'exchange1',
                'type' => Exchange::TYPE_FANOUT
            ],
            'bind' => [],
        ]);
    }
}
