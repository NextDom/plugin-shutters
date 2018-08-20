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
                    echo '<li class="li_eqLogic cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity .'"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
        <legend>
            <i class="fa fa-cog"></i> {{Gestion}}</legend>
        <div class="eqLogicThumbnailContainer">
            <div class="eqLogicAction cursor" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
                <i class="fa fa-plus-circle" style="font-size : 6em;color:#33b8cc;"></i>
                <br>
                <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#33b8cc">{{Ajouter}}</span>
            </div>
            <div class="eqLogicAction cursor" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
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
                    <i class="fa fa-list-alt"></i> {{Commandes}}</a>
            </li>
        </ul>
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <div role="tabpanel" class="tab-pane active" id="eqLogicTab">
                <br/>
                <div class="panel-group" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{Définition de l'équipement}}</h4>
                        </div>
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
                                            <select id="sel_object" class="eqLogicAttr form-control cursor" data-l1key="object_id">
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
                                            <div class="input-group">
                                                <select id="objectType" type="text" class="eqLogicAttr form-control cursor" data-l1key="configuration" data-l2key="objectType">
                                                    <option value="externalInfo">{{Informations externes générales}}</option>
                                                    <option value="heliotropeZone">{{Zone héliotrope}}</option>
                                                    <option value="shuttersGroup">{{Groupe de volets}}</option>
                                                    <option value="shutter">{{Volet}}</option>
                                                </select>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default btn-lock cursor" data-input="objectType">
                                                        <i class="fa fa-unlock"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
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
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{Aide}}</h4>
                        </div>
                        <div class="panel-body"> 
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{Type d'équipement}}</th>
                                        <th>{{Description}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{Informations générales externes}}</td>
                                        <td>{{Equipement permettant la gestion d'informations externes au plugin (information d'absence, détection incendie, température, luminosité, héliotrope). Ces informations sont optionnelles, si elles ne sont pas renseignées.}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{Zone azimut}}</td>
                                        <td>{{Equipement permettant la gestion azimut des volets.}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{Groupe de volets}}</td>
                                        <td>{{Equipement permettant de commander de façon grouper des volets, ainsi que d'avoir une signalisation groupée.}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{Volet}}</td>
                                        <td>Dooley</td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="settingsTab">
                <br/>
                <div id="objectSettings" class="panel-group display-none" data-paneltype="setting">
                    <div class="panel panel-default display-none" data-paneltype="setting" data-objecttype="externalInfo">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{Informations générales externes}}</h4>
                        </div>
                        <div class="panel-body"> 
                            <form class="form-horizontal">
                                <div class="col-sm-6"> 
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <h4 class="text-center">Commande</h4>  
                                    </div>
                                    <div class="col-sm-3">
                                        <h4 class="text-center">Statut</h4>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="absenceInfo">{{Information d'absence}}</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default delCmd cursor" data-input="absenceInfoCmd">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </a>
                                                </span>
                                                <input id="absenceInfoCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="absenceInfoCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default listCmd cursor" data-type="info" data-input="absenceInfoCmd">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div id="absenceInfoCmdStatus" class="input-group">
                                                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="absenceInfoCmdStatus" placeholder="{{Valider le statut}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default getCmdStatus cursor" data-input="absenceInfoCmdStatus" data-cmdinput="absenceInfoCmd" data-message="{{l'information d'absence est active?}}">
                                                        <span class="fa fa-check-circle"></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Information de présence}}</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                            <span class="input-group-btn">
                                                    <a class="btn btn-default delCmd cursor" data-input="presenceInfoCmd">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </a>
                                                </span>
                                                 <input id="presenceInfoCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="presenceInfoCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default listCmd cursor" data-type="info" data-input="presenceInfoCmd">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div id="presenceInfoCmdStatus" class="input-group">
                                                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="presenceInfoCmdStatus" placeholder="{{Valider le statut}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default getCmdStatus cursor" data-input="presenceInfoCmdStatus" data-cmdinput="presenceInfoCmd" data-message="{{l'information de présence est active?}}">
                                                        <span class="fa fa-check-circle"></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Détection incendie}}</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default delCmd cursor" data-input="fireDetectionCmd">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </a>
                                                </span>
                                                 <input id="fireDetectionCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="fireDetectionCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default listCmd" data-type="info" data-input="fireDetectionCmd">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div id="fireDetectionStatus" class="input-group">
                                                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="fireDetectionCmdStatus" placeholder="{{Valider le statut}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default getCmdStatus cursor" data-input="fireDetectionCmdStatus" data-cmdinput="fireDetectionCmd" data-message="{{la détection incendie est active?}}">
                                                        <span class="fa fa-check-circle"></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Luminosité extérieure}}</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default delCmd cursor" data-input="outdoorLuminosityCmd">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </a>
                                                </span>
                                                 <input id="outdoorLuminosityCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outdoorLuminosityCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default listCmd cursor" data-type="info" data-input="outdoorLuminosityCmd">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div id="outdoorLuminosityCmdStatus" class="input-group">
                                                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outdoorLuminosityCmdStatus" placeholder="{{Valider le statut}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default getCmdStatus cursor" data-input="outdoorLuminosityCmdStatus" data-cmdinput="outdoorLuminosityCmd" data-message="">
                                                        <span class="fa fa-check-circle"></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Température extérieure}}</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default delCmd cursor" data-input="outdoorTemperatureCmd">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </a>
                                                </span>
                                                 <input id="outdoorTemperatureCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outdoorTemperatureCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default listCmd cursor" data-type="info" data-input="outdoorTemperatureCmd">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div id="outdoorTemperatureCmdStatus" class="input-group">
                                                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outdoorTemperatureCmdStatus" placeholder="{{Valider le statut}}" disabled/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default getCmdStatus cursor" data-input="outdoorTemperatureCmdStatus" data-cmdinput="outdoorTemperatureCmd" data-message="">
                                                        <span class="fa fa-check-circle"></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Gestion prioritaire}}</label>
                                        <div class="col-sm-5">
                                            <select id="priorityManagement" type="text" class="eqLogicAttr form-control cursor" data-l1key="configuration" data-l2key="priorityManagement">
                                                <option value="fireManagement">{{Gestion incendie}}</option>
                                                <option value="absenceManagement">{{Gestion absence}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                </div>
                            </form>    
                        </div>
                    </div>
                    <div class="panel panel-default display-none" data-paneltype="setting" data-objecttype="heliotropeZone">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{Paramètres héliotrope}}</h4>
                        </div>
                        <div class="panel-body"> 
                            <form class="form-horizontal">
                                <div class="col-sm-6">               
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="heliotrope">{{Héliotrope}}</label>
                                        <div class="col-sm-5">
                                            <select id="heliotrope" class="eqLogicAttr form-control cursor" data-l1key="configuration" data-l2key="heliotrope">
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
                                        <label class="col-sm-3 control-label" for="dawnType">{{Lever du soleil}}</label>
                                        <div class="col-sm-5">
                                            <select id="dawnType" type="text" class="eqLogicAttr form-control cursor" data-l1key="configuration" data-l2key="dawnType">
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
                                            <select id="duskType" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="duskType">
                                                <option value="sunset">{{Coucher du soleil}}</option>
                                                <option value="civilDusk">{{Crépuscule civil}}</option>
                                                <option value="nauticalDusk">{{Crépuscule nautique}}</option>
                                                <option value="astronomicalDusk">{{Crépuscule astronomique}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <canvas id="heliotropePlan" class="col-sm-offset-3" width="400" height="400" style="border:1px solid #CCCCCC;"></canvas> 
                                     </div>
                                </div>
                                <div class="col-sm-6">               
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
                                            <select id="wallAngleUnit" type="text" class="eqLogicAttr form-control cursor" data-l1key="configuration" data-l2key="wallAngleUnit">
                                            <option value="deg">{{degré}}</option>
                                            <option value="gon">{{grade}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <canvas id="wallPlan" class="col-sm-offset-3" width="400" height="400" style="border:1px solid #CCCCCC;"></canvas> 
                                    </div>
                                </div>
                            </form>    
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
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#shutterSettings"> {{Informations de position du volet - type d'ouvrant}} </a>
                            </h4>
                        </div>
                        <div id="shutterSettings" class="panel-collapse collapse in">
                            <div class="panel-body"> 
                                <form class="form-horizontal">
                                    <div class="col-sm-6">               
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Information(s) de position}}</label>
                                            <div class="col-sm-5">
                                                <select id="shutterPositionType" type="text" class="eqLogicAttr form-control cursor" data-l1key="configuration" data-l2key="shutterPositionType" data-settinggroup="shutterPositionType">
                                                    <option value="none">{{Aucune}}</option>
                                                    <option value="analogPosition">{{Analogique}}</option>
                                                    <option value="closedOpenedPositions">{{Fermeture et ouverture}}</option>
                                                    <option value="closedPosition">{{Fermeture}}</option>
                                                    <option value="openedPosition">{{Ouverture}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <fieldset id="analogPositionSettings" class="display-none" data-settinggroup="shutterPositionType" data-settingtype="analogPosition">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Position du volet}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default delCmd cursor" data-input="shutterAnalogPositionCmd">
                                                                <i class="fa fa-minus-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input id="shutterAnalogPositionCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="shutterAnalogPositionCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default listCmd cursor" data-type="info" data-subtype="numeric" data-input="shutterAnalogPositionCmd">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Position volet fermé}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">    
                                                        <span class="input-group-addon eqLogicAttr" data-l1key="configuration" data-l2key="analogClosedPositionMin">---%</span>
                                                        <input id="analogClosedPosition" type="range" min="0" max="5" class="eqLogicAttr form-control" style="z-index: 0;" data-l1key="configuration" data-l2key="analogClosedPosition"/>
                                                        <span class="input-group-addon eqLogicAttr" data-l1key="configuration" data-l2key="analogClosedPositionMax">---%</span>
                                                    </div>
                                                    <span class="col-sm-2 col-sm-offset-5 label label-info input-range-value">---%</span>
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Position volet ouvert}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">                                                        
                                                        <span class="input-group-addon eqLogicAttr" data-l1key="configuration" data-l2key="analogOpenedPositionMin">---%</span>
                                                        <input id="analogOpenedPosition" type="range" min="95" max="100" class="eqLogicAttr form-control" style="z-index: 0;" data-l1key="configuration" data-l2key="analogOpenedPosition"/>
                                                        <span class="input-group-addon eqLogicAttr" data-l1key="configuration" data-l2key="analogOpenedPositionMax">---%</span>
                                                    </div>                                                        
                                                    <span class="col-sm-2 col-sm-offset-5 label label-info input-range-value">---%</span>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset id="closedPositionSettings" class="display-none" data-settinggroup="shutterPositionType" data-settingtype="closedOpenedPositions closedPosition">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Position volet fermé}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default delCmd cursor" data-input="closedPositionCmd">
                                                                <i class="fa fa-minus-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input id="closedPositionCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="closedPositionCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default listCmd cursor" data-type="info" data-input="closedPositionCmd">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div id="closedPositionCmdStatus" class="input-group">
                                                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="closedPositionCmdStatus" placeholder="{{Valider le statut}}" disabled/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default getCmdStatus cursor" data-input="closedPositionCmdStatus" data-cmdinput="closedPositionCmd" data-message="{{le volet est en position fermé?}}">
                                                                <span class="fa fa-check-circle"></span>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset id="openedPositionSettings" class="display-none" data-settinggroup="shutterPositionType" data-settingtype="closedOpenedPositions openedPosition">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Position volet ouvert}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default delCmd cursor" data-input="openedPositionCmd">
                                                                <i class="fa fa-minus-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input id="openedPositionCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openedPositionCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default listCmd cursor" data-type="info" data-input="openedPositionCmd">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div id="openedPositionCmdStatus" class="input-group">
                                                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openedPositionCmdStatus" placeholder="{{Valider le statut}}" disabled/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default getCmdStatus cursor" data-input="openedPositionCmdStatus" data-cmdinput="openedPositionCmd" data-message="{{le volet est en position ouvert?}}">
                                                                <span class="fa fa-check-circle"></span>
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
                                                <select id="openingType" type="text" class="eqLogicAttr form-control cursor" data-l1key="configuration" data-l2key="openingType">
                                                    <option value="window">{{Fenêtre}}</option>
                                                    <option value="door">{{Porte}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Information ouvrant ouvert}}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default delCmd cursor" data-input="openOpeningInfoCmd">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </a>
                                                    </span>
                                                    <input id="openOpeningInfoCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openOpeningInfoCmd" placeholder="{{Sélectionner une commande}}" disabled/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default listCmd cursor" data-type="info" data-input="openOpeningInfoCmd">
                                                            <i class="fa fa-list"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div id="openOpeningInfoCmdStatus" class="input-group">
                                                    <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openOpeningInfoCmdStatus" placeholder="{{Valider le statut}}" disabled/>
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-default getCmdStatus cursor" data-input="openOpeningInfoCmdStatus" data-cmdinput="openOpeningInfoCmd" data-message="{{l'ouvrant est ouvert ?}}">
                                                            <span class="fa fa-check-circle"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default display-none" data-paneltype="setting" data-objecttype="shutter">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#shutterCmdSettings"> {{Commandes du volet}} </a>
                            </h4>
                        </div>
                        <div id="shutterCmdSettings" class="panel-collapse collapse">
                            <div class="panel-body"> 
                                <form class="form-horizontal">
                                    <div class="col-sm-6">               
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{Commandes du volet}}</label>
                                            <div class="col-sm-5">
                                                <select id="shutterCmdType" type="text" class="eqLogicAttr form-control cursor" data-l1key="configuration" data-l2key="shutterCmdType" data-settinggroup="shutterCmdType">
                                                    <option value="analogPositionCmd">{{Analogique}}</option>
                                                    <option value="OpenCloseStopCmd">{{Montée / Descente / Stop}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <fieldset id="analogPositionCmdSettings" class="display-none" data-settinggroup="shutterCmdType" data-settingtype="analogPositionCmd">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Commande analogique}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default delCmd cursor" data-input="analogPositionCmd">
                                                                <i class="fa fa-minus-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input id="analogPositionCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="analogPositionCmd" placeholder="{{Sélectionner une commande}}" />
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default listCmd cursor" data-type="action" data-subtype="slider" data-input="analogPositionCmd">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Consigne fermeture complète}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">    
                                                    <span class="input-group-addon eqLogicAttr" data-l1key="configuration" data-l2key="fullClosureSetpointMin">---%</span>
                                                        <input id="fullClosureSetpoint" type="range" min="0" max="5" class="eqLogicAttr form-control" style="z-index: 0;" data-l1key="configuration" data-l2key="fullClosureSetpoint"/>
                                                        <span class="input-group-addon eqLogicAttr" data-l1key="configuration" data-l2key="afullClosureSetpointMax">---%</span>
                                                    </div>
                                                    <span class="col-sm-2 col-sm-offset-5 label label-info input-range-value">---%</span>
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Consigne ouverture complète}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">                                                        
                                                    <span class="input-group-addon eqLogicAttr" data-l1key="configuration" data-l2key="fullOpeningSetpointMin">---%</span>
                                                        <input id="fullOpeningSetpoint" type="range" min="95" max="100" class="eqLogicAttr form-control" style="z-index: 0;" data-l1key="configuration" data-l2key="fullOpeningSetpoint"/>
                                                        <span class="input-group-addon eqLogicAttr" data-l1key="configuration" data-l2key="fullOpeningSetpointMax">---%</span>
                                                    </div>                                                        
                                                    <span class="col-sm-2 col-sm-offset-5 label label-info input-range-value">---%</span>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset id="OpenCloseStopCmdSettings" class="display-none" data-settinggroup="shutterCmdType" data-settingtype="OpenCloseStopCmd">  
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Commande fermeture}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default delCmd cursor" data-input="closingCmd">
                                                                <i class="fa fa-minus-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input id="closingCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="closingCmd" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default listCmd cursor" data-type="action" data-subtype="other" data-input="closingCmd">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <a class="btn btn-default execCmd cursor" data-input-link="closingCmd">
                                                    <i class="fa fa-rss"></i> Tester                                                       
                                                </a>                                                               
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Commande ouverture}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default delCmd cursor" data-input="openingCmd">
                                                                <i class="fa fa-minus-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input id="openingCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openingCmd" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default listCmd cursor" data-type="action" data-subtype="other" data-input="openingCmd">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <a class="btn btn-default execCmd cursor" data-input-link="openingCmd">
                                                    <i class="fa fa-rss"></i> Tester                                                       
                                                </a>                                                               
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{Commande stop}}</label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default delCmd cursor" data-input="stopCmd">
                                                                <i class="fa fa-minus-circle"></i>
                                                            </a>
                                                        </span>
                                                        <input id="stopCmd" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="stopCmd" placeholder="{{Sélectionner une commande}}"/>
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-default listCmd cursor" data-type="action" data-subtype="other" data-input="stopCmd">
                                                                <i class="fa fa-list"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <a class="btn btn-default execCmd cursor" data-input-link="stopCmd">
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
                <br/>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{Commandes liées à l'équipement informations externes}}</h4>
                        </div>
                        <div class="panel-body"> 
                            <table id="cmdTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">{{Id}}</th>
                                        <th style="width: 200px;">{{Nom}}</th>
                                        <th style="width: 250px;">{{Description}}</th>
                                        <th style="width: 50px;">{{Type}}</th>
                                        <th style="width: 50px;">{{Sous type}}</th>
                                        <th style="width: 50px;">{{Configuration}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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