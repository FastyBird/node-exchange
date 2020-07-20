<?php declare(strict_types = 1);

/**
 * ConsumerCommand.php
 *
 * @license        More in license.md
 * @copyright      https://fastybird.com
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 * @package        FastyBird:NodeExchange!
 * @subpackage     Commands
 * @since          0.1.0
 *
 * @date           03.03.20
 */

namespace FastyBird\NodeExchange\Commands;

use FastyBird\NodeExchange;
use FastyBird\NodeExchange\Exceptions;
use Nette;
use Psr\Log;
use Symfony\Component\Console;
use Symfony\Component\Console\Input;
use Symfony\Component\Console\Output;
use Throwable;

/**
 * Exchange messages consumer console command
 *
 * @package        FastyBird:NodeExchange!
 * @subpackage     Commands
 *
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 */
final class ConsumerCommand extends Console\Command\Command
{

	use Nette\SmartObject;

	/** @var NodeExchange\Exchange */
	private $exchange;

	/** @var Log\LoggerInterface */
	private $logger;

	public function __construct(
		NodeExchange\Exchange $exchange,
		?Log\LoggerInterface $logger = null,
		?string $name = null
	) {
		parent::__construct($name);

		$this->exchange = $exchange;

		$this->logger = $logger ?? new Log\NullLogger();
	}

	/**
	 * {@inheritDoc}
	 */
	protected function configure(): void
	{
		parent::configure();

		$this
			->setName('fb:node:consumer:start')
			->setDescription('Start exchange consumer.');
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(
		Input\InputInterface $input,
		Output\OutputInterface $output
	): int {
		$this->logger->info('[FB:EXCHANGE] Starting exchange queue consumer');

		try {
			$this->exchange->initialize();
			$this->exchange->run();

		} catch (Exceptions\TerminateException $ex) {
			// Log error action reason
			$this->logger->warning('[FB:EXCHANGE] Stopping exchange consumer', [
				'exception' => [
					'message' => $ex->getMessage(),
					'code'    => $ex->getCode(),
				],
				'cmd'       => $this->getName(),
			]);

			$this->exchange->stop();

			return $ex->getCode();

		} catch (Throwable $ex) {
			// Log error action reason
			$this->logger->error('[FB:EXCHANGE] Stopping exchange consumer', [
				'exception' => [
					'message' => $ex->getMessage(),
					'code'    => $ex->getCode(),
				],
				'cmd'       => $this->getName(),
			]);

			$this->exchange->stop();

			return $ex->getCode();
		}

		return 0;
	}

}
