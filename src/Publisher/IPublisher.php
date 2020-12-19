<?php declare(strict_types = 1);

/**
 * IPublisher.php
 *
 * @license        More in license.md
 * @copyright      https://www.fastybird.com
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 * @package        FastyBird:RabbitMqPlugin!
 * @subpackage     Publisher
 * @since          0.1.0
 *
 * @date           08.03.20
 */

namespace FastyBird\RabbitMqPlugin\Publisher;

use FastyBird\ApplicationExchange\Publisher as ApplicationExchangePublisher;

/**
 * RabbitMQ exchange publisher interface
 *
 * @package        FastyBird:RabbitMqPlugin!
 * @subpackage     Publisher
 *
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 */
interface IPublisher extends ApplicationExchangePublisher\IPublisher
{

}
