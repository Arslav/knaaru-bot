<?php

namespace Tests\Support\Module;

use Arslav\Bot\App;
use Codeception\Exception\ModuleException;
use Codeception\Lib\Interfaces\DoctrineProvider;
use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Codeception\Module\Cli;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

//TODO: Сделать модуль более гибким и в виде отдельного пакета
class Database extends Module implements DoctrineProvider
{
    protected static bool $migrated = false;

    protected ?Container $container;

    /**
     * @param ModuleContainer $moduleContainer
     * @param array|null $config
     * @throws \Exception
     */
    public function __construct(ModuleContainer $moduleContainer, ?array $config = null)
    {
        $this->container = App::getContainer();
        parent::__construct($moduleContainer, $config);
    }

    /**
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     * @throws Exception
     * @throws ModuleException
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    protected function migrate(): void
    {
        if (!self::$migrated) {
            $database = $this->container->get('DB_NAME');
            $this->createDatabase($database);

            /** @var Cli $cli */
            $cli = $this->getModule(Cli::class);
            $cli->runShellCommand("DB_NAME=$database bin/doctrine migrations:migrate -n");
            self::$migrated = true;
        }
    }

    /**
     * @return EntityManager
     *
     * @throws DependencyException
     * @throws ModuleException
     * @throws NotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function _getEntityManager(): EntityManager
    {
        $this->migrate();
        return App::getEntityManager();
    }

    /**
     * @param string $database
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     * @throws Exception
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    protected function createDatabase(string $database): void
    {
        $params = $this->container->get('DbConnectionParams');
        unset($params['dbname']);

        $manager = DriverManager::getConnection($params)->createSchemaManager();
        if (!in_array($database, $manager->listDatabases())) {
            $manager->createDatabase($database);
        }
    }
}
