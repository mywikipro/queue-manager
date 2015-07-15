<?php

namespace MyWikiPRO\Component\Queue\Event\Parser;

use MyWikiPRO\Component\Queue\Consumer\PluginTypeInterface;

/**
 * Менеджер очередей / Интерфейс события плагина парсера сообщения из очереди в объект события
 *
 * Interface ParserPluginInterface
 * @package MyWikiPRO\Component\Queue\Event\Parser
 */
interface ParserPluginInterface extends ParserInterface, PluginTypeInterface
{

}
