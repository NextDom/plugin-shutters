<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */


/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class shuttersCmd extends cmd
{
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/**
	 * Update shutters function status
	 */
	private static function updateShutterFunctionsStatus ($_cmd, $_value) 
	{
		if (!is_object($_cmd) || empty($_value)) {
			log::add('shutters', 'debug', 'shuttersCmd::updateShutterFunctionsStatus() : invalid parameters ; cmd => '. $_cmd . ' ; value => ' . $_value);
			return;
		}
		$cmdEqLogic = $_cmd->getEqLogic();
		$cmdEqLogicId = $cmdEqLogic->getId();
		$cmdEqType = $_cmd->getConfiguration('eqType', null);
		$cmdShutterFunction = $_cmd->getConfiguration('shutterFunction', null);
		foreach (eqLogic::byType('shutters') as $shutterEqLogic) {
			if ($shutterEqLogic->getConfiguration('eqType', null) !== 'shutter') {
				continue;
			}
			switch ($cmdEqType) {
                case 'externalInfo':
					$infoCmdConfigKey = $_cmd->getConfiguration('infoCmdConfigKey', null);
					$linkedEqLogicId = $shutterEqLogic->getConfiguration('shutterExternalInfoLink', null);
					$enableShutterFunction = (empty($cmdEqLogic->getConfiguration($infoCmdConfigKey, null)) || $_value === 'Disable') ? false : true;
                    break;
                case 'heliotropeZone':
                    $linkedEqLogicId = $shutterEqLogic->getConfiguration('shutterHeliotropeZoneLink', null);
					$enableShutterFunction = ($_value === 'Disable') ? false : true;
                    break;
                case 'shuttersGroup':
                    $linkedEqLogicId = $shutterEqLogic->getConfiguration('shuttersGroupLink', null);
					$enableShutterFunction = ($_value === 'Disable') ? false : true;
					break;
				case 'shutter':
					$linkedEqLogicId = 	$shutterEqLogic->getId();
					$enableShutterFunction = ($_value === 'Disable') ? false : true;
					break;
            }
			if ($linkedEqLogicId === null || $linkedEqLogicId !== $cmdEqLogicId) {
				continue;
			}
			foreach ($shutterEqLogic->getCmd('info') as $shutterInfoCmd) {
				if ($shutterInfoCmd->getConfiguration('shutterFunction', null) === $cmdShutterFunction) {
					if (!$enableShutterFunction) {
						$shutterEqLogic->checkAndUpdateCmd($shutterInfoCmd->getLogicalId(), __('Inactive', __FILE__));
					} else {
						$cmdEqLogic->checkAndUpdateCmd($statusCmdLogicalId, __('Active', __FILE__));
					}
					log::add('shutters', 'debug', 'shuttersCmd::updateShutterFunctionsStatus() : eqLogic => ' . $shutterEqLogic->getName() . ' ; cmd => ' . $shutterInfoCmd->getLogicalId() . ' ; updated status => ' . $$shutterInfoCmd->execCmd());
				}
			}
		}
	}

	/*     * *********************Methode d'instance************************* */
    
	public function execute($_options = array())
	{
        $thisEqLogic = $this->getEqLogic();
		log::add('shutters', 'debug', 'shuttersCmd::execute() : eqLogic => ' . $thisEqLogic->getName() . ' ; received cmd => ' . $this->getLogicalId());

		if ($this->getType() === 'action' && $this->getConfiguration('group', null) === 'shutterFunctions' && !empty($this->getConfiguration('shutterFunction', null))) {
			shuttersCmd::updateShutterFunctionsStatus($this, $_options['select']);
		}
	}



    /*     * **********************Getteur Setteur*************************** */
}
