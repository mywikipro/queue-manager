<?php

namespace MyWikiPRO\Component\Queue\Consumer;

/**
 * Менеджер очередей / Исключение консьюмера очередей (срабатывает в обработчике, если неудалось получить сообщение)
 *
 * Class Exception
 * @package MyWikiPRO\Component\Queue\Consumer
 */
class EmptyException extends \Exception
{

}
