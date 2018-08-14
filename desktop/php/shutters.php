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


if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

include_file('desktop', 'shutters', 'css', 'shutters');

$plugin = plugin::byId('shutters');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());

?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<div class="cursor-tooltip"></div>

<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add">
                    <i class="fa fa-plus-circle"></i> {{Ajouter}}</a>
                <li class="filter" style="margin-bottom: 5px;">
                    <input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%" />
                </li>
                <?php
                foreach ($eqLogics as $eqLogic) {
                    $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                    echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity .'"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
        <legend>
            <i class="fa fa-cog"></i> {{Gestion}}</legend>
        <div class="eqLogicThumbnailContainer">
            <div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
                <i class="fa fa-plus-circle" style="font-size : 6em;color:#33b8cc;"></i>
                <br>
                <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#33b8cc">{{Ajouter}}</span>
            </div>
            <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
                <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
                <br>
                <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}</span>
            </div>
        </div>
        <br>
        <div id="objectList" class="panel-group" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#objectList" href="#externalInfoObjectList"> {{Mes informations générales externes}} </a>
                        <span class="badge">
                            <?php
                                $objectNumber =0;
                                foreach ($eqLogics as $eqLogic) {
                                    if ($eqLogic->getConfiguration('objectType') == 'externalInfo') {
                                        ++$objectNumber;
                                    } 
                                }
                                echo $objectNumber;
                            ?>
                        </span>
                    </h4>
                </div>
                <div id="externalInfoObjectList" class="panel-collapse collapse in">
                    <div class="panel-body"> 
                        <div class="eqLogicThumbnailContainer">
                            <?php
                                foreach ($eqLogics as $eqLogic) {
                                    if ($eqLogic->getConfiguration('objectType') == 'externalInfo') {
                                        $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                                        echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
                                        echo '<img src="plugins/shutters/resources/images/externalInfo.png" height="100" width="100" />';
                                        echo "<br>";
                                        echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                                        echo '</div>';
                                    }
                                }
                            ?>
                        </div>
                    </div> 
                </div>
            </div>  
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#objectList" href="#heliotropeZoneObjectList"> {{Mes zones héliotrope}} </a>
                        <span class="badge">
                            <?php
                                $objectNumber =0;
                                foreach ($eqLogics as $eqLogic) {
                                    if ($eqLogic->getConfiguration('objectType') == 'heliotropeZone') {
                                        ++$objectNumber;
                                    } 
                                }
                                echo $objectNumber;
                            ?>
                        </span>
                    </h4>
                </div>
                <div id="heliotropeZoneObjectList" class="panel-collapse collapse">
                    <div class="panel-body"> 
                        <div class="eqLogicThumbnailContainer">
                            <?php
                                foreach ($eqLogics as $eqLogic) {
                                    if ($eqLogic->getConfiguration('objectType') == 'heliotropeZone') {
                                        $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                                        echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
                                        echo '<img src="plugins/shutters/resources/images/heliotropeZone.png" height="100" width="100" />';
                                        echo "<br>";
                                        echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                                        $externalInfoObject = $eqLogic->getConfiguration('externalInfoObject');
                                        if ($externalInfoObject != null && $externalInfoObject != 'none') {
                                            echo '<span><i class="fas fa-link">' . eqLogic::byId($externalInfoObject)->getName() . '</i></span>';
                                        }
                                        echo '</div>';
                                    }
                                }
                            ?>
                        </div>
                    </div> 
                </div>
            </div>  
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#objectList" href="#shuttersGroupObjectList"> {{Mes groupes de volets}} </a>
                        <span class="badge">
                            <?php
                                $objectNumber =0;
                                foreach ($eqLogics as $eqLogic) {
                                    if ($eqLogic->getConfiguration('objectType') == 'shuttersGroup') {
                                        ++$objectNumber;
                                    } 
                                }
                                echo $objectNumber;
                            ?>
                        </span>
                    </h4>
                </div>
                <div id="shuttersGroupObjectList" class="panel-collapse collapse">
                    <div class="panel-body"> 
                        <div class="eqLogicThumbnailContainer">
                            <?php
                                foreach ($eqLogics as $eqLogic) {
                                    if ($eqLogic->getConfiguration('objectType') == 'shuttersGroup') {
                                        $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                                        echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
                                        echo '<img src="plugins/shutters/resources/images/shuttersGroup.png" height="100" width="100" />';
                                        echo "<br>";
                                        echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                                        echo '</div>';
                                    }
                                }
                            ?>
                        </div>
                    </div> 
                </div>
            </div>  
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#objectList" href="#shutterObjectList"> {{Mes volets}} </a>
                        <span class="badge">
                            <?php
                                $objectNumber =0;
                                foreach ($eqLogics as $eqLogic) {
                                    if ($eqLogic->getConfiguration('objectType') == 'shutter') {
                                        ++$objectNumber;
                                    } 
                                }
                                echo $objectNumber;
                            ?>
                        </span>
                    </h4>
                </div>
                <div id="shutterObjectList" class="panel-collapse collapse">
                    <div class="panel-body"> 
                        <div class="eqLogicThumbnailContainer">
                            <?php
                                foreach ($eqLogics as $eqLogic) {
                                    if ($eqLogic->getConfiguration('objectType') == 'shutter') {
                                        $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                                        echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
                                        echo '<img src="plugins/shutters/resources/images/shutter.png" height="100" width="100" />';
                                        echo "<br>";
                                        echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                                        echo '</div>';
                                    }
                                }
                            ?>
                        </div>
                    </div> 
                </div>
            </div>  
        </div> 
    </div>
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <a class="btn btn-success eqLogicAction pull-right" data-action="save">
            <i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
        <a class="btn btn-danger eqLogicAction pull-right" data-action="remove">
            <i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
        <a class="btn btn-default eqLogicAction pull-right" data-action="configure">
            <i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation">
                <a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay">
                    <i class="fa fa-arrow-circle-left"></i>
                </a>
            </li>
            <li role="presentation" class="active">
                <a href="#eqLogicTab" aria-controls="home" role="tab" data-toggle="tab">
                    <i class="fa fa-microchip"></i> {{Equipement}}</a>
            </li>
            <li role="presentation">
                <a href="#settingsTab" aria-controls="profile" role="tab" data-toggle="tab">
                    <i class="fa fa-wrench"></i> {{Paramètres}}</a>
            </li>
            <li role="presentation">
                <a href="#commandTab" aria-controls="avatar" role="tab" data-toggle="tab">
                    <i class="fa fa-hand-point-up"></i> {{Commandes}}</a>
            </li>
        </ul>
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <div role="tabpanel" class="tab-pane active" id="eqLogicTab">
                <br/>
                <div id="objectSettings" class="panel-group" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#generalSettings"> {{Paramètres généraux}} </a>
                            </h4>
                        </div>
                        <div id="generalSettings" class="panel-collapse collapse in" data-paneltype="generalSettings">
                            <div class="panel-body"> 
                                <form class="form-horizontal">
                                    <div class="col-sm-6">    
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="objectName">{{Nom de l'équipement}}</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display:none" />
                                                <input type="text" id="objectName" name="objectName" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="sel_object">{{Objet parent}}</label>
                                            <div class="col-sm-5">
                                                <select id="sel_object" class="eqLogicAttr cursor form-control" data-l1key="object_id">
                                                    <option value="">{{Aucun}}</option>
                                                    <?php
                                                    foreach (object::all() as $object) {
                                                        echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Catégorie}}</label>
                                            <div class="col-sm-9">
                                                <?php
                                                foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                                                    echo '<label class="checkbox-inline">';
                                                    echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                                                    echo '</label>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Equipement}}</label>
                                            <div class="col-sm-5">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="objectType">{{Type d'équipement}}</label>
                                            <div class="col-sm-5">
                                                <select id="objectType" type="text" class="eqLogicAttr cursor form-control control-lockable" data-l1key="configuration" data-l2key="objectType">
                                                <option value="externalInfo">{{Informations externes générales}}</option>
                                                <option value="heliotropeZone">{{Zone héliotrope}}</option>
                                                <option value="shuttersGroup">{{Groupe de volets}}</option>
                                                <option value="shutter">{{Volet}}</option>
                                                </select>
                                            </div>
                                            <a id="lockObjectTypeSelection" class="button-lock">
                                                <i class="fa fa-unlock button-lock-icon"></i>
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="comment">{{Commentaire}}</label>
                                            <div class="col-sm-5">
                                                <textarea id="comment" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="commentaire"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="configName">{{Nom de la configuration}}</label>
                                            <div class="col-sm-5">
                                                <input type="text" id="configName" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="configName"/>
                                            </div>
                                        </div>
                                    </div> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="settingsTab">
            <br/>
                <div id="objectSettings" class="panel-group" >
                    <div class="panel panel-default display-none" data-paneltype="setting" data-objecttype="externalInfo">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#externalInfoSettings"> {{Informations générales externes}} </a>
                            </h4>
                        </div>
                        <div id="externalInfoSettings" class="panel-collapse collapse">
                            <div class="panel-body"> 
                                <form class="form-horizontal">
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="absenceInfo">{{Information d'absence}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor delCmd" data-type="info" data-input="absenceInfo">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </a>
                                                    </span>
                                                    <input id="absenceInfo" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="absenceInfo" placeholder="{{Sélectionner une commande}}"/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor listCmd" data-type="info" data-input="absenceInfo">
                                                            <i class="fa fa-list-alt"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div id="absenceInfoStatus" class="input-group">
                                                    <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="absenceInfoStatus" placeholder="{{Valider le statut}}" disabled/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor getCmdStatus" data-input="absenceInfoStatus" data-input-link="absenceInfo" data-message="l\'absence est activée?">
                                                            <span class="fa fa-check"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Information de présence}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input id="presenceInformation" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="presenceInformation" placeholder="{{Sélectionner une commande}}"/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor listCmd" data-type="info" data-input="presenceInformation">
                                                            <i class="fa fa-list-alt"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Détection incendie}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input id="fireDetection" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="fireDetection" placeholder="{{Sélectionner une commande}}"/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor listCmd" data-type="info" data-input="fireDetection">
                                                            <i class="fa fa-list-alt"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="heliotrope">{{Héliotrope}}</label>
                                            <div class="col-sm-5">
                                                <select id="heliotrope" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="heliotrope">
                                                    <option value="none">{{Non affecté}}</option>
                                                    <?php
                                                    if (class_exists('heliotropeCmd')) {
                                                        foreach (eqLogic::byType('heliotrope') as $heliotrope) {
                                                            echo '<option value="' . $heliotrope->getId() . '">' . $heliotrope->getName() . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">{{Pas d\'héliotrope disponible}}</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Luminosité extérieure}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input id="outdoorLuminosity" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outdoorLuminosity" placeholder="{{Sélectionner une commande}}"/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor listCmd" data-type="info" data-input="outdoorLuminosity">
                                                            <i class="fa fa-list-alt"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Température extérieure}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input id="outdoorTemperature" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outdoorTemperature" placeholder="{{Sélectionner une commande}}"/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor listCmd" data-type="info" data-input="outdoorTemperature">
                                                            <i class="fa fa-list-alt"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Gestion prioritaire}}</label>
                                            <div class="col-sm-5">
                                                <select id="priorityManagement" type="text" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="priorityManagement">
                                                    <option value="fireManagement">{{Gestion incendie}}</option>
                                                    <option value="absenceManagement">{{Gestion absence}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel panel-default col-sm-8">
                                            <div class="panel-body">
                                                <b>{{Gestion prioritaire}}</b>
                                                <li>{{La gestion prioritaire n'est paramétrable que si les informations d'absence et de détection incendie sont renseignées.}}</li>
                                                <li>{{Absence: les volets se ferment sans tenir compte des autres conditions.}}</li>
                                                <li>{{Incendie: les volets s'ouvrent sans tenir compte des autres conditions.}}</li>
                                             </div>
                                        </div>
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default display-none" data-paneltype="setting" data-objecttype="heliotropeZone">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#heliotropeZoneSettings"> {{Paramètres héliotrope}} </a>
                            </h4>
                        </div>
                        <div id="heliotropeZoneSettings" class="panel-collapse collapse">
                            <div class="panel-body"> 
                                <form class="form-horizontal">
                                    <div class="col-sm-6">               
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Lien informations externes}}</label>
                                            <div class="col-sm-5">
                                                <select id="externalInfoObject" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="externalInfoObject">
                                                    <option value="none">{{Non affecté}}</option>
                                                    <?php
                                                        foreach (eqLogic::byType('shutters', true) as $shutters) {
                                                            if ($shutters->getConfiguration('objectType') == 'externalInfo' && $eqLogic->getIsEnable() == true) {
                                                                if ($shutters->getConfiguration('heliotrope') != null && $shutters->getConfiguration('heliotrope') != 'none') {
                                                                    echo '<option value="' . $shutters->getId() . '">' . $shutters->getName() . '</option>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="dawnType">{{Lever du soleil}}</label>
                                            <div class="col-sm-5">
                                                <select id="dawnType" type="text" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="dawnType">
                                                    <option value="astronomicalDawn">{{Aube astronomique}}</option>
                                                    <option value="nauticalDawn">{{Aube nautique}}</option>
                                                    <option value="civilDawn">{{Aube civile}}</option>
                                                    <option value="sunrise">{{Lever du soleil}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="duskType">{{Coucher du soleil}}</label>
                                            <div class="col-sm-5">
                                                <select id="duskType" type="text" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="duskType">
                                                    <option value="sunset">{{Coucher du soleil}}</option>
                                                    <option value="civilDusk">{{Crépuscule civil}}</option>
                                                    <option value="nauticalDusk">{{Crépuscule nautique}}</option>
                                                    <option value="astronomicalDusk">{{Crépuscule astronomique}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="wallAngle">{{Angle façade / Nord}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">    
                                                    <span class="input-group-addon">0°</span>
                                                    <input id="wallAngle" type="number" min="0" max="360" class="eqLogicAttr form-control text-center" data-l1key="configuration" data-l2key="wallAngle"/>
                                                    <span class="input-group-addon">360°</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <select id="wallAngleUnit" type="text" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="wallAngleUnit">
                                                <option value="deg">{{degré}}</option>
                                                <option value="gon">{{grade}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel panel-default col-sm-9 col-sm-offset-1">
                                            <div class="panel-body">
                                                <b>{{Procédure de réglage de l'angle}}</b>
                                                <li>{{Soit utiliser une boussole (appli smartphone par exemple) placée parallèlement au mur.}}</li>
                                                <li>{{Soit aller sur le site du }}<a href="https://www.cadastre.gouv.fr/scpc/accueil.do" target="_blank">{{cadastre}}</a> :</li>
                                                <ol>
                                                    <li>{{Saisir votre adresse.}}</li>
                                                    <li>{{Sélectionner la feuille correspondante à votre parcelle.}}</li>
                                                    <li>{{Une fois le plan affiché, dans l'onglet outils avancés, sélectionner mesurer.}}</li>
                                                    <li>{{Sélectionner l'outil 'mesurer un gisement'.}}</li>
                                                    <li>{{Tracer sur le plan une droite parallèle à votre façade (sens horaire par rapport au centre de l'habitation).}}</li>
                                                    <li>{{Relever la valeur de l'angle mesuré (en grades) et le renseigner dans le champ du plugin.}}</li>
                                                    <li>{{Vérifier que l'orientation du graphique dans le plugin est conforme à la réalité.}}</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">               
                                        <div class="form-group">
                                            <canvas id="heliotropePlan" width="400" height="400" style="border:1px solid #CCCCCC;"></canvas> 
                                            <canvas id="wallPlan" width="400" height="400" style="border:1px solid #CCCCCC;"></canvas> 
                                        </div>
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default display-none" data-paneltype="setting" data-objecttype="shuttersGroup">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#shuttersGroupSettings"> {{Paramètres groupe de volets}} </a>
                            </h4>
                        </div>
                        <div id="shuttersGroupSettings" class="panel-collapse collapse">
                            <div class="panel-body"> 
                                <form class="form-horizontal">

                                </form>    
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default display-none" data-paneltype="setting" data-objecttype="shutter">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#shutterSettings"> {{Informations de position du volet - type d'ouverture}} </a>
                            </h4>
                        </div>
                        <div id="shutterSettings" class="panel-collapse collapse">
                            <div class="panel-body"> 
                                <form class="form-horizontal">
                                    <div class="col-sm-6">               
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Information de position}}</label>
                                            <div class="col-sm-5">
                                                <select id="positionSensorType" type="text" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="positionSensorType" data-settings-group="positionSensorType">
                                                    <option value="none">{{Aucune}}</option>
                                                    <option value="analogPosition">{{Analogique}}</option>
                                                    <option value="openedClosedSensor">{{Ouverture et fermeture}}</option>
                                                    <option value="openedSensor">{{Ouverture}}</option>
                                                    <option value="closedSensor">{{Fermeture}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <fieldset id="analogPositionSettings" class="display-none" data-settings-group="positionSensorType" data-setting-type="analogPosition">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Retour de position du volet}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="shutterAnalogPosition" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="shutterAnalogPosition" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor listCmd" data-type="info" data-input="shutterAnalogPosition">
                                                                    <i class="fa fa-list-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Position volet fermé}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">    
                                                        <span class="input-group-addon">0%</span>
                                                        <input id="analogClosedPosition" type="range" min="0" max="5" class="eqLogicAttr form-control" style="z-index: 0;" data-l1key="configuration" data-l2key="analogClosedPosition"/>
                                                        <span class="input-group-addon">5%</span>
                                                    </div>
                                                    <span class="col-sm-2 col-sm-offset-5 label label-info input-range-value">---%</span>
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Position volet ouvert}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">                                                        
                                                        <span class="input-group-addon">95%</span>
                                                        <input id="analogOpenedPosition" type="range" min="95" max="100" class="eqLogicAttr form-control" style="z-index: 0;" data-l1key="configuration" data-l2key="analogOpenedPosition"/>
                                                        <span class="input-group-addon">100%</span>
                                                    </div>                                                        
                                                    <span class="col-sm-2 col-sm-offset-5 label label-info input-range-value">---%</span>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset id="closedSensorSettings" class="display-none" data-settings-group="positionSensorType" data-setting-type="openedClosedSensor closedSensor">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Détection volet fermé}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="closedSensor" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="closedSensor" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor listCmd" data-type="info" data-input="closedSensor">
                                                                    <i class="fa fa-list-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Statut volet fermé}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="closedSensorStatus" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="closedSensorStatus" disabled/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor getCmdStatus" data-input="closedSensorStatus" data-input-link="closedSensor" data-message="le volet est fermé complètement?">
                                                                <span class="fa fa-check"></span>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset id="openedSensorSettings" class="display-none" data-settings-group="positionSensorType" data-setting-type="openedClosedSensor openedSensor">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Détection volet}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="openedSensor" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openedSensor" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor listCmd" data-type="info" data-input="openedSensor">
                                                                    <i class="fa fa-list-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Statut volet ouvert}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="openedSensorStatus" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openedSensorStatus" disabled/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor getCmdStatus" data-input="openedSensorStatus" data-input-link="openedSensor" data-message="le volet est ouvert complètement?">
                                                                <span class="fa fa-check"></span>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>   
                                    <div class="col-sm-6">               
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Type d'ouvrant}}</label>
                                            <div class="col-sm-5">
                                                <select id="openingType" type="text" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="openingType">
                                                    <option value="window">{{Fenêtre}}</option>
                                                    <option value="door">{{Porte}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Information ouvrant ouvert}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input id="openOpeningInfo" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openOpeningInfo" placeholder="{{Sélectionner une commande}}"/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor listCmd" data-type="info" data-input="openOpeningInfo">
                                                                <i class="fa fa-list-alt"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Statut ouvrant ouvert}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input id="openOpeningInfoStatus" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openOpeningInfoStatus" disabled/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default cursor getCmdStatus" data-input="openOpeningInfoStatus" data-input-link="openOpeningInfo" data-message="l\'ouvrant est ouvert?">
                                                            <span class="fa fa-check"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>    
                            </div>
                        </div>
                        <div id="shutterCmdSettings" class="panel-collapse collapse">
                            <div class="panel-body"> 
                                <form class="form-horizontal">
                                    <div class="col-sm-6">               
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Commandes du volet}}</label>
                                            <div class="col-sm-5">
                                                <select id="commandType" type="text" class="eqLogicAttr cursor form-control" data-l1key="configuration" data-l2key="commandType" data-settings-group="commandType">
                                                    <option value="analogCmd">{{Analogique}}</option>
                                                    <option value="OpenCloseStopCmd">{{Montée / Descente / Stop}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <fieldset id="analogCmdSettings" class="display-none" data-settings-group="commandType" data-setting-type="analogCmd">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Commande analogique}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="analogCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="analogCmd" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor listCmd" data-type="action" data-input="analogCmd">
                                                                <i class="fa fa-list-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Consigne fermeture}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">    
                                                        <span class="input-group-addon">0%</span>
                                                        <input id="fullClosureSetpoint" type="range" min="0" max="5" class="eqLogicAttr form-control" style="z-index: 0;" data-l1key="configuration" data-l2key="fullClosureSetpoint"/>
                                                        <span class="input-group-addon">5%</span>
                                                    </div>
                                                    <span class="col-sm-2 col-sm-offset-5 label label-info input-range-value">---%</span>
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Consigne ouverture}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">                                                        
                                                        <span class="input-group-addon">95%</span>
                                                        <input id="fullOpeningSetpoint" type="range" min="95" max="100" class="eqLogicAttr form-control" style="z-index: 0;" data-l1key="configuration" data-l2key="fullOpeningSetpoint"/>
                                                        <span class="input-group-addon">100%</span>
                                                    </div>                                                        
                                                    <span class="col-sm-2 col-sm-offset-5 label label-info input-range-value">---%</span>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset id="OpenCloseStopCmdSettings" class="display-none" data-settings-group="commandType" data-setting-type="OpenCloseStopCmd">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Commande fermeture}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="closingCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="closingCmd" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor listCmd" data-type="action" data-input="closingCmd">
                                                                <i class="fa fa-list-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <a class="btn btn-default cursor execCmd" data-input-link="closingCmd">
                                                    <i class="fa fa-rss"></i> Tester                                                       
                                                </a>                                                               
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Commande ouverture}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="openingCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openingCmd" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor listCmd" data-type="action" data-input="openingCmd">
                                                                <i class="fa fa-list-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <a class="btn btn-default cursor execCmd" data-input-link="openingCmd">
                                                    <i class="fa fa-rss"></i> Tester                                                       
                                                </a>                                                               
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Commande stop}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input id="stopCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="stopCmd" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default cursor listCmd" data-type="action" data-input="stopCmd">
                                                                <i class="fa fa-list-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <a class="btn btn-default cursor execCmd" data-input-link="stopCmd">
                                                    <i class="fa fa-rss"></i> Tester                                                       
                                                </a>                                                               
                                            </div>
                                        </fieldset>
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="commandTab">
            </div>
        </div>
    </div>
</div>

<?php
include_file('desktop', 'jcanvas.min', 'js', 'shutters');
include_file('desktop', 'shutters', 'js', 'shutters');
include_file('desktop', 'shutters-events', 'js', 'shutters');
include_file('desktop', 'shutters-jcanvas', 'js', 'shutters');
include_file('core', 'plugin.template', 'js');
?>