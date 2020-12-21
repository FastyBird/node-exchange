<?php declare(strict_types = 1);

/**
 * InitializeSubscriber.php
 *
 * @license        More in license.md
 * @copyright      https://www.fastybird.com
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 * @package        FastyBird:RabbitMqPlugin!
 * @subpackage     Subscribers
 * @since          0.1.0
 *
 * @date           21.12.20
 */

namespace FastyBird\RabbitMqPlugin\Subscribers;

use FastyBird\ApplicationEvents\Events as ApplicationEventsEvents;
use FastyBird\RabbitMqPlugin;
use Symfony\Component\EventDispatcher;
use Throwable;

/**
 * Rabbit MQ initialise subscriber
 *
 * @package         FastyBird:RabbitMqPlugin!
 * @subpackage      Subscribers
 *
 * @author          Adam Kadlec <adam.kadlec@fastybird.com>
 */
class InitializeSubscriber implements EventDispatcher\EventSubscriberInterface
{

	/** @var RabbitMqPlugin\Exchange */
	private RabbitMqPlugin\Exchange $exchange;

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			ApplicationEventsEvents\StartupEvent::class  => 'initialize',
		];
	}

	public function __construct(
		RabbitMqPlugin\Exchange $exchange
	) {
		$this->exchange = $exchange;
	}

	/**
	 * @return void
	 *
	 * @throws Throwable
	 */
	public function initialize(): void
	{
		$this->exchange->initializeAsync();
	}

}
