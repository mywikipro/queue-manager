<?php

namespace MyWikiPRO\Component\Queue\Manager\Queue;

use MyWikiPRO\Component\Collection\AbstractCollection;

/**
 * Менеджер очередей / Коллекция конфигураций очередей
 *
 * Class ConfigurationCollection
 * @package MyWikiPRO\Component\Queue\Manager\Queue
 */
class ConfigurationCollection extends AbstractCollection
{
    /**
     * Добавить конфигурацию
     *
     * @param Configuration $config
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function attach(Configuration $config)
    {
        if (isset($this->collection[$config->getName()])) {
            throw new \RuntimeException(sprintf('Queue configuration `%s` already exists', $config->getName()));
        }

        $this->collection[$config->getName()] = $config;
        return $this;
    }

    /**
     * Получить обработчик по типу
     *
     * @param string $name
     *
     * @return Configuration|null
     * @throws \RuntimeException
     */
    public function getByName($name)
    {
        if ( ! isset($this->collection[$name])) {
            throw new \RuntimeException(sprintf('Queue configuration `%s` not found', $name));
        }

        return $this->collection[$name];
    }
}
