<?php

namespace MyWikiPRO\Component\QueueManager\Message;

use MyWikiPRO\Component\QueueManager\Entity\Message;
use MyWikiPRO\Component\QueueManager\Entity\MessageInterface;

/**
 * Менеджер очередей / Закодированное сообщение пришедшее из адаптера
 *
 * Class EncodedMessage
 * @package MyWikiPRO\Component\QueueManager\Message
 */
class EncodedMessage implements MessageInterface
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @var string
     */
    private $contentType;

    /**
     * Constructor
     *
     * @param Message $message
     * @param string  $contentType
     */
    public function __construct(Message $message, $contentType)
    {
        $this->message     = $message;
        $this->contentType = $contentType;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->message->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message->getMessage();
    }

    /**
     * {@inheritdoc}
     */
    public function getAttempt()
    {
        return $this->message->getAttempt();
    }

    public function isInfinityAttempt()
    {
        return $this->message->isInfinityAttempt();
    }

    /**
     * Получить тип кодирования
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }
}
