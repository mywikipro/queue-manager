<?php

namespace MyWikiPRO\Component\QueueManager\Adapter;

/**
 * Interface AdapterFactoryInterface
 * @package MyWikiPRO\Component\QueueManager\Adapter
 */
interface AdapterFactoryInterface
{
    /**
     * Create an adapter instance
     *
     * @param ConfigurationInterface $configuration)
     * @return AdapterInterface
     */
    public function create(ConfigurationInterface $configuration);
}
