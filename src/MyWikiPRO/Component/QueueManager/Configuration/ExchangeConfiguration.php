<?php

namespace MyWikiPRO\Component\QueueManager\Configuration;

use Exception;
use MyWikiPRO\Component\QueueManager\Exchange;

/**
 * Менеджер очередей / Конфигурация обменника
 *
 * Class Configuration
 * @package MyWikiPRO\Component\QueueManager\Configuration
 */
final class ExchangeConfiguration
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $type
     *
     * @throws Exception
     */
    public function __construct($name, $type)
    {
        if ( ! in_array($type, $this->getTypes(), true)) {
            throw new Exception(sprintf(
                'Wrong exchange type `%s`, expected one of [%s]',
                $type, implode(',', $this->getTypes())
            ));
        }

        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Название обменника
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Тип обменника
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Доступные типы
     *
     * @return array
     */
    public function getTypes()
    {
        return [
            Exchange::TYPE_DIRECT,
            Exchange::TYPE_TOPIC,
            Exchange::TYPE_FANOUT,
        ];
    }
}
