<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

namespace PrestaShop\Module\Psshipping\Domain\Cloudsync;

use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManager as LegacyModuleManager;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use PrestaShop\PrestaShop\Core\Module\ModuleManager;
use Psshipping;

if (!defined('_PS_VERSION_')) {
    exit();
}

class CloudsyncService
{
    /**
     * @param Psshipping $module
     *
     * @return array<string, string|boolean|null>
     *
     * @throws CloudsyncIsNotInstalledException
     **/
    public function getCloudsyncContext(Psshipping $module): array
    {
        /** @var ModuleManagerBuilder $moduleManagerBuilder */
        $moduleManagerBuilder = ModuleManagerBuilder::getInstance();

        if (version_compare(_PS_VERSION_, '1.7.7.0', '>=')) {
            /** @var ModuleManager $moduleManager */
            $moduleManager = $moduleManagerBuilder->build();
        } else {
            /** @var LegacyModuleManager $moduleManager */
            $moduleManager = $moduleManagerBuilder->build();
        }

        $cloudsyncIsInstalled = $moduleManager->isInstalled('ps_eventbus');

        if (!$cloudsyncIsInstalled) {
            throw new CloudsyncIsNotInstalledException('Cloudsync (ps_eventbus) module is not installed, please install it.');
        }

        $eventbusModule = \Module::getInstanceByName('ps_eventbus');
        if ($eventbusModule && version_compare($eventbusModule->version, '1.9.0', '>=')) {
            /* @phpstan-ignore-next-line */
            $eventbusPresenterService = $eventbusModule->getService('PrestaShop\Module\PsEventbus\Service\PresenterService');

            return $eventbusPresenterService->expose($module, ['info', 'modules', 'themes', 'orders']);
        }

        return [];
    }
}
