<?php

namespace MyWikiPRO\Component\Queue\Manager\Queue;

use MyWikiPRO\Component\Queue\Entity\MessageInterface;

/**
 * Менеджер очередей / Интерфейс очереди
 *
 * Interface QueueInterface
 * @package MyWikiPRO\Component\Queue\Manager\Queue
 */
interface QueueInterface
{
    /**
     * Название очереди
     *
     * @return string
     */
    public function getName();

    /**
     * Конфигурация очереди
     *
     * Конфигурацию нельзя изменять, если очередь уже инициализирована
     * Если нужна другая конфигурация, нужно создать еще одну очередь
     *
     * @return Configuration
     */
    public function getConfiguration();

    /**
     * Получить сообщение из очереди
     *
     * @return MessageInterface
     */
    public function get();

    /**
     * Получить сообщение из очереди с автоматическим удалением
     *
     * @return MessageInterface
     */
    public function shift();

    /**
     * Удалить сообдение из очереди
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Вернуть сообщение в очередь
     *
     * @param  mixed $id
     * @return mixed
     */
    public function unlock($id);
}
