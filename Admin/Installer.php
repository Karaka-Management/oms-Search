<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Search\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Search\Admin;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\Config\SettingsInterface;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;
use phpOMS\System\File\PathException;
use phpOMS\System\File\PermissionException;
use phpOMS\Utils\Parser\Php\ArrayParser;

/**
 * Installer class.
 *
 * @package Modules\Search\Admin
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;

    /**
     * Commands.
     *
     * Include consideres the state of the file during script execution.
     * This means setting it to empty has no effect if it was not empty before.
     * There are also other merging bugs that can happen.
     *
     * @var array
     * @since 1.0.0
     */
    private static array $commands = [];

    /**
     * Is first command load?
     *
     * Include consideres the state of the file during script execution.
     * This means setting it to empty has no effect if it was not empty before.
     * There are also other merging bugs that can happen.
     *
     * @var bool
     * @since 1.0.0
     */
    private static bool $isFirstLoad = true;

    /**
     * {@inheritdoc}
     */
    public static function install(ApplicationAbstract $app, ModuleInfo $info, SettingsInterface $cfgHandler) : void
    {
        if (!\is_writable(__DIR__ . '/')) {
            throw new PermissionException(__DIR__ . '/');
        }

        if (\is_file(__DIR__ . '/SearchCommands.php')) {
            if (!\is_writable(__DIR__ . '/SearchCommands.php')) {
                throw new PermissionException(__DIR__ . '/SearchCommands.php');
            }

            \unlink(__DIR__ . '/SearchCommands.php');
        }

        \file_put_contents(__DIR__ . '/SearchCommands.php', '<?php return [];');
        self::$isFirstLoad = false;
        parent::install($app, $info, $cfgHandler);
    }

    /**
     * Install data from providing modules.
     *
     * @param ApplicationAbstract $app  Application
     * @param array               $data Additional data
     *
     * @return array
     *
     * @throws PathException This exception is thrown if the Search install file couldn't be found
     * @throws \Exception    This exception is thrown if the Search install file is invalid json
     *
     * @since 1.0.0
     */
    public static function installExternal(ApplicationAbstract $app, array $data) : array
    {
        if (!\is_file(__DIR__ . '/SearchCommands.php')) {
            \file_put_contents(__DIR__ . '/SearchCommands.php', '<?php return [];');
        }

        if (!\is_file($data['path'] ?? '')) {
            return [];
        }

        if (!\is_file(__DIR__ . '/SearchCommands.php')) {
            throw new PathException(__DIR__ . '/SearchCommands.php');
        }

        if (!\is_writable(__DIR__ . '/SearchCommands.php')) {
            throw new PermissionException(__DIR__ . '/SearchCommands.php');
        }

        if (self::$isFirstLoad) {
            /** @noinspection PhpIncludeInspection */
            self::$commands    = include __DIR__ . '/SearchCommands.php';
            self::$isFirstLoad = false;
        }

        /** @noinspection PhpIncludeInspection */
        $moduleRoutes = include $data['path'];

        self::$commands = \array_merge_recursive(self::$commands, $moduleRoutes);

        \file_put_contents(__DIR__ . '/SearchCommands.php', '<?php return ' . ArrayParser::serializeArray(self::$commands) . ';', \LOCK_EX);

        return [];
    }
}
