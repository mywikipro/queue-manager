<?php

namespace MyWikiPRO\Component\Queue\Manager\Adapter\Rabbit;

use MyWikiPRO\Component\Queue\Entity\Message;
use MyWikiPRO\Component\Queue\Manager\Adapter\AdapterInterface;
use MyWikiPRO\Component\Queue\Manager\Message\EncodedMessage;
use MyWikiPRO\Component\Queue\Manager\Exchange;
use MyWikiPRO\Component\Queue\Manager\Queue;

/**
 * Менеджер очередей / Адаптер для rabbitMQ
 *
 * Class Adapter
 * @package MyWikiPRO\Component\Queue\Manager\Adapter\Rabbit
 */
final class Adapter implements AdapterInterface
{
    /**
     * @var \AMQPQueue[]
     */
    private $queues;

    /**
     * @var \AMQPExchange[]
     */
    private $exchanges;

    /**
     * @var ChannelProxy
     */
    private $channel;

    /**
     * Constructor
     *
     * @param ChannelProxy $channel
     */
    public function __construct(ChannelProxy $channel)
    {
        $this->channel   = $channel;
        $this->queues    = [];
        $this->exchanges = [];
    }

    /**
     * {@inheritdoc}
     */
    public function publish(
        Exchange\Configuration $configuration,
        $routingKey,
        $message,
        $contentType,
        $attempt,
        $priority
    ) {
        return $this->declareExchange($configuration)->publish($message, $routingKey, AMQP_NOPARAM, [
            'content_type' => $contentType,
            'priority'     => $priority,
            'headers'      => [
                'attempt'  => $attempt,
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(Queue\Configuration $configuration)
    {
        $envelope = $this->declareQueue($configuration)->get();
        if ($envelope) {
            return new EncodedMessage(
                new Message(
                    $envelope->getDeliveryTag(),
                    $envelope->getBody(),
                    $envelope->getHeader('attempt')
                ),
                $envelope->getContentType()
            );
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function bind(Exchange\Configuration $exchangeConfig, Queue\Configuration $queueConfig, $routingKey)
    {
        return $this
            ->declareQueue($queueConfig)
            ->bind($this->declareExchange($exchangeConfig)->getName(), $routingKey)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function ack(Queue\Configuration $configuration, $id)
    {
        return $this->declareQueue($configuration)->ack($id);
    }

    /**
     * {@inheritdoc}
     */
    public function nack(Queue\Configuration $configuration, $id)
    {
        return $this->declareQueue($configuration)->nack($id, AMQP_REQUEUE);
    }

    /**
     * Объявить обменник
     *
     * @param Exchange\Configuration $configuration
     * @return \AMQPExchange
     */
    private function declareExchange(Exchange\Configuration $configuration)
    {
        if ( ! isset($this->exchanges[$configuration->getName()])) {
            $exchange = new \AMQPExchange($this->channel->getChannel());
            $exchange->setName($configuration->getName());
            $exchange->setType($configuration->getType());
            $exchange->declareExchange();

            $this->exchanges[$configuration->getName()] = $exchange;
        }

        return $this->exchanges[$configuration->getName()];
    }

    /**
     * Объявить очередь
     *
     * @param Queue\Configuration $configuration
     * @return \AMQPQueue
     */
    private function declareQueue(Queue\Configuration $configuration)
    {
        if ( ! isset($this->queues[$configuration->getName()])) {
            $attributes = [];

            if ($configuration->getTimeout() > 0) {
                $attributes = array_merge($attributes, [
                    'x-message-ttl' => $configuration->getMicroTimeout(),
                ]);

                if ($configuration->getTimeoutRoute()) {
                    $routeConfig = $configuration->getTimeoutRoute();
                    $attributes  = array_merge($attributes, [
                        'x-dead-letter-exchange'    => $routeConfig->getExchangeConfiguration()->getName(),
                        'x-dead-letter-routing-key' => $routeConfig->getRoutingKey(),
                    ]);
                }
            }

            if ($configuration->getMaxPriority() > 0) {
                $attributes = array_merge($attributes, [
                    'x-max-priority' => $configuration->getMaxPriority(),
                ]);
            }

            $queue = new \AMQPQueue($this->channel->getChannel());
            $queue->setName($configuration->getName());
            $queue->setFlags(AMQP_DURABLE);
            $queue->setArguments($attributes);
            $queue->declareQueue();

            $this->queues[$configuration->getName()] = $queue;
        }

        return $this->queues[$configuration->getName()];
    }


}
