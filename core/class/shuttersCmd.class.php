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
	/*     * *********************Methode d'instance************************* */
    
    public function execute($_options = array()) {
        $eqLogic = $this->getEqLogic();
		log::add('shutters', 'debug', 'eqLogic => ' . $eqLogic->getName() . ' ; received cmd => ' . $this->getLogicalId() . ' ; cmd value => '. $_options['select']);
		switch ($this->getConfiguration('type')) {
			case 'externalInfo':
				if ($this->getType() === 'action') {
					$this->updateShutterFunctionsStatus($this, $_options['select'], $this->getConfiguration('configuredCmd'));
				}
				break;
		}
	}

	public function updateShutterFunctionsStatus ($_cmd, $_value, $_configuredCmd) {
		$eqLogic = $_cmd->getEqLogic();
		$eqLogicName = $eqLogic->getName();
		$statusCmdName = $_cmd->getLogicalId() . 'Status';
		if (empty($eqLogic->getConfiguration($_configuredCmd)) || $_value === 'Disable') {
			$eqLogic->checkAndUpdateCmd($statusCmdName, __('Désactivée', __FILE__));
			log::add('shutters', 'debug', 'eqLogic => ' . $eqLogicName . ' ; cmd => ' . $statusCmdName . ' ; updated status => ' . $eqLogic->getCmd(null, $statusCmdName)->execCmd());
			return; 
		} 
		if ($_value === 'Enable') {
			$eqLogic->checkAndUpdateCmd($statusCmdName, __('Activée', __FILE__));
			log::add('shutters', 'debug', 'eqLogic => ' . $eqLogicName . ' ; cmd => ' . $statusCmdName . ' ; updated status => ' . $eqLogic->getCmd(null, $statusCmdName)->execCmd());
		}
	}


    /*     * **********************Getteur Setteur*************************** */
}
