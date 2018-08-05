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

$(document).ready(function() {
    
    console.log('document ready');

    initEvents();

    displaySettings($('#positionSensorType').val());
    drawHeliotropePlan();
    drawWallPlan();




});

function printEqLogic(_eqLogic) {

    $(document).ready(function() {
        //$(".collapse[data-paneltype='generalSettings']").collapse('show');
        console.log('printEqLogic');

        initDefaultValues();
        $('input[type=range]').trigger('change');
        listHeliotropeObject();
        lockControl($('#lockObjectTypeSelection'), true);
        displaySettingPanel($('#objectType').val());

        updatePriorityManagement();
        refreshWallPlan();
        displaySelectedDawnOrDusk($('#dawnType').val());
        displaySelectedDawnOrDusk($('#duskType').val());
        
    });
}

/**
 * Hide tooltip attach to cursor
 */
function hideTooltip() {
    $('.cursor-tooltip').css('visibility', 'hidden');
}

/**
 * Display tooltip attach to cursor
 * @param {string} message message to display in tooltip
 */
function displayTooltip(message = '') {
    $('.cursor-tooltip').html(message).css('visibility', 'visible');
}

/**
 * Lock or unlock an object with a toggle button
 * @param {object} lockCmdBtn command button for lock / unlock
 * @param {boolean} init lock object if object as a value
*/
function lockControl(lockCmdBtn, init = false) {
    var controlToLock = $(lockCmdBtn).parent().find('.control-lockable');
    var objectType = controlToLock.val();
    var lockCommand = $(lockCmdBtn).children(":first");
    if (objectType === null) {
        controlToLock.prop('disabled', false);
        lockCommand.removeClass('fa-lock').addClass("fa-unlock");
        return;
    }
    if (init == true &&  objectType !== null) {
        controlToLock.prop('disabled', true);
        lockCommand.removeClass('fa-unlock').addClass("fa-lock");
        return;
    }
    if (controlToLock.is(':disabled')) {
        bootbox.confirm('{{Etes-vous sûr de vouloir changer le type d\'objet? Cela peut entraîner des dysfonctionnements du système!}}', function (result) {
            if (result) {
                controlToLock.prop('disabled', false);
                lockCommand.removeClass('fa-lock').addClass("fa-unlock");
                return;
            }
        }) 
    } else {
        controlToLock.prop('disabled', true);
        lockCommand.removeClass('fa-unlock').addClass("fa-lock");
        return;
    }
}  

/**
 * Display setting panels corresponding to object type
 * @param {string} objectType 
 */
function displaySettingPanel(objectType = '') {
    $(".panel[data-paneltype='setting']").css('display', 'none');
	$(".panel[data-objecttype=" + objectType + "]").css('display', 'block');
}

/**
 * Display setting fieldset corresponding to object type
 * @param {string} objectType 
 */
function displaySettings(objectType = '') {
    $('fieldset[data-setting-type]').css('display', 'none');
	$('fieldset[data-setting-type~=' + objectType + ']').css('display', 'block');
}

/**
 * selection of priority management (fire detection / absence)
 */
function updatePriorityManagement() {
    var priorityManagement = $('#priorityManagement');
    if ($('#absenceInformation').val() != '' && $('#fireDetection').val() != '') {
        priorityManagement.prop('disabled', false);
        if (priorityManagement.val() == null) {
            priorityManagement.val('fireManagement');
        }
    } else {
        priorityManagement.val('');
        priorityManagement.prop('disabled', true);
    }
}

/**
 * Update angle range according to angle unit
 */
function updateAngleRange() {
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
 * Initialize default values
 */
function initDefaultValues() {
    //Initialize default values for object external info      
    if ($('#heliotrope').val() === null) {
        $('#heliotrope').val('none');
    }

    //Initialize default values for object heliotrope zone  
    if ($('#externalInfoObject').val() === null) {
        $('#externalInfoObject').val('none');
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
    if ($('#positionSensorType').val() === null) {
        $('#positionSensorType').val('none');
    }
    if ($('#commandType').val() === null) {
        $('#commandType').val('analogCmd');
    }

}

/**
 * List external info object with configured heliotrope
 */
function listHeliotropeObject() {
    $.ajax({
        type: 'POST',
        async: false,
        url: 'plugins/shutters/core/ajax/shutters.ajax.php',
        data: {
            action: 'listHeliotropeObject',
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
            if (data.result.length == 0) {
                $('#objectType').children("[value='heliotropeZone']").attr('disabled', true);
            } else {
                $('#objectType').children("[value='heliotropeZone']").attr('disabled', false);
            }
        }
    });
}

/**
 * Get status from a command of type 'info'
 */
function getCmdStatus(cmd) {
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
