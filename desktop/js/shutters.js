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

$(document).ready (function () {
    
    console.log('document ready');

    initEvents();

    $("#cmdTable").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

    updateInputRangeMinMax();
    drawHeliotropePlan();
    drawWallPlan();
    drawShutterClosingMvtTimeCurve();
});

function printEqLogic (_eqLogic) {

    $(document).ready(function () {
        console.log('printEqLogic');

        initDefaultValues();

        disableElement($('#objectType'));
        displaySettingPanel($('#objectType').val());
        $('input[data-settinggroup]').trigger('change');
        $('input[type=range]').trigger('change');

        switch (_eqLogic.configuration.objectType) {
            case 'externalInfo':
                updatePriorityManagement();
                break;
            case 'heliotropeZone':
                refreshWallPlan();
                displaySelectedDawnOrDusk($('#dawnType').val());
                displaySelectedDawnOrDusk($('#duskType').val());
                break;
            case 'shutter':
                updateShutterMvtTimeCurve(_eqLogic.configuration.shutterMvtTimeCurve);
                break;
            default:
        }
    });
}

function saveEqLogic(_eqLogic) {
    console.log('saveEqLogic');
    _eqLogic.configuration.shutterMvtTimeValues = new Object();
    _eqLogic.configuration.shutterMvtTimeCurve = new Array();
	_eqLogic.configuration.shutterMvtTimeValues = shutterMvtTimeValues;
	_eqLogic.configuration.shutterMvtTimeCurve = shutterMvtTimeCurve;
   	return _eqLogic;
}

function addCmdToTable (_cmd) {
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
        tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a></td>';
    }
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
 * @param {string} message message to display in tooltip
 */
function displayTooltip (message = '') {
    $('.cursor-tooltip').html(message).css('visibility', 'visible');
}

/**
 * Disable an element if it's value different from null or ''
 * @param {element} element element to disable
 */
function disableElement (element) {
    if (element.val() !== null && element.val() !== '') {
        $(element).attr('disabled', true);
        element.closest('div.input-group').find('i.fa-unlock').removeClass('fa-unlock').addClass("fa-lock");
    } else {
        $(element).attr('disabled', false);
        element.closest('div.input-group').find('i.fa-lock').removeClass('fa-lock').addClass("fa-unlock");
    }
}  

/**
 * Display setting panels corresponding to object type
 * @param {string} objectType 
 */
function displaySettingPanel (objectType = '') {
    $('.panel-group[data-paneltype=setting]').css('display', 'block');
    $('.panel[data-paneltype=setting]').css('display', 'none');
	$('.panel[data-objecttype=' + objectType + ']').css('display', 'block');
}

/**
 * Display setting fieldset corresponding to object type
 * @param {string} settingGroup 
 * @param {string} settingType
 */
function displaySettings (settingGroup = '', settingType = '') {
    console.log(settingGroup);
    console.log(settingType);
    if (settingGroup !== null && settingType !== null) {
        $('fieldset[data-settinggroup=' + settingGroup + ']').css('display', 'none');
        $('fieldset[data-settinggroup=' + settingGroup + '][data-settingtype~=' + settingType + ']').css('display', 'block');
    }
}

/**
 * Selection of priority management (fire detection / absence)
 */
function updatePriorityManagement () {
    console.log('priority management');
    var priorityManagement = $('#priorityManagement');
    if ($('#absenceInfoCmd').val() !== '' && $('#fireDetectionCmd').val() !== '') {
        priorityManagement.prop('disabled', false);
        if (priorityManagement.val() === null) {
            priorityManagement.val('fireManagement');
        }
    } else {
        priorityManagement.val(null);
        priorityManagement.prop('disabled', true);
    }
}

/**
 * Update angle range according to angle unit
 */
function updateAngleRange () {
    var wallAngle = $('#wallAngle');
    if ($('#wallAngleUnit').val() == 'gon') {
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
 */
function initDefaultValues () {
    //Initialize default values for object heliotrope zone  
    if ($('#heliotrope').val() === null) {
        $('#heliotrope').val('none');
    }
    if ($('#dawnType').val() === null) {
        $('#dawnType').val('sunrise').trigger('change');
    }
    if ($('#duskType').val() === null) {
        $('#duskType').val('sunset').trigger('change');
    }
    if ($('#wallAngle').val() === '') {
    $('#wallAngle').val(0).trigger('change');
    }
    if ($('#wallAngleUnit').val() === null) {
        $('#wallAngleUnit').val('deg').trigger('change');
    }

    //Initialize default values for object shutter     
    if ($('#openingType').val() === null) {
        $('#openingType').val('window');
    }
    if ($('#shutterPositionType').val() === null) {
        $('#shutterPositionType').val('none').trigger('change');
    }
    if ($('#shutterCmdType').val() === null) {
        $('#shutterCmdType').val('analogPositionCmd').trigger('change');
    }
}

/**
 * Get status from a command of type 'info'
 */
function getCmdStatus (cmd) {
    var status = '';
    console.log('cmdId: ' + cmd);
    $.ajax({
        type: 'POST',
        async: false,
        url: 'plugins/shutters/core/ajax/shutters.ajax.php',
        data: {
            action: 'getCmdStatus',
            cmd: cmd
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
