<?php

namespace MyWikiPRO\Component\Queue\Manager\Adapter\Rabbit;


/**
 * Class Channel
 * @package MyWikiPRO\Component\Queue\Manager\Adapter\Rabbit
 */
class ChannelProxy
{
    /**
     * @var \AMQPChannel
     */
    private $channel;

    /**
     * Constructor
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
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
