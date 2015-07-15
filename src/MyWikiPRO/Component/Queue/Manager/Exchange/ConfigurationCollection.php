<?php

namespace MyWikiPRO\Component\Queue\Manager\Exchange;

use Exception;
use MyWikiPRO\Component\Collection\AbstractCollection;

/**
 * Менеджер очередей / Коллекция конфигураций обменников
 *
 * Class ConfigurationCollection
 * @package MyWikiPRO\Component\Queue\Manager\Exchange
 */
class ConfigurationCollection extends AbstractCollection
{
    /**
     * Добавить конфигурацию
     *
     * @param Configuration $config
     * @return $this
     * @throws Exception
     */
    public function attach(Configuration $config)
    {
        if (isset($this->collection[$config->getName()])) {
            throw new \RuntimeException(sprintf('Exchange configuration `%s` already exists', $config->getName()));
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
     * @throws Exception
     */
    public function getByName($name)
    {
        if ( ! isset($this->collection[$name])) {
            throw new \RuntimeException(sprintf('Exchange configuration `%s` not found', $name));
        }

        return $this->collection[$name];
    }
}
