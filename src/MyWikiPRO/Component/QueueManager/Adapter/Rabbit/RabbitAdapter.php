<?php

namespace MyWikiPRO\Component\QueueManager\Adapter\Rabbit;

use MyWikiPRO\Component\QueueManager\Entity\Message;
use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;
use MyWikiPRO\Component\QueueManager\Message\EncodedMessage;
use MyWikiPRO\Component\QueueManager\Exchange;
use MyWikiPRO\Component\QueueManager\Queue;

/**
 * Менеджер очередей / Адаптер для rabbitMQ
 *
 * Class RabbitAdapter
 * @package MyWikiPRO\Component\QueueManager\Adapter\Rabbit
 */
final class RabbitAdapter implements AdapterInterface
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
     * @var RabbitChannelProxy
     */
    private $channel;

    /**
     * Constructor
     *
     * @param RabbitChannelProxy $channel
     */
    public function __construct(RabbitChannelProxy $channel)
    {
        $this->channel   = $channel;
        $this->queues    = [];
        $this->exchanges = [];
    }

    /**
     * {@inheritdoc}
     */
    public function publish(
        Exchange\ExchangeConfiguration $configuration,
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
    public function get(Queue\QueueConfiguration $configuration)
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
    public function bind(Exchange\ExchangeConfiguration $exchangeConfig, Queue\QueueConfiguration $queueConfig, $routingKey)
    {
        return $this
            ->declareQueue($queueConfig)
            ->bind($this->declareExchange($exchangeConfig)->getName(), $routingKey)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function ack(Queue\QueueConfiguration $configuration, $id)
    {
        return $this->declareQueue($configuration)->ack($id);
    }

    /**
     * {@inheritdoc}
     */
    public function nack(Queue\QueueConfiguration $configuration, $id)
    {
        return $this->declareQueue($configuration)->nack($id, AMQP_REQUEUE);
    }

    /**
     * Объявить обменник
     *
     * @param Exchange\ExchangeConfiguration $configuration
     * @return \AMQPExchange
     */
    private function declareExchange(Exchange\ExchangeConfiguration $configuration)
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
     * @param Queue\QueueConfiguration $configuration
     * @return \AMQPQueue
     */
    private function declareQueue(Queue\QueueConfiguration $configuration)
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
