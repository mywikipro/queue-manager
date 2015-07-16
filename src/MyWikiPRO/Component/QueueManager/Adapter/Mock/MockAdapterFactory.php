<?php

namespace MyWikiPRO\Component\QueueManager\Adapter\Mock;

use MyWikiPRO\Component\QueueManager\Adapter\AdapterFactoryInterface;
use MyWikiPRO\Component\QueueManager\Adapter\ConfigurationInterface;

/**
 * Class MockAdapterFactory
 * @package MyWikiPRO\Component\QueueManager\Adapter\Mock
 */
class MockAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ConfigurationInterface $configuration)
    {
        if ( ! $configuration instanceof MockConfiguration) {
            throw new \RuntimeException('Expected %s' . MockConfiguration::class);
        }

        return new MockAdapter($configuration);
    }
}
