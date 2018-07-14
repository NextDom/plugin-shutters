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
$plugin = plugin::byId('shutters');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());

?>


<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add">
                    <i class="fa fa-plus-circle"></i> {{Ajouter un volet}}</a>
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
        <legend>
            <i class="fa fa-table"></i> {{Mes volets}}</legend>
        <div class="eqLogicThumbnailContainer">
            <?php
            foreach ($eqLogics as $eqLogic) {
                if ($eqLogic->getConfiguration('objectType') == 'shutter') {
                    $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                    echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
                    echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
                    echo "<br>";
                    echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <legend>
            <i class="fa fa-table"></i> {{Mes façades}}</legend>
        <div class="eqLogicThumbnailContainer">
            <?php
            foreach ($eqLogics as $eqLogic) {
                if ($eqLogic->getConfiguration('objectType') == 'shuttersArea') {
                    $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                    echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
                    echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
                    echo "<br>";
                    echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                    echo '</div>';
                }
            }
            ?>
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
                <form class="form-horizontal">
                    <fieldset>
                        <legend>{{Général}}</legend>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Nom de l'équipement}}</label>
                            <div class="col-sm-3">
                                <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display:none" />
                                <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Objet parent}}</label>
                            <div class="col-sm-3">
                                <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
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
                            <div class="col-sm-3">
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
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                            </div>
                        </div>
                        <div class="form-group">
							<label class="col-sm-3 control-label">{{Type d'objet}}</label>
                            <div class="col-sm-3">
                                <select id="objectType" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="objectType">
                                    <option value="shutter" selected>{{Volet}}</option>
                                    <option value="shuttersArea">{{Façade}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Commentaire}}</label>
                            <div class="col-sm-3">
                                <textarea class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="commentaire"></textarea>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id="heliotropeSettings" style="display:none">
                        <legend>{{Paramètres héliotrope}}</legend>
                        <div class="col-sm-6">               
                            <div class="form-group">
                                <label class="col-sm-6 control-label">{{Héliotrope}}
                                    <sup>
                                        <i class="fa fa-question-circle tooltips" title="{{Objet héliotrope permettant la gestion du volet en fonction de la position du soleil.}}"></i>
                                    </sup>
                                </label>
                                <div class="col-sm-6">
                                    <select id="heliotrope" class="form-control eqLogicAttr configuration" data-l1key="configuration" data-l2key="heliotrope">
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
                                <label class="col-sm-6 control-label">{{Lever du soleil}}</label>
                                <div class="col-sm-6">
                                    <select id="dawnType" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="dawnType">
                                        <option value="astronomicalDawn">{{Aube astronomique}}</option>
                                        <option value="nauticalDawn">{{Aube nautique}}</option>
                                        <option value="civilDawn">{{Aube civile}}</option>
                                        <option value="sunrise">{{Lever du soleil}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">{{Coucher du soleil}}</label>
                                <div class="col-sm-6">
                                    <select id="duskType" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="duskType">
                                        <option value="sunset">{{Coucher du soleil}}</option>
                                        <option value="civilDusk">{{Crépuscule civil}}</option>
                                        <option value="nauticalDusk">{{Crépuscule nautique}}</option>
                                        <option value="astronomicalDusk">{{Crépuscule astronomique}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">{{Angle façade / Nord [0° : 360°]}}</label>
                                <div class="col-sm-6">
                                    <input id="wallAngle" type="number" min="0" max="360" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="wallAngle"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">               
                            <div class="form-group">
                                <canvas id="myCanvas" width="400" height="400" style="border:1px solid #000000;"></canvas> 
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id="shutterSettings" style="display:none">
                        <legend>{{Paramètres volet}}</legend>
                        <div class="col-sm-6">               
                            <div class="form-group">
                                <label class="col-sm-6 control-label">{{Position fermeture [0% : 100%]}}</label>
                                <div class="col-sm-6">
                                    <input id="closedPosition" type="number" min="0" max="100" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="closedPosition"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">{{Position ouverture [0% : 100%]}}</label>
                                <div class="col-sm-6">
                                    <input id="openedPosition" type="number" min="0" max="100" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openedPosition"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">{{Retour de position du volet}}
                                    <sup>
                                        <i class="fa fa-question-circle tooltips" title="Commande de type info renvoyant la position actuelle du volet."></i>
                                    </sup>
                                </label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input class="expressionAttr form-control input-sm cmdAction" data-l1key="cmd" data-type="info"/>
                                        <span class="input-group-btn">
                                            <a class="btn btn-success btn-sm listCmdAction" data-type="info">
                                                    <i class="fa fa-list-alt"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <div class="col-sm-6">               
                            <div class="form-group">
                                <label class="col-sm-6 control-label">{{Type d'ouvrant}}</label>
                                <div class="col-sm-6">
                                    <select id="openingType" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openingType">
                                        <option value="window" selected>{{Fenêtre}}</option>
                                        <option value="door">{{Porte}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id="shutterHeliotropeSettings" style="display:none">
                        <legend>{{Paramètres héliotrope du volet}}</legend>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Façade}}</label>
                            <div class="col-sm-3">
                                <select id="shutterArea" class="form-control eqLogicAttr configuration" data-l1key="configuration" data-l2key="shutterArea">
                                    <?php
                                    foreach (eqLogic::byType('shutters', true) as $shutters) {
                                        if ($shutters->getConfiguration('objectType') == 'shuttersArea') {
                                            echo '<option value="' . $shutters->getId() . '">' . $shutters->getName() . '</option>';
                                        } 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">{{Angles d'entrée et de sortie du soleil de l'ouvrant}}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Angle d'entrée [-90° : -30°]}}</label>
                            <div class="col-sm-3">
                                <input id="incomingAzimuthAngle" type="number" min="-90" max="-30" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="incomingAzimuthAngle"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Angle de sortie  [+30° : +90°]}}</label>
                            <div class="col-sm-3">
                                <input id="outgoingAzimuthAngle" type="number" min="30" max="90" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="outgoingAzimuthAngle"/>
                            </div>
                        </div>

                    </fieldset>
                </form>
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

<?php include_file('desktop', 'jcanvas.min', 'js', 'shutters');?>
<?php include_file('desktop', 'shutters', 'js', 'shutters');?>
<?php include_file('core', 'plugin.template', 'js');?>