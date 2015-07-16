<?php

namespace MyWikiPRO\Component\QueueManager\Adapter\Rabbit;


/**
 * Class Channel
 * @package MyWikiPRO\Component\QueueManager\Adapter\Rabbit
 */
class RabbitChannelProxy
{
    /**
     * @var \AMQPChannel
     */
    private $channel;

    /**
     * Constructor
     *
     * @param RabbitConfiguration $config
     */
    public function __construct(RabbitConfiguration $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannel()
    {
        if (null === $this->channel) {
            $connection = new \AMQPConnection($this->config->toAMQPConnectionParams());
            $connection->connect();

            $this->channel = new \AMQPChannel($connection);
        }

        return $this->channel;
    }
}
