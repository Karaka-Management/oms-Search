<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Search\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
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
 * @license OMS License 1.0
 * @link    https://karaka.app
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
     * {@inheritdoc}
     */
    public static function install(ApplicationAbstract $app, ModuleInfo $info, SettingsInterface $cfgHandler) : void
    {
        if (\file_exists(__DIR__ . '/../SearchCommands.php')) {
            \unlink(__DIR__ . '/../SearchCommands.php');
        }

        \file_put_contents(__DIR__ . '/../SearchCommands.php', '<?php return [];');
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
        if (!\file_exists(__DIR__ . '/../SearchCommands.php')) {
            \file_put_contents(__DIR__ . '/../SearchCommands.php', '<?php return [];');
        }

        if (!\file_exists($data['path'] ?? '')) {
            return [];
        }

        if (!\file_exists(__DIR__ . '/../SearchCommands.php')) {
            throw new PathException(__DIR__ . '/../SearchCommands.php');
        }

        if (!\is_writable(__DIR__ . '/../SearchCommands.php')) {
            throw new PermissionException(__DIR__ . '/../SearchCommands.php');
        }

        /** @noinspection PhpIncludeInspection */
        $appRoutes = include __DIR__ . '/../SearchCommands.php';
        /** @noinspection PhpIncludeInspection */
        $moduleRoutes = include $data['path'];

        $appRoutes = \array_merge_recursive($appRoutes, $moduleRoutes);

        \file_put_contents(__DIR__ . '/../SearchCommands.php', '<?php return ' . ArrayParser::serializeArray($appRoutes) . ';', \LOCK_EX);

        return [];
    }
}
