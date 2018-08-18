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
                $cmd = $this->getConfiguration('absenceInfoCmd', null);
                if (!empty($cmd)) {
                    $cmdId=cmd::byId(str_replace('#','',$cmd));
                    $cmdName = $cmdId->getHumanName();
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Information d\'absence] La commande ' . $cmdName .' est inconnue!', __FILE__));
                        return;
                    }
                    if (empty($this->getConfiguration('absenceInfoCmdStatus'))) {
                        throw new \Exception (__('[Information d\'absence] Veuillez valider le statut de la commande ' . $cmdName, __FILE__));
                        return;
                    } 
                }
                $cmd = $this->getConfiguration('presenceInfoCmd', null);
                if (!empty($cmd)) {
                    $cmdId=cmd::byId(str_replace('#','',$cmd));
                    $cmdName = $cmdId->getHumanName();
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Information de présence] La commande ' . $cmdName .' est inconnue!', __FILE__));
                        return;
                    }
                    if (empty($this->getConfiguration('presenceInfoCmdStatus'))) {
                        throw new \Exception (__('[Information de présence] Veuillez valider le statut de la commande ' . $cmdName, __FILE__));
                        return;
                    } 
                }
                $cmd = $this->getConfiguration('fireDetectionCmd', null);
                if (!empty($cmd)) {
                    $cmdId=cmd::byId(str_replace('#','',$cmd));
                    $cmdName = $cmdId->getHumanName();
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Détection incendie] La commande ' . $cmdName .' est inconnue!', __FILE__));
                        return;
                    }
                    if (empty($this->getConfiguration('fireDetectionCmdStatus'))) {
                        throw new \Exception (__('[Détection incendie] Veuillez valider le statut de la commande ' . $cmdName, __FILE__));
                        return;
                    } 
                }
                $cmd = $this->getConfiguration('outdoorLuminosityCmd', null);
                if (!empty($cmd)) {
                    $cmdId=cmd::byId(str_replace('#','',$cmd));
                    $cmdName = $cmdId->getHumanName();
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Luminosité extérieure] La commande ' . $cmdName .' est inconnue!', __FILE__));
                        return;
                    }
                    if (empty($this->getConfiguration('outdoorLuminosityCmdStatus'))) {
                        throw new \Exception (__('[Luminosité extérieure] Veuillez valider le statut de la commande ' . $cmdName, __FILE__));
                        return;
                    } 
                }
                $cmd = $this->getConfiguration('outdoorTemperatureCmd', null);
                if (!empty($cmd)) {
                    $cmdId=cmd::byId(str_replace('#','',$cmd));
                    $cmdName = $cmdId->getHumanName();
                    if (!is_object($cmdId)) {
                        throw new \Exception (__('[Température extérieure] La commande ' . $cmdName .' est inconnue!', __FILE__));
                        return;
                    }
                    if (empty($this->getConfiguration('outdoorTemperatureCmdStatus'))) {
                        throw new \Exception (__('[Température extérieure] Veuillez valider le statut de la commande ' . $cmdName, __FILE__));
                        return;
                    } 
                }
    
            } elseif($objectType === 'heliotropeZone') {
                $heliotrope = eqLogic::byId($this->getConfiguration('heliotrope'));
                if (!(is_object($heliotrope) && $heliotrope->getEqType_name() == 'heliotrope')) {
                    throw new \Exception (__('L\'équipement héliotrope doit être renseigné!', __FILE__));
                    return;
                }        

                if (!in_array($this->getConfiguration('dawnType'), $dawnTypeList, true)) {
                    throw new \Exception (__('Le lever du soleil doit être renseigné!', __FILE__));
                    return;
                }        
                if (!in_array($this->getConfiguration('duskType'), $duskTypeList, true)) {
                    throw new \Exception (__('La coucher du soleil doit être renseigné!', __FILE__));
                    return;
                } 
                $wallAngleUnit = $this->getConfiguration('wallAngleUnit');
                $wallAngle = $this->getConfiguration('wallAngle');
                if (!in_array($wallAngleUnit, $angleUnitList, true)) {
                    throw new \Exception (__('L\'unité de l\'angle doit être renseignée!', __FILE__));
                    return;
                } 
                if ($wallAngleUnit == 'deg' && ($wallAngle < 0 || $wallAngle > 360)) {
                    throw new \Exception (__('L\'angle de la façade par rapport au nord doit être renseigné et compris entre 0 et 360°!', __FILE__));
                    return;
                }
                if ($wallAngleUnit == 'gon' && ($wallAngle < 0 || $wallAngle > 400)) {
                    throw new \Exception (__('L\'angle de la façade par rapport au nord doit être renseigné et compris entre 0 et 400gon!', __FILE__));
                    return;
                }
            
            } elseif($objectType === 'shutter') {
                    if (!in_array($this->getConfiguration('openingType'), $openingTypeList, true)) {
                        throw new \Exception (__('Le type d\'ouvrant associé au volet doit être renseigné!', __FILE__));
                        return;
                    }
                    if (!empty($this->getConfiguration('openOpeningInfo'))) {
                        $cmdId=cmd::byId(str_replace('#','',$this->getConfiguration('openOpeningInfo')));
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Information ouvrant ouvert] La commande sélectionnée est inconnue!', __FILE__));
                            return;
                        }
                    }
                    $positionSensorType = $this->getConfiguration('positionSensorType');
                    if ($positionSensorType == 'analogPosition') {
                            if (empty($this->getConfiguration('shutterAnalogPosition'))) {
                                throw new \Exception (__('La commande de retour de position du volet doit être renseignée!', __FILE__));
                                return;
                            } 
                            $cmdId=cmd::byId(str_replace('#','',$this->getConfiguration('shutterAnalogPosition')));
                            if (!is_object($cmdId)) {
                                throw new \Exception (__('[Retour de position du volet] La commande sélectionnée est inconnue!', __FILE__));
                                return;
                            }
                            $analogClosedPosition = $this->getConfiguration('analogClosedPosition');
                            $analogOpenedPosition = $this->getConfiguration('analogOpenedPosition');
                            if ($analogClosedPosition < 0 || $analogClosedPosition > 5) {
                                throw new \Exception (__('La position volet fermé doit être renseignée et comprise entre 0% et 5%!', __FILE__));
                                return;
                            }        
                            if ($analogOpenedPosition < 95 || $analogOpenedPosition > 100) {
                                throw new \Exception (__('La position volet ouvert doit être renseignée et comprise entre 95% et 100%!', __FILE__));
                                return;
                            }        
    
                    } 
                    if ($positionSensorType == 'openedClosedSensor' || $positionSensorType == 'closedSensor') {
                        if (empty($this->getConfiguration('closedSensor'))) {
                            throw new \Exception (__('La commande de retour du fin de course fermé doit être renseignée!', __FILE__));
                            return;
                        }        
                        $cmdId=cmd::byId(str_replace('#','',$this->getConfiguration('closedSensor')));
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Fin de course fermeture] La commande sélectionnée est inconnue!', __FILE__));
                            return;
                        }
                    } 
                    if ($positionSensorType == 'openedClosedSensor' || $positionSensorType == 'openedSensor') {
                        if (empty($this->getConfiguration('openedSensor'))) {
                            throw new \Exception (__('La commande de retour du fin de course ouvert doit être renseignée!', __FILE__));
                            return;
                        }        
                        $cmdId=cmd::byId(str_replace('#','',$this->getConfiguration('openedSensor')));
                        if (!is_object($cmdId)) {
                            throw new \Exception (__('[Fin de course ouverture] La commande sélectionnée est inconnue!', __FILE__));
                            return;
                        }
                    }
                    if (!empty($shutterArea)) {
                        if ($incomingAzimuthAngle < 0 || $incomingAzimuthAngle > 100) {
                            $exceptionMessage = __('L\'angle d\'entrée du soleil dans l\'ouvrant doit être renseigné!', __FILE__);
                        }        
                        if ($outgoingAzimuthAngle  < 0 || $outgoingAzimuthAngle > 100) {
                            $exceptionMessage = __('L\'angle de sortie du soleil de l\'ouvrant doit être renseigné!', __FILE__);
                        }        
                        if ($outgoingAzimuthAngle < $incomingAzimuthAngle) {
                            $exceptionMessage = __('L\'angle de sortie du soleil de l\'ouvrant doit être supérieur à l\'angle d\'entrée!', __FILE__);
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

    public function throwException($exceptionMessage = null, bool $writeToLog = false)
    {
        if (isset($exceptionMessage)) {
            throw new \Exception($exceptionMessage);
            if ($writeToLog) {
                log::add('shutters','debug','[exception] => '.$exceptionMessage);
            }
        }

    }

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
				if ((isset($command['logicalId']) && $existingCmd->getLogicalId() == $command['logicalId'])
					|| (isset($command['name']) && $existingCmd->getName() == $command['name'])) {
					$cmd = $existingCmd;
					break;
				}
			}
			if ($cmd == null || !is_object($cmd)) {
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

