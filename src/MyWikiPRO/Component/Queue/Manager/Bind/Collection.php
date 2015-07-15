<?php

namespace MyWikiPRO\Component\Queue\Manager\Bind;

use Exception;
use MyWikiPRO\Component\Collection\AbstractCollection;

/**
 * Менеджер очередей / Коллекция связей
 *
 * Class Collection
 * @package MyWikiPRO\Component\Queue\Manager\Bind
 */
class Collection extends AbstractCollection
{
    /**
     * Добавить обменник
     *
     * @param Configuration $config
     * @return $this
     * @throws Exception
     */
    public function attach(Configuration $config)
    {
        if (!$this->getByHash($config->getHash(), false)) {
            $this->collection[] = $config;
        } else {
            throw new Exception('Обработчик уже был добавлен');
        }

        return $this;
    }

    /**
     * Получить обработчик по типу
     *
     * @param string $type
     * @param bool   $throwException
     *
     * @return Configuration|null
     * @throws Exception
     */
    public function getByHash($type, $throwException = true)
    {
        foreach ($this->collection as $config) {
            /** @var Configuration $config */
            if ($config->getHash() === $type) {
                return $config;
            }
        }
        if ($throwException) {
            throw new Exception('Обработчик не найден');
        }

        return null;
    }
}
