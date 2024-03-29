<?php

require_once "vendor/autoload.php";

$srmq = new \Lib\SimpleRabbitMQ();
$srmq->config();
$srmq->open();
$srmq->exchange("my_exchange");
$srmq->queue("my_queue");
$srmq->queueBind();

$callback1 = function($message, $consumer) {
    echo "Message 1: ", $message->getBody(), PHP_EOL;
    $consumer->acknowledge($message);
    return true;
};
$srmq->sub($callback1);

$callback2 = function($message, $consumer) {
    echo "Message 2: ", $message->getBody(), PHP_EOL;
    $consumer->acknowledge($message);
    return true;
};
$srmq->sub($callback2);

//$srmq->readMessage();
$srmq->waitCallbacks(15000); //15s
$srmq->close();
