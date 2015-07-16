<?php

namespace MyWikiPRO\Component\QueueManager\Consumer;

/**
 * Менеджер очередей / Исключение консьюмера очередей (срабатывает в обработчике, если неудалось получить сообщение)
 *
 * Class Exception
 * @package MyWikiPRO\Component\QueueManager\Consumer
 */
class EmptyException extends \Exception
{

}
