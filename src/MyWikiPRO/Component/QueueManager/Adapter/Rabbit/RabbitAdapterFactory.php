<?php

namespace MyWikiPRO\Component\QueueManager\Adapter\Rabbit;

use MyWikiPRO\Component\QueueManager\Adapter\AdapterFactoryInterface;
use MyWikiPRO\Component\QueueManager\Adapter\ConfigurationInterface;

/**
 * Class RabbitAdapterFactory
 * @package MyWikiPRO\Component\QueueManager\Adapter\Rabbit
 */
class RabbitAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ConfigurationInterface $configuration)
    {
        if ( ! $configuration instanceof RabbitConfiguration) {
            throw new \RuntimeException('Expected %s' . RabbitConfiguration::class);
        }

        return new RabbitAdapter(new RabbitChannelProxy($configuration));
    }
}
