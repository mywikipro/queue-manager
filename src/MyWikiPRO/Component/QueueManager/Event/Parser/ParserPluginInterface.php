<?php

namespace MyWikiPRO\Component\QueueManager\Event\Parser;

use MyWikiPRO\Component\QueueManager\Consumer\PluginTypeInterface;

/**
 * Менеджер очередей / Интерфейс события плагина парсера сообщения из очереди в объект события
 *
 * Interface ParserPluginInterface
 * @package MyWikiPRO\Component\QueueManager\Event\Parser
 */
interface ParserPluginInterface extends ParserInterface, PluginTypeInterface
{

}
