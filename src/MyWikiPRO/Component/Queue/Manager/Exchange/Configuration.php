<?php

namespace MyWikiPRO\Component\Queue\Manager\Exchange;

use Exception;

/**
 * Менеджер очередей / Конфигурация обменника
 *
 * Class Configuration
 * @package MyWikiPRO\Component\Queue\Manager\Exchange
 */
final class Configuration
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
            ExchangeInterface::TYPE_DIRECT,
            ExchangeInterface::TYPE_TOPIC,
            ExchangeInterface::TYPE_FANOUT,
        ];
    }
}
