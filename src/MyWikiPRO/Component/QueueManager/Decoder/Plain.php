<?php

namespace MyWikiPRO\Component\QueueManager\Decoder;

/**
 * Менеджер очередей / Декодер данных очереди в формате "как есть"
 *
 * Class Plain
 * @package MyWikiPRO\Component\QueueManager\Decoder
 */
final class Plain implements DecoderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return DecoderInterface::TYPE_PLAIN;
    }

    /**
     * {@inheritdoc}
     */
    public function encode($data)
    {
        $this->validate($data);
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function decode($data)
    {
        $this->validate($data);
        return $data;
    }

    /**
     * Проверка данных
     *
     * @param string $data
     * @throws Exception
     */
    private function validate($data)
    {
        if (!is_string($data)) {
            throw new Exception(sprintf('Переданы неправильные данные %s', $data));
        }
    }
}
