<?php

namespace MyWikiPRO\Component\Queue\Manager\Bind;

use MyWikiPRO\Component\Queue\Manager\Exchange;
use MyWikiPRO\Component\Queue\Manager\Queue;

/**
 * Менеджер очередей / Интерфейс связи очереди с обменником
 *
 * Class BindInterface
 * @package MyWikiPRO\Component\Queue\Manager\Bind
 */
interface BindInterface
{
    /**
     * Обменник
     *
     * @return Exchange\Configuration
     */
    public function getExchangeConfiguration();

    /**
     * Очередь
     *
     * @return Queue\Configuration
     */
    public function getQueueConfiguration();

    /**
     * Ключ для связи
     *
     * @return string
     */
    public function getRoutingKey();

    /**
     * Hash для проверки уникальности связи
     *
     * @return string
     */
    public function getHash();
}
