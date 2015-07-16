<?php

namespace MyWikiPRO\Component\QueueManager\Adapter\Mock;

use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;
use MyWikiPRO\Component\QueueManager\Adapter\ConfigurationInterface;
use MyWikiPRO\Component\QueueManager\Message\EncodedMessageCollection;

/**
 * Менеджер очередей / Конфигурация mock адаптера
 *
 * Class Configuration
 * @package MyWikiPRO\Component\QueueManager\Adapter\Mock
 */
final class MockConfiguration implements ConfigurationInterface
{
    /**
     * @var EncodedMessageCollection
     */
    private $messageCollection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messageCollection = new EncodedMessageCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return AdapterInterface::TYPE_MOCK;
    }

    /**
     * Задать список сообщений
     *
     * @param EncodedMessageCollection $messageCollection
     * @return $this
     */
    public function setEncodedMessageCollection(EncodedMessageCollection $messageCollection)
    {
        $this->messageCollection = $messageCollection;
        return $this;
    }

    /**
     * Получить список сообщений
     *
     * @return EncodedMessageCollection
     */
    public function getEncodedMessageCollection()
    {
        return $this->messageCollection;
    }
}
