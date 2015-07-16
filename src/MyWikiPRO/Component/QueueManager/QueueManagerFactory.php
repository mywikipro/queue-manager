<?php

namespace MyWikiPRO\Component\QueueManager;

use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;
use MyWikiPRO\Component\QueueManager\Adapter\Mock\MockAdapterFactory;
use MyWikiPRO\Component\QueueManager\Adapter\Rabbit\RabbitAdapterFactory;

/**
 * Менеджер очередей / Фабрика создания менеджера очередей
 *
 * Class AdapterFactory
 * @package MyWikiPRO\Component\QueueManager
 */
class QueueManagerFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(Configuration\Configuration $configuration)
    {
        $adapter = $this->getDecoderAdapter($configuration);

        return new QueueManager($adapter, $configuration);
    }

    /**
     * Получить экземпляр адаптера
     *
     * @param Configuration\Configuration $configuration
     * @return AdapterInterface
     */
    private function getDecoderAdapter(Configuration\Configuration $configuration)
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
     * @param Configuration\Configuration $configuration
     *
     * @return AdapterInterface
     * @throws \RuntimeException
     */
    private function getAdapter(Configuration\Configuration $configuration)
    {
        $adapterConfig = $configuration->getAdapterConfig();
        switch ($adapterConfig->getType()) {
            case AdapterInterface::TYPE_RABBIT:
                $factory = new RabbitAdapterFactory();
                break;
            case AdapterInterface::TYPE_MOCK:
                $factory = new MockAdapterFactory();
                break;
            default:
                throw new \RuntimeException('Не найден адаптер');
        }

        return $factory->create($adapterConfig);
    }
}
