<?php

namespace MyWikiPRO\Component\QueueManager\Decoder;

use MyWikiPRO\Component\QueueManager\Configuration\ExchangeConfiguration;
use MyWikiPRO\Component\QueueManager\Configuration\QueueConfiguration;
use MyWikiPRO\Component\QueueManager\Entity\Message;
use MyWikiPRO\Component\QueueManager\Entity\MessageInterface;
use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;
use MyWikiPRO\Component\QueueManager\Message\EncodedMessage;
use Exception;

/**
 * Менеджер очередей / Декодер для адаптера
 *
 * Class Adapter
 * @package MyWikiPRO\Component\QueueManager\Decoder
 */
final class Adapter implements AdapterInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var Collection
     */
    private $decoderCollection;

    /**
     * Constructor
     *
     * @param AdapterInterface $adapter
     * @param Collection        $decoderCollection
     */
    public function __construct(AdapterInterface $adapter, Collection $decoderCollection)
    {
        $this->adapter           = $adapter;
        $this->decoderCollection = $decoderCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        return $this->adapter->init();
    }

    /**
     * {@inheritdoc}
     */
    public function bind(ExchangeConfiguration $exchangeConfig, QueueConfiguration $queueConfig, $routingKey)
    {
        return $this->adapter->bind($exchangeConfig, $queueConfig, $routingKey);
    }

    /**
     * {@inheritdoc}
     */
    public function publish(
        ExchangeConfiguration $configuration,
        $routingKey,
        $message,
        $contentType,
        $attempt,
        $priority
    ) {
        return $this->adapter->publish(
            $configuration,
            $routingKey,
            $this->getDecoderByContentType($contentType)->encode($message),
            $contentType,
            $attempt,
            $priority
        );
    }

    /**
     * {@inheritdoc}
     */
    public function get(QueueConfiguration $configuration)
    {
        $message = $this->adapter->get($configuration);
        if ($message instanceof MessageInterface) {
            if (!($message instanceof EncodedMessage)) {
                throw new Exception('Получен неверный тип сообщения');
            }

            return new Message(
                $message->getId(),
                $this->getDecoderByContentType($message->getContentType())->decode($message->getMessage()),
                $message->getAttempt()
            );
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function ack(QueueConfiguration $configuration, $id)
    {
        return $this->adapter->ack($configuration, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function nack(QueueConfiguration $configuration, $id)
    {
        return $this->adapter->nack($configuration, $id);
    }

    /**
     * Получить декодер для сообщения
     *
     * @param string $contentType
     * @return \MyWikiPRO\Component\QueueManager\Decoder\DecoderInterface
     */
    private function getDecoderByContentType($contentType)
    {
        return $this->decoderCollection->getByContentType($contentType);
    }
}
