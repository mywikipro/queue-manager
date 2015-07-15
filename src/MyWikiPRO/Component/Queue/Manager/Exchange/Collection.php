<?php

namespace MyWikiPRO\Component\Queue\Manager\Exchange;

use MyWikiPRO\Component\Collection\AbstractCollection;

/**
 * Менеджер очередей / Коллекция обменников
 *
 * Class Collection
 * @package MyWikiPRO\Component\Queue\Manager\Exchange
 */
class Collection extends AbstractCollection
{
    /**
     * Добавить обменник
     *
     * @param ExchangeInterface $exchange
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function attach(ExchangeInterface $exchange)
    {
        if (isset($this->collection[$exchange->getName()])) {
            throw new \RuntimeException(sprintf('Exchange `%s` already exists', $exchange->getName()));
        }

        $this->collection[$exchange->getName()] = $exchange;
        return $this;
    }

    /**
     * Получить обработчик по типу
     *
     * @param string $name
     *
     * @return ExchangeInterface
     * @throws \RuntimeException
     */
    public function getByName($name)
    {
        if ( ! isset($this->collection[$name])) {
            throw new \RuntimeException(sprintf('Exchange `%s` not found', $name));
        }

        return $this->collection[$name];
    }
}
