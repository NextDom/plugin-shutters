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

include_file('desktop', 'jcanvas.min', 'js', 'shutters');
include_file('desktop', 'shutters', 'css', 'shutters');
include_file('desktop', 'shutters-events', 'js', 'shutters');
include_file('desktop', 'shutters-jcanvas', 'js', 'shutters');

$plugin = plugin::byId('shutters');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());

?>


<div id="tooltip" class="cursor-tooltip"></div>

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
                <a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab">
                    <i class="fa fa-tachometer"></i> {{Equipement}}</a>
            </li>
            <li role="presentation">
                <a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab">
                    <i class="fa fa-list-alt"></i> {{Commandes}}</a>
            </li>
            <li role="presentation">
                <a href="#avatartab" aria-controls="avatar" role="tab" data-toggle="tab">
                    <i class="fa fa-list-alt"></i> {{Avatar}}</a>
            </li>
        </ul>
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <div role="tabpanel" class="tab-pane active" id="eqlogictab">
                <br/>
                <div id="objectSettings" class="panel-group" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#generalSettings"> {{Général}} </a>
                            </h4>
                        </div>
                    </div>
                    <div id="generalSettings" class="panel-collapse collapse in">
                        <div class="panel-body"> 
                            <form class="form-horizontal">
                                <div class="col-sm-6">    
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="objectName">{{Nom de l'équipement}}</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display:none" />
                                            <input type="text" id="objectName" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}"/>
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#objectSettings" href="#externalInfoSettings"> {{{{Informations générales externes}}}} </a>
                            </h4>
                        </div>
                    </div>
                    <div id="externalInfoSettings" class="panel-collapse collapse">
                        <div class="panel-body"> 
                            <form class="form-horizontal">
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Information d'absence}}</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input id="absenceInformation" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="absenceInformation"/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default cursor listCmd" data-type="info" data-input="absenceInformation" title="{{Sélectionner une commande}}">
                                                        <i class="fa fa-list-alt"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Information de présence}}</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input id="presenceInformation" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="presenceInformation"/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default cursor listCmd" data-type="info" data-input="presenceInformation" title="{{Sélectionner une commande}}">
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
                                                <input id="fireDetection" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="fireDetection"/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default cursor listCmd" data-type="info" data-input="fireDetection" title="{{Sélectionner une commande}}">
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
                                        <label class="col-sm-3 control-label">{{Luninosité extérieure}}</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input id="outdoorLuninosity" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outdoorLuninosity"/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default cursor listCmd" data-type="info" data-input="outdoorLuninosity" title="{{Sélectionner une commande}}">
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
                                                <input id="outdoorTemperature" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outdoorTemperature"/>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default cursor listCmd" data-type="info" data-input="outdoorTemperature" title="{{Sélectionner une commande}}">
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
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="commandtab">
                <table id="table_cmd" class="table table-bordered table-condensed">
                    <a class="btn btn-success btn-sm cmdAction pull-right bt_addlocate" data-action="add" style="margin-top:5px;">
                        <i class="fa fa-plus-circle"></i> {{commande}}</a>
                    <br/>
                    <br/>
                    <thead>
                        <tr>
                            <th>{{Nom}}</th>
                            <th>{{Type}}</th>
                            <th>{{Recherche adresse}}</th>
                            <th>{{Type de loc}}</th>
                            <th>{{Coordonnées GPS}}</th>
                            <th>{{Parametres}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="avatartab">
                <div id="collapseTwo" class="panel-collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body" id="bsImagesPanel">
                        <div class="col-sm-12" id="bsImagesView" style="min-height: 50px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_file('desktop', 'shutters', 'js', 'shutters');?>
<?php include_file('core', 'plugin.template', 'js');?>