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
    
	public function execute($_options = array())
	{
        $eqLogic = $this->getEqLogic();
		log::add('shutters', 'debug', 'shuttersCmd::execute() : eqLogic => ' . $eqLogic->getName() . ' ; received cmd => ' . $this->getLogicalId());
		switch ($this->getConfiguration('objectType')) {
			case 'externalInfo':
				if ($this->getType() === 'action' && $this->getConfiguration('group') === 'shutterFunctions') {
					$this->updateShutterFunctionsStatus($this, $_options['select']);
				}
				break;
		}
	}

	private function updateShutterFunctionsStatus ($_cmd, $_value) 
	{
		if (!is_object($_cmd) || empty($_value)) {
			log::add('shutters', 'debug', 'shuttersCmd::initShutterFunctionStatus() => invalid parameters ; cmd => '. $_cmd . ' ; value => ' . $_value);
			return;
		}
		$eqLogic = $_cmd->getEqLogic();
		$eqLogicName = $eqLogic->getName();
		$statusCmdLogicalId = $_cmd->getLogicalId() . 'Status';
		$linkedCmd = $_cmd->getConfiguration('linkedCmd');
		if (empty($eqLogic->getConfiguration($linkedCmd)) || $_value === 'Disable') {
			$eqLogic->checkAndUpdateCmd($statusCmdLogicalId, __('Désactivée', __FILE__));
			log::add('shutters', 'debug', 'shuttersCmd::initShutterFunctionStatus() : eqLogic => ' . $eqLogicName . ' ; cmd => ' . $statusCmdLogicalId . ' ; updated status => ' . $eqLogic->getCmd(null, $statusCmdLogicalId)->execCmd());
			return; 
		} 
		if ($_value === 'Enable') {
			$eqLogic->checkAndUpdateCmd($statusCmdLogicalId, __('Activée', __FILE__));
			log::add('shutters', 'debug', 'shuttersCmd::initShutterFunctionStatus() : eqLogic => ' . $eqLogicName . ' ; cmd => ' . $statusCmdLogicalId . ' ; updated status => ' . $eqLogic->getCmd(null, $statusCmdLogicalId)->execCmd());
		}
	}


    /*     * **********************Getteur Setteur*************************** */
}
