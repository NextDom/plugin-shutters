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

        $objectType = $this->getConfiguration('objectType');
        $openingType = $this->getConfiguration('openingType');
        $positionSensorType = $this->getConfiguration('positionSensorType');
        $shutterAnalogPosition = $this->getConfiguration('shutterAnalogPosition');
        $analogClosedPosition = $this->getConfiguration('analogClosedPosition');
        $analogOpenedPosition = $this->getConfiguration('analogOpenedPosition');
        $closedLimitSwith = $this->getConfiguration('closedLimitSwith');
        $openedLimitSwith = $this->getConfiguration('openedLimitSwith');
        $heliotrope = eqLogic::byId($this->getConfiguration('heliotrope'));
        $dawnType = $this->getConfiguration('dawnType');
        $duskType = $this->getConfiguration('duskType');
        $incomingAzimuthAngle = $this->getConfiguration('outgoingAzimuthAngle');
        $outgoingAzimuthAngle = $this->getConfiguration('outgoingAzimuthAngle');
        $shutterArea = $this->getConfiguration('shutterArea');

        if($objectType == 'shutter') {

                if (!in_array($openingType, $openingTypeList, true)) {
                    $exceptionMessage = __('Le type d\'ouvrant associé au volet doit être renseigné!', __FILE__);
                    throwException($exceptionMessage, true);
                }

                if ($positionSensorType = 'analog') {
                        if (empty($shutterAnalogPosition)){
                            $exceptionMessage = __('La commande de retour de position du volet doit être renseignée!', __FILE__);
                        } 
                        if ($analogClosedPosition < 0 || $analogClosedPosition > 100){
                            $exceptionMessage = __('La position fermeture du volet doit être renseignée et comprise entre 0% et 100%!', __FILE__);
                        }        
                        if($analogOpenedPosition < 0 || $analogOpenedPosition > 100){
                            $exceptionMessage = __('La position ouverture du volet doit être renseignée et comprise entre 0% et 100%!', __FILE__);
                        }        
                        if($analogOpenedPosition < $analogClosedPosition){
                            $exceptionMessage = __('La position analogique d\'ouverture du volet doit être supérieure à la position analogique de fermeture!', __FILE__);
                        } 

                } elseif ($positionSensorType = 'openedClosedLimitSwitch' || $positionSensorType = 'closedLimitSwitch') {
                    if(empty($closedLimitSwitch)){
                        $exceptionMessage =__('La commande de retour du fin de course fermé doit être renseignée!', __FILE__);
                    }        
    
                } elseif ($positionSensorType = 'openedClosedLimitSwitch' || $positionSensorType = 'openedLimitSwitch') {
                    if(empty($openedLimitSwitch)){
                        $exceptionMessage = __('La commande de retour du fin de course ouvert doit être renseignée!', __FILE__);
                    }        
                }
                if (!empty($shutterArea)) {
                    if($incomingAzimuthAngle < 0 || $incomingAzimuthAngle > 100){
                        $exceptionMessage = __('L\'angle d\'entrée du soleil dans l\'ouvrant doit être renseigné!', __FILE__);
                    }        
                    if($outgoingAzimuthAngle  < 0 || $outgoingAzimuthAngle > 100){
                        $exceptionMessage = __('L\'angle de sortie du soleil de l\'ouvrant doit être renseigné!', __FILE__);
                    }        
                    if($outgoingAzimuthAngle < $incomingAzimuthAngle){
                        $exceptionMessage = __('L\'angle de sortie du soleil de l\'ouvrant doit être supérieur à l\'angle d\'entrée!', __FILE__);
                    } 
                }
    
        } elseif ($objectType == 'shuttersArea'){

            if (!(is_object($heliotrope) && $heliotrope->getEqType_name() == 'heliotrope')) {
                $exceptionMessage = __('L\'objet héliotrope doit être renseigné!', __FILE__);
            }        
            if(!in_array($dawnType, $dawnTypeList, true)){
                $exceptionMessage = __('Le lever du soleil doit être renseigné!', __FILE__);
            }        
            if(!in_array($duskType, $duskTypeList, true)){
                $exceptionMessage = __('La coucher du soleil doit être renseigné!', __FILE__);
            }        
                   
        } else {
            $exceptionMessage = __('Le type d\'objet doit être renseignée!', __FILE__);
        }

    }
    

    public function postUpdate()
    {

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
            throw new Exception($exceptionMessage);
            if ($writeToLog) {
                log::add('shutters','debug','[exception] => '.$exceptionMessage);
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
