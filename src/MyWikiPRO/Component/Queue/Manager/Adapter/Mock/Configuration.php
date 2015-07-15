<?php

namespace MyWikiPRO\Component\Queue\Manager\Adapter\Mock;

use MyWikiPRO\Component\Queue\Manager\Adapter\AdapterInterface;
use MyWikiPRO\Component\Queue\Manager\Adapter\ConfigurationInterface;
use MyWikiPRO\Component\Queue\Manager\Message\EncodedMessageCollection;

/**
 * Менеджер очередей / Конфигурация mock адаптера
 *
 * Class Configuration
 * @package MyWikiPRO\Component\Queue\Manager\Adapter\Mock
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * @var EncodedMessageCollection
     */
    private $messageCollection;

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
