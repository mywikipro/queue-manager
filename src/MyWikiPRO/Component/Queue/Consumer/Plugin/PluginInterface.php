<?php

namespace MyWikiPRO\Component\Queue\Consumer\Plugin;

use MyWikiPRO\Component\Queue\Consumer\PluginTypeInterface;
use MyWikiPRO\Component\Queue\Consumer\Response\Response;
use MyWikiPRO\Component\Queue\Event\EventInterface;

/**
 * Менеджер очередей / Интерфейс обработчика события полученного из очереди
 *
 * Interface PluginInterface
 * @package MyWikiPRO\Component\Queue\Consumer
 */
interface PluginInterface extends PluginTypeInterface
{
    /**
     * Задать событие
     *
     * @param EventInterface $event
     * @return mixed
     */
    public function setEvent(EventInterface $event);

    /**
     * Плагин может обработать событие
     *
     * @return bool
     */
    public function shouldStart();

    /**
     * Обработка события
     *
     * @return Response|null
     * @throws PluginException
     */
    public function apply();
}
