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

use phpOMS\Module\StatusAbstract;

/**
 * Search class.
 *
 * @package Modules\Search\Admin
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class Status extends StatusAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;
}
