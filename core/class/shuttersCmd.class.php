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
		log::add('shutters', 'debug', $this->getHumanName() . ': receive cmd => ' . $this->getLogicalId() . ' ; cmd value => '. $_options['select']);
		switch ($this->getLogicalId()) {
			case 'externalInfo:absenceFunction':
				$eqLogic->checkShutterFunctions($_options['select']);
				break;
			case 'externalInfo:presenceFunction':
				$eqLogic->checkShutterFunctions($_options['message']);
				break;
			case 'externalInfo:fireFunction':
				$eqLogic->checkShutterFunctions();
				break;
			case 'externalInfo:temperatureFunction':
				$eqLogic->checkShutterFunctions();
				break;
			case 'externalInfo:luminosityFunction':
				$eqLogic->checkShutterFunctions();
				break;
		}
	}
    /*     * **********************Getteur Setteur*************************** */
}
