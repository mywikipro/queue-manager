<?php

namespace MyWikiPRO\Component\QueueManager\Decoder;

use Exception;
use MyWikiPRO\Component\Collection\AbstractCollection;

/**
 * Менеджер очередей / Коллекция декодеров сообщений
 *
 * Class Collection
 * @package MyWikiPRO\Component\QueueManager\Decoder
 */
class Collection extends AbstractCollection
{
    /**
     * Добавить декодер
     *
     * @param DecoderInterface $plugin
     * @return $this
     * @throws Exception
     */
    public function attach(DecoderInterface $plugin)
    {
        if (!$this->getByContentType($plugin->getContentType(), false)) {
            $this->collection[] = $plugin;
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
     * @return DecoderInterface|null
     * @throws Exception
     */
    public function getByContentType($type, $throwException = true)
    {
        foreach ($this->collection as $plugin) {
            /** @var DecoderInterface $plugin */
            if ($plugin->getContentType() === $type) {
                return $plugin;
            }
        }
        if ($throwException) {
            throw new Exception('Обработчик не найден');
        }

        return null;
    }
}
