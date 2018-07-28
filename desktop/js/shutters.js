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
    
    displayl1Settings($('#objectType').val());
    displayl2Settings($('#positionSensorType').val());
    drawHeliotropePlan();
    drawWallPlan();

    $('#objectType').off('change').on('change', function() {
        displayl1Settings($('#objectType').val());
    });

    $('#unlockObjectTypeSelection').off('click').on('click', function() {
        if ($('#unlockBtnIcon').hasClass('fa-unlock')){
            $('#objectType').prop('disabled', true);
            $('#unlockBtnIcon').removeClass("fa-unlock");
            $('#unlockBtnIcon').addClass("fa-lock");
        } else {
          	bootbox.confirm("{{Etes-vous sûr de vouloir changer le type d'objet? Cela peut entraîner des dysfonctionnements du système!}}", function (result) {
				if (result) {
                    $('#objectType').prop('disabled', false);
                    $('#unlockBtnIcon').removeClass("fa-lock");
                    $('#unlockBtnIcon').addClass("fa-unlock");
                }
            });
        }
    });

    // Object external informations -> event handler
    $('#absenceInformation').off('change').on('change', function() {
        priorityManagement();
    });
    $('#fireDetection').off('change').on('change', function() {
        priorityManagement();
    });

    $('#dawnType').off('change').on('change', function() {
        displaySelectedDawnOrDusk($('#dawnType').val());
    });

    $('#duskType').off('change').on('change', function() {
        displaySelectedDawnOrDusk($('#duskType').val());
    });

    $('#wallAngle').off('change').on('change', function() {
        refreshWallPlan();
    });

    $('#wallAngleUnit').off('change').on('change', function() {
        updateAngleRange()
        refreshWallPlan();
    });

    $('#positionSensorType').off('change').on('change', function() {
        displayl2Settings($('#positionSensorType').val());
    });

    $('body').off('click','.listCmd').on('click','.listCmd', function () {
        var dataType = $(this).attr('data-type');
        var dataInput = $(this).attr('data-input');
        var el = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        jeedom.cmd.getSelectModal({cmd: {type: dataType}}, function (result) {
            el.value(result.human);
        });
    });

});

function printEqLogic(_eqLogic) {

    var objectTypeChanging = JSON.stringify(_eqLogic.configuration.objectTypeChanging);
    if (objectTypeChanging === '"disable"') {
        $('#objectType').prop('disabled', true);
        $('#unlockBtnIcon').removeClass("fa-unlock");
        $('#unlockBtnIcon').addClass("fa-lock");
    } else {
        $('#objectType').prop('disabled', false);
        $('#unlockBtnIcon').removeClass("fa-lock");
        $('#unlockBtnIcon').addClass("fa-unlock");
    }

    displayl1Settings($('#objectType').val());

//Initialize default values for object heliotrope area      
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

    refreshWallPlan();
    displaySelectedDawnOrDusk($('#dawnType').val());
    displaySelectedDawnOrDusk($('#duskType').val());
}

function hideTooltip() {
    $('#tooltip').css('visibility', 'hidden');
}

function displayTooltip(message) {
    $('#tooltip').html(message).css('visibility', 'visible');
}

function displayl1Settings(object) {
    $('fieldset[data-l1Settings*=' + 'Settings' + ']').css('display', 'none');
	$('fieldset[data-l1Settings~=' + object + 'Settings' + ']').css('display', 'block');
}

function displayl2Settings(object) {
    $('fieldset[data-l2Settings*=' + 'Settings' + ']').css('display', 'none');
	$('fieldset[data-l2Settings~=' + object + 'Settings' + ']').css('display', 'block');
}

function priorityManagement() {
    if($('#absenceInformation').val() != '' && $('#fireDetection').val() != '') {
        $('#priorityManagement').prop('disabled', false);
        if($('#priorityManagement').val() == '') {
            $('#priorityManagement').val('fireManagement');
        }
    } else {
        $('#priorityManagement').val('');
        $('#priorityManagement').prop('disabled', true);
    }
}

function updateAngleRange() {
    if ($('#wallAngleUnit').val() == 'gon') {
        $('#wallAngle').attr('max', 400);
        $('#wallAngleRange').html('0-400gon');
    } else {
        $('#wallAngle').attr('max', 360);
        $('#wallAngleRange').html('0-360°');
    }
}


     