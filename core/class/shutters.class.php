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
require_once 'shuttersCmd.class.php';

class shutters extends eqLogic
{
    /*     * *************************Attributs****************************** */



    /*     * ***********************Methode static*************************** */

    /*
     * Fonction exécutée automatiquement toutes les minutes par Jeedom
      public static function cron() {

      }
     */


    /*
     * Fonction exécutée automatiquement toutes les heures par Jeedom
      public static function cronHourly() {

      }
     */

    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom
      public static function cronDaily() {

      }
     */



    /*     * *********************Méthodes 
    d'instance************************* */

    public function preInsert()
    {
        $this->setConfiguration('isObjectCreated', false);
    }

    public function postInsert()
    {

    }

    public function preSave()
    {

    }

    public function postSave()
    {
   
    }

    public function preUpdate()
    {
        $exceptionMessage = NULL;

        $openingTypeList = array('window', 'door');
        $dawnTypeList =  array('sunrise', 'civilDawn', 'nauticalDawn', 'astronomicalDawn');
        $duskTypeList = array('sunset', 'civilDusk', 'nauticalDusk', 'astronomicalDusk');
        $angleUnitList = array('deg', 'gon');

        $objectType = $this->getConfiguration('objectType', null);
        $isObjectCreated = $this->getConfiguration('isObjectCreated', false);

        $incomingAzimuthAngle = $this->getConfiguration('outgoingAzimuthAngle', null);
        $outgoingAzimuthAngle = $this->getConfiguration('outgoingAzimuthAngle', null);
        $shutterArea = $this->getConfiguration('shutterArea', null);

        if (empty($objectType)) {
            throw new \Exception (__('Le type d\'équipement doit être renseigné!', __FILE__));
            return;
        }
        if ($isObjectCreated) {
            log::add('shutters','debug', '[isObjectCreated] => '.$isObjectCreated);
            if ($objectType === 'externalInfo') {
                $cmd = str_replace('#','',$this->getConfiguration('absenceInfoCmd', null));
                if (!empty($cmd)) {
                    $cmdId=cmd::byId($cmd);
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Information d\'absence] La commande suivante est inconnue : ', __FILE__) . $cmd);
                        return;
                    }
                    if (empty($this->getConfiguration('absenceInfoCmdStatus', null))) {
                        throw new \Exception (__('[Information d\'absence] Veuillez valider le statut de la commande ', __FILE__) . $cmdId->getHumanName());
                        return;
                    } 
                }
                $cmd = str_replace('#','',$this->getConfiguration('presenceInfoCmd', null));
                if (!empty($cmd)) {
                    $cmdId=cmd::byId($cmd);
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Information de présence] La commande suivante est inconnue : ', __FILE__) . $cmd);
                        return;
                    }
                    if (empty($this->getConfiguration('presenceInfoCmdStatus', null))) {
                        throw new \Exception (__('[Information de présence] Veuillez valider le statut de la commande ', __FILE__) . $cmdId->getHumanName());
                        return;
                    } 
                }
                $cmd = str_replace('#','',$this->getConfiguration('fireDetectionCmd', null));
                if (!empty($cmd)) {
                    $cmdId=cmd::byId($cmd);
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Détection incendie] La commande suivante est inconnue : ', __FILE__) . $cmd);
                        return;
                    }
                    if (empty($this->getConfiguration('fireDetectionCmdStatus', null))) {
                        throw new \Exception (__('[Détection incendie] Veuillez valider le statut de la commande ', __FILE__) . $cmdId->getHumanName());
                        return;
                    } 
                }
                $cmd = str_replace('#','',$this->getConfiguration('outdoorLuminosityCmd', null));
                if (!empty($cmd)) {
                    $cmdId=cmd::byId($cmd);
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Luminosité extérieure] La commande suivante est inconnue : ', __FILE__) . $cmd);
                        return;
                    }
                    if (empty($this->getConfiguration('outdoorLuminosityCmdStatus', null))) {
                        throw new \Exception (__('[Luminosité extérieure] Veuillez valider le statut de la commande ', __FILE__) . $cmdId->getHumanName());
                        return;
                    } 
                }
                $cmd = str_replace('#','',$this->getConfiguration('outdoorTemperatureCmd', null));
                if (!empty($cmd)) {
                    $cmdId=cmd::byId($cmd);
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Température extérieure] La commande suivante est inconnue : ', __FILE__) . $cmd);
                        return;
                    }
                    if (empty($this->getConfiguration('outdoorTemperatureCmdStatus', null))) {
                        throw new \Exception (__('[Température extérieure] Veuillez valider le statut de la commande ', __FILE__) . $cmdId->getHumanName());
                        return;
                    } 
                }
    
            } elseif($objectType === 'heliotropeZone') {
                $heliotrope = eqLogic::byId($this->getConfiguration('heliotrope', null));
                if (!(is_object($heliotrope) && $heliotrope->getEqType_name() === 'heliotrope')) {
                    throw new \Exception (__('L\'équipement héliotrope doit être renseigné!', __FILE__));
                    return;
                }        

                if (!in_array($this->getConfiguration('dawnType', null), $dawnTypeList, true)) {
                    throw new \Exception (__('Le lever du soleil doit être renseigné!', __FILE__));
                    return;
                }        
                if (!in_array($this->getConfiguration('duskType', null), $duskTypeList, true)) {
                    throw new \Exception (__('La coucher du soleil doit être renseigné!', __FILE__));
                    return;
                } 
                $wallAngleUnit = $this->getConfiguration('wallAngleUnit', null);
                $wallAngle = $this->getConfiguration('wallAngle', null);
                if (!in_array($wallAngleUnit, $angleUnitList, true)) {
                    throw new \Exception (__('L\'unité de l\'angle doit être renseignée!', __FILE__));
                    return;
                } 
                if ($wallAngleUnit === 'deg' && ($wallAngle < 0 || $wallAngle > 360)) {
                    throw new \Exception (__('L\'angle de la façade par rapport au nord doit être renseigné et compris entre 0 et 360°!', __FILE__));
                    return;
                }
                if ($wallAngleUnit === 'gon' && ($wallAngle < 0 || $wallAngle > 400)) {
                    throw new \Exception (__('L\'angle de la façade par rapport au nord doit être renseigné et compris entre 0 et 400gon!', __FILE__));
                    return;
                }
            
            } elseif($objectType === 'shutter') {
                if (!in_array($this->getConfiguration('openingType', null), $openingTypeList, true)) {
                    throw new \Exception (__('Le type d\'ouvrant associé au volet doit être renseigné!', __FILE__));
                    return;
                }
                $cmd = str_replace('#','',$this->getConfiguration('openOpeningInfoCmd', null));
                if (!empty($cmd)) {
                    $cmdId=cmd::byId($cmd);
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Information ouvrant ouvert] La commande suivante est inconnue : ', __FILE__) . $cmd);
                        return;
                    }
                    if (empty($this->getConfiguration('openOpeningInfoCmdStatus', null))) {
                        throw new \Exception (__('[Information ouvrant ouvert] Veuillez valider le statut de la commande ', __FILE__) . $cmdId->getHumanName());
                        return;
                    } 
                }
                $shutterPositionType = $this->getConfiguration('shutterPositionType', null);
                if ($shutterPositionType === 'analogPosition') {
                    $cmd = str_replace('#','',$this->getConfiguration('shutterAnalogPositionCmd', null));
                    if (!empty($cmd)) {
                        $cmdId=cmd::byId($cmd);
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Position du volet] La commande suivante est inconnue : ', __FILE__) . $cmd);
                            return;
                        }
                        if ($cmdId->getSubType() !== 'numeric') {
                            throw new \Exception (__('[Position du volet] La commande suivante n\'est pas de type numeric : ', __FILE__) . $cmdId->getHumanName());
                            return;
                        }
                    } else {
                        throw new \Exception (__('[Position du volet] La commande doit être renseignée!', __FILE__));
                        return;
                    }
                    $analogClosedPosition = $this->getConfiguration('analogClosedPosition', null);
                    $min = (int)(str_replace('%','',$this->getConfiguration('analogClosedPositionMin', null)));
                    $max = (int)(str_replace('%','',$this->getConfiguration('analogClosedPositionMax', null)));
                    if ($analogClosedPosition < $min || $analogClosedPosition > $max) {
                        throw new \Exception (__('La position volet fermé doit être renseignée et comprise dans la plage ', __FILE__) . '[' . $min . '% - ' . $max . '%]');
                        return;
                    }        
                    $analogOpenedPosition = $this->getConfiguration('analogOpenedPosition', null);
                    $min = (int)(str_replace('%','',$this->getConfiguration('analogOpenedPositionMin', null)));
                    $max = (int)(str_replace('%','',$this->getConfiguration('analogOpenedPositionMax', null)));
                    if ($analogOpenedPosition < $min || $analogOpenedPosition > $max) {
                        throw new \Exception (__('La position volet ouvert doit être renseignée et comprise dans la plage ', __FILE__) .  '[' . $min . '% - ' . $max . '%]');
                        return;
                    }        
                } 
                if ($shutterPositionType === 'closedOpenedPositions' || $shutterPositionType === 'closedPosition') {
                    $cmd = str_replace('#','',$this->getConfiguration('closedPositionCmd', null));
                    if (!empty($cmd)) {
                        $cmdId=cmd::byId($cmd);
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Position volet fermé] La commande suivante est inconnue : ', __FILE__) . $cmd);
                            return;
                        }
                        if (empty($this->getConfiguration('closedPositionCmdStatus', null))) {
                            throw new \Exception (__('[Position volet fermé] Veuillez valider le statut de la commande ', __FILE__) . $cmdId->getHumanName());
                            return;
                        } 
                    } else {
                        throw new \Exception (__('[Position volet fermé] La commande doit être renseignée!', __FILE__));
                        return;
                    }
                } 
                if ($shutterPositionType === 'closedOpenedPositions' || $shutterPositionType === 'openedPosition') {
                    $cmd = str_replace('#','',$this->getConfiguration('openedPositionCmd', null));
                    if (!empty($cmd)) {
                        $cmdId=cmd::byId($cmd);
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Position volet ouvert] La commande suivante est inconnue : ', __FILE__) . $cmd);
                            return;
                        }
                        if (empty($this->getConfiguration('openedPositionCmdStatus', null))) {
                            throw new \Exception (__('[Position volet ouvert] Veuillez valider le statut de la commande ', __FILE__) . $cmdId->getHumanName());
                            return;
                        } 
                    } else {
                        throw new \Exception (__('[Position volet ouvert] La commande doit être renseignée!', __FILE__));
                        return;
                    }
                }
                $shutterCmdType = $this->getConfiguration('shutterCmdType', null);
                if ($shutterCmdType === 'analogPositionCmd') {
                    $cmd = str_replace('#','',$this->getConfiguration('analogPositionCmd', null));
                    if (!empty($cmd)) {
                        $cmdId=cmd::byId($cmd);
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Commande analogique] La commande suivante est inconnue : ', __FILE__) . $cmd);
                            return;
                        }
                        if ($cmdId->getSubType() !== 'slider') {
                            throw new \Exception (__('[Commande analogique] La commande suivante n\'est pas de type slider : ', __FILE__) . $cmdId->getHumanName());
                            return;
                        }
                    } else {
                        throw new \Exception (__('[Commande analogique] La commande doit être renseignée!', __FILE__));
                        return;
                    }
                    $fullClosureSetpoint = $this->getConfiguration('fullClosureSetpoint', null);
                    $min = (int)(str_replace('%','',$this->getConfiguration('fullClosureSetpointMin', null)));
                    $max = (int)(str_replace('%','',$this->getConfiguration('fullClosureSetpointMax', null)));
                    if ($fullClosureSetpoint < $min || $fullClosureSetpoint > $max) {
                        throw new \Exception (__('La consigne fermeture complète du volet doit être renseignée et comprise dans la plage ', __FILE__) . '[' . $min . '% - ' . $max . '%]');
                        return;
                    }        
                    $fullOpeningSetpoint = $this->getConfiguration('fullOpeningSetpoint', null);
                    $min = (int)(str_replace('%','',$this->getConfiguration('fullOpeningSetpointMin', null)));
                    $max = (int)(str_replace('%','',$this->getConfiguration('fullOpeningSetpointMax', null)));
                    if ($fullOpeningSetpoint < $min || $fullOpeningSetpoint > $max) {
                        throw new \Exception (__('La consigne ouverture complète du volet doit être renseignée et comprise dans la plage ', __FILE__) .  '[' . $min . '% - ' . $max . '%]');
                        return;
                    }        
                } elseif ($shutterCmdType === 'OpenCloseStopCmd') {
                    $cmd = str_replace('#','',$this->getConfiguration('closingCmd', null));
                    if (!empty($cmd)) {
                        $cmdId=cmd::byId($cmd);
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Commande fermeture] La commande suivante est inconnue : ', __FILE__) . $cmd);
                            return;
                        }
                        if ($cmdId->getSubType() !== 'other') {
                            throw new \Exception (__('[Commande fermeture] La commande suivante n\'est pas de type other : ', __FILE__) . $cmdId->getHumanName());
                            return;
                        }
                    } else {
                        throw new \Exception (__('[Commande fermeture] La commande doit être renseignée!', __FILE__));
                        return;
                    }
                    $cmd = str_replace('#','',$this->getConfiguration('openingCmd', null));
                    if (!empty($cmd)) {
                        $cmdId=cmd::byId($cmd);
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Commande ouverture] La commande suivante est inconnue : ', __FILE__) . $cmd);
                            return;
                        }
                        if ($cmdId->getSubType() !== 'other') {
                            throw new \Exception (__('[Commande ouverture] La commande suivante n\'est pas de type other : ', __FILE__) . $cmdId->getHumanName());
                            return;
                        }
                    } else {
                        throw new \Exception (__('[Commande ouverture] La commande doit être renseignée!', __FILE__));
                        return;
                    }
                    $cmd = str_replace('#','',$this->getConfiguration('stopCmd', null));
                    if (!empty($cmd)) {
                        $cmdId=cmd::byId($cmd);
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Commande stop] La commande suivante est inconnue : ', __FILE__) . $cmd);
                            return;
                        }
                        if ($cmdId->getSubType() !== 'other') {
                            throw new \Exception (__('[Commande stop] La commande suivante n\'est pas de type other : ', __FILE__) . $cmdId->getHumanName());
                            return;
                        }
                    } else {
                        throw new \Exception (__('[Commande stop] La commande doit être renseignée!', __FILE__));
                        return;
                    }
                }


            } elseif ($objectType === 'shuttersGroup') {
    
                       
            } 
    
        }

        if (!empty($objectType) && !$isObjectCreated) {
            $this->setConfiguration('isObjectCreated', true);
        }

    }
    

    public function postUpdate()
    {
        $this->loadCmdFromConfFile($this->getConfiguration('objectType', null));
    }

    public function preRemove()
    {
        
    }

    public function postRemove()
    {
        
    }

    /**
     * Load commands from JSON file
     */
    public function loadCmdFromConfFile($objectType) {
        $file = dirname(__FILE__) . '/../config/devices/' . $objectType . '.json';
        if (!is_file($file)) {
			return;
		}
		$content = file_get_contents($file);
		if (!is_json($content)) {
			return;
		}
		$device = json_decode($content, true);
		if (!is_array($device) || !isset($device['commands'])) {
			return true;
		}
		foreach ($device['commands'] as $command) {
			$cmd = null;
			foreach ($this->getCmd() as $existingCmd) {
				if ((isset($command['logicalId']) && $existingCmd->getLogicalId() === $command['logicalId'])
					|| (isset($command['name']) && $existingCmd->getName() === $command['name'])) {
					$cmd = $existingCmd;
					break;
				}
			}
			if ($cmd === null || !is_object($cmd)) {
				$cmd = new shuttersCmd();
				$cmd->setEqLogic_id($this->getId());
				utils::a2o($cmd, $command);
				$cmd->save();
			}
		}
    }
    
    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous 
     en avez besoin
      public function toHtml($_version = 'dashboard') {

      }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action après 
     modification de variable de configuration
      public static function postConfig_<Variable>() {
      }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action avant 
     modification de variable de configuration
      public static function preConfig_<Variable>() {
      }
     */

    /*     * **********************Getteur Setteur*************************** */
}

