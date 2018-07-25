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
    
    var angle = convertAngleToDegree($('#wallAngle').val(), $('#wallAngleUnit').val()) - 90;
    
    $('#wallPlan').addLayer({
        type: 'image',
        name: 'wall',
        source: 'plugins/shutters/resources/images/window.png',
        rotate: angle,
        x: 0, y: 0,
        fromCenter: false
    })
    .addLayer({
        type: 'line',
        strokeStyle: '#d9534f',
        strokeWidth: 5,
        rounded: true,
        endArrow: true,
        arrowRadius: 15,
        arrowAngle: 90,
        x1: 200, y1: 200,
        x2: 200, y2: 50
    })
    .addLayer({
        type: 'text',
        fillStyle: '#d9534f',
        x: 200, y: 20,
        fontSize: '20pt',
        align: 'center',
        text: 'Nord'
    })
    .addLayer({
        type: 'line',
        name: 'axe',
        strokeStyle: '#d9534f',
        strokeWidth: 5,
        strokeDash: [10],
        strokeDashOffset: 0,
        rounded: true,
        x1: 200, y1: 200,
        x2: parseInt(200 + (150 * (Math.cos(angle * Math.PI / 180)))),
        y2: parseInt(200 + (150 * (Math.sin(angle * Math.PI / 180))))
    })
    .addLayer({
        type: 'arc',
        name: 'arc',
        strokeStyle: '#d9534f',
        strokeWidth: 1,
        strokeDash: [4],
        strokeDashOffset: 0,
        rounded: true,
        x: 200, y: 200,
        radius: 50,
        start: 0, end:  convertAngleToDegree($('#wallAngle').val(), $('#wallAngleUnit').val())
    })
    .drawLayers();
    
    $('#heliotropePlan').addLayer({
        type: 'slice',
        name: 'day',
        fillStyle: '#DBE9FF',
        x: 200, y: 200,
        start: 270, end: 90,
        radius: 150,
        spread: 0 / 40
    })
    .addLayer({
        type: 'slice',
        name: 'morningCivilTwilight',
        fillStyle: '#87A4D3',
        x: 200, y: 200,
        start: 90, end: 96,
        radius: 150,
        spread: 0 / 40
    })
    .addLayer({
        type: 'slice',
        name: 'morningNauticalTwilight',
        fillStyle: '#4773BB',
        x: 200, y: 200,
        start: 96, end: 102,
        radius: 150,
        spread: 0 / 40
    })
    .addLayer({
        type: 'slice',
        name: 'morningAstronomicalTwilight',
        fillStyle: '#263E66',
        x: 200, y: 200,
        start: 102, end: 108,
        radius: 150,
        spread: 0 / 40
    })
    .addLayer({
        type: 'slice',
        name: 'night',
        fillStyle: '#1F252D',
        x: 200, y: 200,
        start: 108, end: 252,
        radius: 150,
        spread: 0 / 40
    })
    .addLayer({
        type: 'slice',
        name: 'eveningAstronomicalTwilight',
        fillStyle: '#263E66',
        x: 200, y: 200,
        start: 252, end: 258,
        radius: 150,
        spread: 0 / 40
    })
    .addLayer({
        type: 'slice',
        name: 'eveningNauticalTwilight',
        fillStyle: '#4773BB',
        x: 200, y: 200,
        start: 258, end: 264,
        radius: 150,
        spread: 0 / 40
    })
    .addLayer({
        type: 'slice',
        name: 'eveningCivilTwilight',
        fillStyle: '#87A4D3',
        x: 200, y: 200,
        start: 264, end: 270,
        radius: 150,
        spread: 0 / 40
    })
    .addLayer({
        type: 'line',
        name: 'skyline',
        strokeStyle: '#B3B3B3',
        strokeWidth: 2,
        x1: 20, y1: 200,
        x2: 380, y2: 200
    })     
    .addLayer({
        type: 'text',
        fillStyle: '#B3B3B3',
        x: 200, y: 190,
        fontSize: '10pt',
        align: 'center',
        text: 'horizon'
    })
    .addLayer({
        type: 'text',
        fillStyle: '#7d7d7d',
        x: 200, y: 100,
        fontSize: '12pt',
        align: 'center',
        text: 'Jour'
    })
    .addLayer({
        type: 'text',
        fillStyle: '#7d7d7d',
        x: 200, y: 300,
        fontSize: '12pt',
        align: 'center',
        text: 'Nuit'
    })
    .addLayer({
        type: 'text',
		name: 'sun',
      	fillStyle: '#FEE200',
        x: 200, y: 50,
        fontSize: 48,
        fontFamily: 'FontAwesome',
        text: '\uf185'
    })
    .addLayer({
        type: 'arc',
        strokeStyle: '#B3B3B3',
        strokeWidth: 2,
        x: 200, y: 200,
        radius: 180,
 		start: -10, end: 10,
   		rounded: true,
        startArrow: true,
        arrowRadius: 10,
        arrowAngle: 90
    })
         .addLayer({
        type: 'arc',
        name: 'sunrise',
 		groups: ['civilDawnDeselectedGroup', 'nauticalDawnDeselectedGroup', 'astronomicalDawnDeselectedGroup'],
        strokeStyle: '#FEE200',
        strokeWidth: 1,
        fillStyle: '#FEE200',
        x: 350, y: 200,
        radius: 5,
        cursors: {mouseover: 'pointer'},
        click: function() {
            $('#dawnType').val('sunrise').trigger('change');
        },
        mouseover: function() {
            displayTooltip('{{Lever du soleil}}');
        },
        mouseout: function() {
            hideTooltip();
        }
    })
    .addLayer({
        type: 'arc',
        name: 'civilDawn',
  		groups: ['sunriseDeselectedGroup', 'nauticalDawnDeselectedGroup', 'astronomicalDawnDeselectedGroup'],
        strokeStyle: '#FEE200',
        strokeWidth: 1,
        fillStyle: '#FEE200',
        x: parseInt(200 + (150 * (Math.cos(6 * Math.PI / 180)))),
        y: parseInt(200 + (150 * (Math.sin(6 * Math.PI / 180)))),
        radius: 5,
        cursors: {mouseover: 'pointer'},
        click: function() {
            $('#dawnType').val('civilDawn').trigger('change');
        },
        mouseover: function() {
            displayTooltip('{{Aube civile}}');
        },
        mouseout: function() {
            hideTooltip();
        }
    })
    .addLayer({
        type: 'arc',
        name: 'nauticalDawn',
  		groups: ['sunriseDeselectedGroup', 'civilDawnDeselectedGroup', 'astronomicalDawnDeselectedGroup'],
        strokeStyle: '#FEE200',
        strokeWidth: 1,
        fillStyle: '#FEE200',
        x: parseInt(200 + (150 * (Math.cos(12 * Math.PI / 180)))),
        y: parseInt(200 + (150 * (Math.sin(12 * Math.PI / 180)))),
        radius: 5,
        cursors: {mouseover: 'pointer'},
        click: function() {
            $('#dawnType').val('nauticalDawn').trigger('change');
        },
        mouseover: function() {
            displayTooltip('{{Aube nautique}}');
        },
        mouseout: function() {
            hideTooltip();
        }
    })
    .addLayer({
        type: 'arc',
        name: 'astronomicalDawn',
  		groups: ['sunriseDeselectedGroup', 'civilDawnDeselectedGroup', 'nauticalDawnDeselectedGroup'],
        strokeStyle: '#FEE200',
        strokeWidth: 1,
        fillStyle: '#FEE200',
        x: parseInt(200 + (150 * (Math.cos(18 * Math.PI / 180)))),
        y: parseInt(200 + (150 * (Math.sin(18 * Math.PI / 180)))),
        radius: 5,
        cursors: {mouseover: 'pointer'},
        click: function() {
            $('#dawnType').val('astronomicalDawn').trigger('change');
        },
        mouseover: function() {
            displayTooltip('{{Aube astronomique}}');
        },
        mouseout: function() {
            hideTooltip();
        }
    })
    .addLayer({
        type: 'arc',
        name: 'sunset',
 		groups: ['civilDuskDeselectedGroup', 'nauticalDuskDeselectedGroup', 'astronomicalDuskDeselectedGroup'],
        strokeStyle: '#FEE200',
        strokeWidth: 1,
        fillStyle: '#FEE200',
        x: 50, y: 200,
        radius: 5,
        cursors: {mouseover: 'pointer'},
        click: function() {
            $('#duskType').val('sunset').trigger('change');
        },
        mouseover: function() {
            displayTooltip('{{Coucher du soleil}}');
        },
        mouseout: function() {
            hideTooltip();
        }
    })
    .addLayer({
        type: 'arc',
        name: 'civilDusk',
  		groups: ['sunsetDeselectedGroup', 'nauticalDuskDeselectedGroup', 'astronomicalDuskDeselectedGroup'],
        strokeStyle: '#FEE200',
        strokeWidth: 1,
        fillStyle: '#FEE200',
        x: parseInt(200 + (150 * (Math.cos(174 * Math.PI / 180)))),
        y: parseInt(200 + (150 * (Math.sin(174 * Math.PI / 180)))),
        radius: 5,
        cursors: {mouseover: 'pointer'},
        click: function() {
            $('#duskType').val('civilDusk').trigger('change');
        },
        mouseover: function() {
            displayTooltip('{{Crépuscule civil}}');
        },
        mouseout: function() {
            hideTooltip();
        }
    })
    .addLayer({
        type: 'arc',
        name: 'nauticalDusk',
  		groups: ['sunsetDeselectedGroup', 'civilDuskDeselectedGroup', 'astronomicalDuskDeselectedGroup'],
        strokeStyle: '#FEE200',
        strokeWidth: 1,
        fillStyle: '#FEE200',
        x: parseInt(200 + (150 * (Math.cos(168 * Math.PI / 180)))),
        y: parseInt(200 + (150 * (Math.sin(168 * Math.PI / 180)))),
        radius: 5,
        cursors: {mouseover: 'pointer'},
        click: function() {
            $('#duskType').val('nauticalDusk').trigger('change');
        },
        mouseover: function() {
            displayTooltip('{{Crépuscule nautique}}');
        },
        mouseout: function() {
            hideTooltip();
        }
    })
    .addLayer({
        type: 'arc',
        name: 'astronomicalDusk',
  		groups: ['sunsetDeselectedGroup', 'civilDuskDeselectedGroup', 'nauticalDuskDeselectedGroup'],
        strokeStyle: '#FEE200',
        strokeWidth: 1,
        fillStyle: '#FEE200',
        x: parseInt(200 + (150 * (Math.cos(162 * Math.PI / 180)))),
        y: parseInt(200 + (150 * (Math.sin(162 * Math.PI / 180)))),
        radius: 5,
        cursors: {mouseover: 'pointer'},
        click: function() {
            $('#duskType').val('astronomicalDusk').trigger('change');
        },
        mouseover: function() {
            displayTooltip('{{Crépuscule astronomique}}');
        },
        mouseout: function() {
            hideTooltip();
        }
    })
    .drawLayers()
    .on('mousemove', function(event) {
        $('#tooltip').css({
            top: event.pageY + 20,
            left: event.pageX
        })
    });

    $('#objectType').off('change').on('change', function() {
        displayObjectConf();
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
        refreshWallPlan();
    });


    $('#positionSensorType').off('change').on('change', function() {
        switch ($('#positionSensorType').val()) {
            case 'analog':
            $('#analogPositionSettings').show();
            $('#closedLimitSwitchSettings').hide();
            $('#openedLimitSwitchSettings').hide();
            break;
        case 'openedClosedLimitSwitch':
            $('#analogPositionSettings').hide();
            $('#closedLimitSwitchSettings').show();
            $('#openedLimitSwitchSettings').show();
            break;
        case 'closedLimitSwitch':
            $('#analogPositionSettings').hide();
            $('#closedLimitSwitchSettings').show();
            $('#openedLimitSwitchSettings').hide();
            break;
        case 'openedLimitSwitch':
            $('#analogPositionSettings').hide();
            $('#closedLimitSwitchSettings').hide();
            $('#openedLimitSwitchSettings').show();
            break;
        default:
            $('#analogPositionSettings').hide();
            $('#closedLimitSwitchSettings').hide();
            $('#openedLimitSwitchSettings').hide();
            break;
        }
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

    displayObjectConf();

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

function displayObjectConf() {
    switch ($('#objectType').val()) {
        case 'heliotropeArea':
            $('#shutterSettings').css('display', 'none');
            //$('#shutterHeliotropeSettings').hide();
            $('#heliotropeSettings').css('display', 'block');
            break;
        case 'shutter':
            $('#heliotropeSettings').css('display', 'none');
            // $('#shutterHeliotropeSettings').show();
            $('#shutterSettings').css('display', 'block');
            break;
        case 'shuttersArea':
            //$('#shutterHeliotropeSettings').hide();
            $('#heliotropeSettings').css('display', 'none');
            $('#shutterSettings').css('display', 'none');
            break;
        default:
            //$('#heliotropeSettings').hide();
            $('#shutterHeliotropeSettings').css('display', 'none');
            $('#shutterSettings').css('display', 'none');
        }
}

function hideTooltip() {
    $('#tooltip').css('visibility', 'hidden');
}

function displayTooltip(message) {
    $('#tooltip').html(message).css('visibility', 'visible');
}

function refreshWallPlan() {
    var angle = convertAngleToDegree($('#wallAngle').val(), $('#wallAngleUnit').val()) - 90;
    $('#wallPlan').removeLayer('axe')
        .removeLayer('arc')
        .setLayer('wall', {
            rotate: angle
        })
        .addLayer({
            type: 'line',
            name: 'axe',
            strokeStyle: '#d9534f',
            strokeWidth: 5,
            strokeDash: [10],
            strokeDashOffset: 0,
            rounded: true,
            x1: 200, y1: 200,
            x2: parseInt(200 + (150 * (Math.cos(angle * Math.PI / 180)))),
            y2: parseInt(200 + (150 * (Math.sin(angle * Math.PI / 180))))
        })
        .addLayer({
            type: 'arc',
            name: 'arc',
            strokeStyle: '#d9534f',
            strokeWidth: 1,
            strokeDash: [4],
            strokeDashOffset: 0,
            rounded: true,
            x: 200, y: 200,
            radius: 50,
            start: 0, end:  convertAngleToDegree($('#wallAngle').val(), $('#wallAngleUnit').val())
        })
        .drawLayers();  
}

function convertAngleToDegree(angle = 0, unit = 'deg') {
    switch (unit) {
        case 'deg':
            return parseInt(angle);
        case 'gon':
            return parseInt(angle) * 0.9;
        default:
            return 0;
    }
}

function displaySelectedDawnOrDusk(name) {
    $('#heliotropePlan').animateLayer(name, {
        fillStyle: '#d9534f'
    });
    var deselectedGroupName = name + 'DeselectedGroup';
    $('#heliotropePlan').animateLayerGroup(deselectedGroupName, {
        fillStyle: '#FEE200'
    });
}
     