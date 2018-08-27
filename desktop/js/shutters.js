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

$(document).ready(function () {
    
    console.log('document ready');

    initEvents();

    $("#cmdTable").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

    updateInputRangeMinMax();
    drawHeliotropePlan();
    drawWallPlan();
    drawShutterClosingMvtTimeCurve();
});

function printEqLogic(_eqLogic) {

    $(document).ready(function () {
        console.log('printEqLogic');

        initDefaultValues(_eqLogic);

        disableElement($('#eqType'));
        displaySettingsPanel(_eqLogic.configuration.eqType);
        $('input[data-settinggroup]').trigger('change');
        $('input[type=range]').trigger('change');

        switch (_eqLogic.configuration.eqType) {
            case 'externalInfo':
                updatePriorityFunction();
                break;
            case 'heliotropeZone':
                refreshWallPlan();
                displaySelectedDawnOrDusk(_eqLogic.configuration.dawnType);
                displaySelectedDawnOrDusk(_eqLogic.configuration.duskType);
                break;
            case 'shuttersGroup':
                updateEqLink(_eqLogic, listEqByType());
                break;
            case 'shutter':
                updateEqLink(_eqLogic, listEqByType());
                $('[data-l1key=configuration][data-l2key=shuttersGroupLink]').trigger('change');                
                updateShutterMvtTimeCurve(_eqLogic.configuration.shutterMvtTimeCurve);
                updateValuesTable(_eqLogic.configuration.shutterMvtTimeValues);
                break;
            default:
        }
    });
}

function saveEqLogic(_eqLogic) {
    console.log('saveEqLogic');
    switch (_eqLogic.configuration.eqType) {
        case 'shutter':
            if (_eqLogic.configuration.shuttersGroupLink !== 'none' && _eqLogic.configuration.shuttersGroupLink !== null) {
                $eqLogic = getEqLogic(_eqLogic.configuration.shuttersGroupLink);
                _eqLogic.configuration.shutterExternalInfoLink = $eqLogic.configuration.shuttersGroupExternalInfoLink;
                _eqLogic.configuration.shutterHeliotropeZoneLink = $eqLogic.configuration.shuttersGroupHeliotropeZoneLink;
            }
            _eqLogic.configuration.shutterMvtTimeValues = new Object();
            _eqLogic.configuration.shutterMvtTimeCurve = new Array();
            _eqLogic.configuration.shutterMvtTimeValues = shutterMvtTimeValues;
            _eqLogic.configuration.shutterMvtTimeCurve = shutterMvtTimeCurve;
            break;
    }
   	return _eqLogic;
}

function addCmdToTable(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }

    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
    tr += '<td>';
    tr += '<span class="cmdAttr" data-l1key="id" ></span>';
    tr += '</td>';
    tr += '<td>';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" >';
    tr += '</td>';
    tr += '<td>';
    tr += '<span class="cmdAttr" data-l1key="configuration" data-l2key="description">';
    tr += '</td>';
    tr += '<td>';
    tr += '<span class="cmdAttr" data-l1key="type"></span>';
    tr += '</td>';
    tr += '<td>';
    tr += '<span class="cmdAttr" data-l1key="subType"></span>';
    tr += '</td>';
    tr += '<td>';
    if (is_numeric(_cmd.id)) {
        tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
    }
   if (init(_cmd.type) == 'info') {
        tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
    }
    tr += '</td>';
    tr += '<td>';
    tr += '<i class="fa fa-minus-circle cmdAction cursor" data-action="remove"></i>';
    tr += '</td>';
    tr += '</tr>';

    $('#cmdTable tbody').append(tr);
    $('#cmdTable tbody tr:last').setValues(_cmd, '.cmdAttr');
}

/**
 * Hide tooltip attach to cursor
 */
function hideTooltip () {
    $('.cursor-tooltip').css('visibility', 'hidden');
}

/**
 * Display tooltip attach to cursor
 * @param {string} _message message to display in tooltip
 */
function displayTooltip (_message = '') {
    $('.cursor-tooltip').html(_message).css('visibility', 'visible');
}

/**
 * Disable an element if it's value different from null or ''
 * @param {element} _element element to disable
 */
function disableElement (_element = null) {
    if (_element.val() !== null) {
        _element.attr('disabled', true);
        _element.closest('div.input-group').find('i.fa-unlock').removeClass('fa-unlock').addClass("fa-lock");
    } else {
        _element.attr('disabled', false);
        _element.closest('div.input-group').find('i.fa-lock').removeClass('fa-lock').addClass("fa-unlock");
    }
}  

/**
 * Display setting panels corresponding to object type
 * @param {string} _eqType 
 */
function displaySettingsPanel (_eqType = null) {
    if (_eqType !== null) {
        $('.panel-group[data-paneltype=setting]').css('display', 'block');
        $('.panel[data-paneltype=setting]').css('display', 'none');
        $('.panel[data-objecttype=' + _eqType + ']').css('display', 'block');
    }
}

/**
 * Display setting fieldset corresponding to object type
 * @param {string} _settingGroup 
 * @param {string} _settingType
 */
function displaySettings (_settingGroup = null, _settingType = null) {
    if (_settingGroup !== null && _settingType !== null) {
        $('fieldset[data-settinggroup=' + _settingGroup + ']').css('display', 'none');
        $('fieldset[data-settinggroup=' + _settingGroup + '][data-settingtype~=' + _settingType + ']').css('display', 'block');
    }
}

/**
 * Selection of priority management (fire detection / absence)
 */
function updatePriorityFunction () {
    var priorityFunction = $('#priorityFunction');
    if ($('[data-l1key=configuration][data-l2key=absenceInfoCmd]').val() !== '' && $('[data-l1key=configuration][data-l2key=fireDetectionCmd]').val() !== '') {
        priorityFunction.prop('disabled', false);
        if (priorityFunction.val() === null) {
            priorityFunction.val('fireFunction');
        }
    } else {
        priorityFunction.val(null).prop('disabled', true);
    }
}

/**
 * Update angle range according to angle unit
 */
function updateAngleRange () {
    var wallAngle = $('[data-l1key=configuration][data-l2key=wallAngle]');
    if ($('[data-l1key=configuration][data-l2key=wallAngleUnit]').val() == 'gon') {
        wallAngle.attr('max', 400);
        wallAngle.prev().html('0gon');
        wallAngle.next().html('400gon');
   } else {
        wallAngle.attr('max', 360);
        wallAngle.prev().html('0°');
        wallAngle.next().html('360°');
   }
}

/**
 * Update min and max value for input type range
 */
function updateInputRangeMinMax () {
    $('input[type=range]').each(function () {
        var element = $(this);
        element.prev('span.input-group-addon').html(element.attr('min') + '%');
        element.next('span.input-group-addon').html(element.attr('max') + '%');
    })
}

/**
 * Initialize default values
 * @param {object} _eqLogic Shutters equipment
 */
function initDefaultValues (_eqLogic) {
    var element = new Object();
    switch (_eqLogic.configuration.eqType) {
        case 'externalInfo':
            break;
        case 'heliotropeZone':
            if (_eqLogic.configuration.heliotrope === '') {
                element = $('[data-l1key=configuration][data-l2key=heliotrope]');
                element.val(element.children().first().attr('value'));
            }
            if (_eqLogic.configuration.dawnType === '') {
                element = $('[data-l1key=configuration][data-l2key=dawnType]');
                element.val(element.children().first().attr('value')).trigger('change');
            }
            if (_eqLogic.configuration.duskType === '') {
                element = $('[data-l1key=configuration][data-l2key=duskType]');
                element.val(element.children().first().attr('value')).trigger('change');
            }
            if (_eqLogic.configuration.wallAngle === '') {
                element = $('[data-l1key=configuration][data-l2key=wallAngle]');
                element.val(0).trigger('change');
            }
            if (_eqLogic.configuration.wallAngleUnit === '') {
                element = $('[data-l1key=configuration][data-l2key=wallAngleUnit]');
                element.val(element.children().first().attr('value')).trigger('change');
            }
            break;
        case 'shuttersGroup':
            break;
        case 'shutter':
            if (_eqLogic.configuration.openingType === '') {
                element = $('[data-l1key=configuration][data-l2key=openingType]');
                element.val(element.children().first().attr('value'));
            }
            if (_eqLogic.configuration.shutterPositionType === '') {
                element = $('[data-l1key=configuration][data-l2key=shutterPositionType]');
                element.val(element.children().first().attr('value')).trigger('change');
            }
            if (_eqLogic.configuration.positionSynchroType === '') {
                element = $('[data-l1key=configuration][data-l2key=positionSynchroType]');
                element.val(element.children().first().attr('value'));
            }
            if (_eqLogic.configuration.shutterCmdType === '') {
                element = $('[data-l1key=configuration][data-l2key=shutterCmdType]');
                element.val(element.children().first().attr('value')).trigger('change');
            }
            break;
    }
}

/**
 * Get status from a command of type 'info'
 */
function getCmdStatus(_cmd) {
    var status = '';
    $.ajax({
        type: 'POST',
        async: false,
        url: 'plugins/shutters/core/ajax/shutters.ajax.php',
        data: {
            action: 'getCmdStatus',
            cmd: _cmd
        },
        dataType: 'json',
        global: false,
        error: function (request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function (data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
            }
            if (data.result.length != 0) {
                console.log('cmdStatus: ' + data.result);
                status = data.result;
            }
        }
    });
    return status;
}

/**
 * List shutters equipment by type
 */
function listEqByType() {
    var listEqByType = new Object();
    $.ajax({
        type: 'POST',
        async: false,
        url: 'plugins/shutters/core/ajax/shutters.ajax.php',
        data: {
            action: 'listEqByType'
        },
        dataType: 'json',
        global: false,
        error: function (request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function (data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
            }
            if (data.result.length != 0) {
                listEqByType = data.result;
            }
        }
    });
    console.log(listEqByType);
    return listEqByType;
}

/**
 * Get eqLogic by Id
 * @param {string} _eqLogicId EqLogic Id
 */
function getEqLogic(_eqLogicId) {
    var eqLogic = new Object();
    $.ajax({
        type: 'POST',
        async: false,
        url: 'plugins/shutters/core/ajax/shutters.ajax.php',
        data: {
            action: 'getEqLogic',
            type: 'shutters',
            id: _eqLogicId
        },
        dataType: 'json',
        global: false,
        error: function (request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function (data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
            }
            if (data.result.length != 0) {
                eqLogic = data.result;
            }
        }
    });
    console.log(eqLogic);
    return eqLogic;
}

/**
 * Update select by equipment type in shutter settings
 * @param {object} _eqLogic Shutters equipment
 * @param {object} _listEqByType List of shutters equipment by type
 */
function updateEqLink(_eqLogic, _listEqByType) {
    var optionList =['<option value="none" selected>{{Non affectées}}</option>'];
    for (var i = 0; i < _listEqByType.externalInfo.length; i++) {
        optionList.push('<option value="', _listEqByType.externalInfo[i].id, '">', _listEqByType.externalInfo[i].name, '</option>');
    }
    $('[data-l1key=configuration][data-l2key=shutterExternalInfoLink]').html(optionList.join('')).val(_eqLogic.configuration.shutterExternalInfoLink);
    $('[data-l1key=configuration][data-l2key=shuttersGroupExternalInfoLink]').html(optionList.join('')).val(_eqLogic.configuration.shuttersGroupExternalInfoLink);
    
    optionList =['<option value="none" selected>{{Non affectée}}</option>'];
    for (var i = 0; i < _listEqByType.heliotropeZone.length; i++) {
        optionList.push('<option value="', _listEqByType.heliotropeZone[i].id, '">', _listEqByType.heliotropeZone[i].name, '</option>');
    }
    $('[data-l1key=configuration][data-l2key=shutterHeliotropeZoneLink]').html(optionList.join('')).val(_eqLogic.configuration.shutterHeliotropeZoneLink);
    $('[data-l1key=configuration][data-l2key=shuttersGroupHeliotropeZoneLink]').html(optionList.join('')).val(_eqLogic.configuration.shuttersGroupHeliotropeZoneLink);
    
    optionList =['<option value="none" selected>{{Non affecté}}</option>'];
    for (var i = 0; i < _listEqByType.shuttersGroup.length; i++) {
        optionList.push('<option value="', _listEqByType.shuttersGroup[i].id, '">', _listEqByType.shuttersGroup[i].name, '</option>');
    }
    $('[data-l1key=configuration][data-l2key=shuttersGroupLink]').html(optionList.join('')).val(_eqLogic.configuration.shuttersGroupLink);
}