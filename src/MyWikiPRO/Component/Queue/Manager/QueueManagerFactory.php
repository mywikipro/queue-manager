<?php

namespace MyWikiPRO\Component\Queue\Manager;

/**
 * Менеджер очередей / Фабрика создания менеджера очередей
 *
 * Class AdapterFactory
 * @package MyWikiPRO\Component\Queue\Manager
 */
class QueueManagerFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(Configuration\ConfigurationInterface $configuration)
    {
        $adapter = $this->getDecoderAdapter($configuration);

        return new QueueManager(
            $this->getQueueCollection($adapter, $configuration),
            $this->getExchangeCollection($adapter, $configuration)
        );
    }

    /**
     * Получить экземпляр адаптера
     *
     * @param Configuration\ConfigurationInterface $configuration
     * @return Adapter\AdapterInterface
     */
    private function getDecoderAdapter(Configuration\ConfigurationInterface $configuration)
    {
        $collection = new Decoder\Collection();
        $collection
            ->attach(new Decoder\Json())
            ->attach(new Decoder\Plain())
            ->attach(new Decoder\Serialize());

        return new Decoder\Adapter($this->getAdapter($configuration), $collection);
    }

    /**
     * Получить экземпляр адаптера
     *
     * @param Configuration\ConfigurationInterface $configuration
     *
     * @return Adapter\AdapterInterface
     * @throws \RuntimeException
     */
    private function getAdapter(Configuration\ConfigurationInterface $configuration)
    {
        $adapterConfig = $configuration->getAdapterConfig();
        switch ($adapterConfig->getType()) {
            case Adapter\AdapterInterface::TYPE_RABBIT:
                /** @var Adapter\Rabbit\Configuration $adapterConfig */
                return new Adapter\Rabbit\Adapter($adapterConfig);
            case Adapter\AdapterInterface::TYPE_MOCK:
                /** @var Adapter\Mock\Configuration $adapterConfig */
                return new Adapter\Mock\Adapter($adapterConfig);
        }

        throw new \RuntimeException('Не найден адаптер');
    }

    /**
     * Получить коллекцию очередей
     *
     * @param Adapter\AdapterInterface             $adapter
     * @param Configuration\ConfigurationInterface $configuration
     *
     * @return Queue\Collection
     */
    private function getQueueCollection(Adapter\AdapterInterface $adapter, Configuration\ConfigurationInterface $configuration)
    {
        $collection = new Queue\Collection();
        foreach ($configuration->getQueueCollection() as $config) {
            /** @var Queue\Configuration $config */
            $collection->attach(new Queue\Queue($adapter, $config));
        }

        return $collection;
    }

    /**
     * Получить коллекцию обменников
     *
     * @param Adapter\AdapterInterface             $adapter
     * @param Configuration\ConfigurationInterface $configuration
     *
     * @return Exchange\Collection
     */
    private function getExchangeCollection(Adapter\AdapterInterface $adapter, Configuration\ConfigurationInterface $configuration)
    {
        $collection = new Exchange\Collection();
        foreach ($configuration->getExchangeCollection() as $config) {
            /** @var Exchange\Configuration $config */
            $collection->attach(new Exchange\Exchange($adapter, $config));
        }

        return $collection;
    }
}
