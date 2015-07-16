<?php

namespace MyWikiPRO\Component\QueueManager\Adapter\Mock;

use MyWikiPRO\Component\QueueManager\Configuration\ExchangeConfiguration;
use MyWikiPRO\Component\QueueManager\Configuration\QueueConfiguration;
use MyWikiPRO\Component\QueueManager\Entity\Message;
use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;
use MyWikiPRO\Component\QueueManager\Message\EncodedMessage;
use MyWikiPRO\Component\QueueManager\Message\EncodedMessageCollection;

/**
 * Менеджер очередей / Заглушка для адаптера
 *
 * Class MockAdapter
 * @package MyWikiPRO\Component\QueueManager\Adapter\Mock
 */
final class MockAdapter implements AdapterInterface
{
    /**
     * @var EncodedMessageCollection
     */
    private $messageCollection;

    /**
     * Constructor
     *
     * @param MockConfiguration $config
     */
    public function __construct(MockConfiguration $config)
    {
        $this->messageCollection = $config->getEncodedMessageCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function bind(ExchangeConfiguration $exchangeConfig, QueueConfiguration $queueConfig, $routingKey)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function publish(
        ExchangeConfiguration $configuration,
        $routingKey,
        $message,
        $contentType,
        $attempt,
        $priority
    ) {
        $this->messageCollection->attach(new EncodedMessage(
            new Message($this->messageCollection->getNextId(), $message, 0),
            $contentType)
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get(QueueConfiguration $configuration)
    {
        return $this->messageCollection->getFirst();
    }

    /**
     * {@inheritdoc}
     */
    public function ack(QueueConfiguration $configuration, $id)
    {
        $this->messageCollection->detachById($id);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function nack(QueueConfiguration $configuration, $id)
    {
        $message = $this->messageCollection->getById($id);
        $this->messageCollection->detachById($id);
        $this->messageCollection->attach($message);

        return true;
    }
}
