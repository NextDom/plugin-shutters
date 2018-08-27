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
try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');
    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }
    
    if (init('action') === 'listEqByType') {
        $return['externalInfo'] = array();
        $return['heliotropeZone'] = array();
        $return['shuttersGroup'] = array();
        $return['shutter'] = array();
		foreach (eqLogic::byType('shutters') as $eqLogic) {
            if (!is_object($eqLogic) || $eqLogic->getIsEnable() === false) {
                continue;
            }
            $eqLogicInfo = array(
                'id' => $eqLogic->getId(),
                'name' => $eqLogic->getName(),
            );
            switch ($eqLogic->getConfiguration('eqType')) {
                case 'externalInfo':
                    $return['externalInfo'][] = $eqLogicInfo;
                    break;
                case 'heliotropeZone':
                    $return['heliotropeZone'][] = $eqLogicInfo;
                    break;
                case 'shuttersGroup':
                    $return['shuttersGroup'][] = $eqLogicInfo;
                    break;
                case 'shutter':
                    $return['shutter'][] = $eqLogicInfo;
                    break;
            }
        }
        ajax::success($return);
    }

    if (init('action') === 'getEqLogic') {
		$eqLogicType = init('type');
		if ($eqLogicType === '' || !class_exists($eqLogicType)) {
			throw new Exception(__('Type eqLogic incorrect (classe équipement inexistante) : ', __FILE__) . $eqLogicType);
		}
		$eqLogic = $eqLogicType::byId(init('id'));
		if (!is_object($eqLogic)) {
			throw new Exception(__('EqLogic inconnu. Vérifiez l\'ID ', __FILE__) . init('id'));
		}
		$return = utils::o2a($eqLogic);
		$return['cmd'] = utils::o2a($eqLogic->getCmd());
		ajax::success(jeedom::toHumanReadable($return));
	}
    
    if (init('action') === 'getCmdStatus') {
        $cmdId = str_replace('#','',cmd::humanReadableToCmd(init('cmd')));
        $cmd = cmd::byId($cmdId);
        if (!is_object($cmd)) {
            throw new Exception(__('La commande sélectionnée est inconnue : ', __FILE__) . init('cmd'));
        }
        if ($cmd->getType() !== 'info') {
            throw new Exception(__('La commande sélectionnée n\'est pas de type [info] : ', __FILE__) . init('cmd'));
        }
        $cmdStatus = $cmd->execCmd();
        ajax::success($cmdStatus);
    }

    if (init('action') === 'execCmd') {
        $cmdId = str_replace('#','',cmd::humanReadableToCmd(init('cmd')));
        $cmd = cmd::byId($cmdId);
        if (!is_object($cmd)) {
            throw new Exception(__('La commande sélectionnée est inconnue : ', __FILE__) . init('cmd'));
        }
        if ($cmd->getType() !== 'action') {
            throw new Exception(__('La commande sélectionnée n\'est pas de type [action] : ', __FILE__) . init('cmd'));
        }
        $cmd->execute(null);
        ajax::success(true);
    }
    
    throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
    /***********Catch exception***************/
} catch (Exception $e) {
    ajax::error(displayException($e), $e->getCode());
}
