<?php

namespace MyWikiPRO\Component\QueueManager\Consumer\Response;

/**
 * Менеджер очередей / Интерфейс отладочного сообщения консьюмера
 *
 * Interface MessageInterface
 * @package MyWikiPRO\Component\QueueManager\Consumer\Response
 */
interface MessageInterface
{
    const TYPE_INFO     = 'info';
    const TYPE_WARNING  = 'warning';
    const TYPE_ERROR    = 'error';

    /**
     * Тип сообщения
     *
     * @return string
     */
    public function getType();

    /**
     * Текст сообщения
     *
     * @return string
     */
    public function getMessage();
}
