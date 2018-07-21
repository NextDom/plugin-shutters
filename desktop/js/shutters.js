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
    
    var wallAngle = $('#wallAngle');
    var heliotropeAreaPlan = $('#heliotropeAreaPlan');
    var angle = parseInt(wallAngle.val() - 90);
    
    heliotropeAreaPlan.addLayer({
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
        start: 0, end:  parseInt(wallAngle.val())
    })
    .drawLayers();
      
    wallAngle.on('change', function() {
        angle = parseInt(wallAngle.val() - 90);
        heliotropeAreaPlan.removeLayer('axe')
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
                start: 0, end:  parseInt(wallAngle.val())
            })
            .drawLayers();  
    });

    $('#objectType').off('change').on('change', function() {
        switch ($('#objectType').val()) {
            case 'heliotropeArea':
                $('#shutterSettings').hide();
                $('#shutterHeliotropeSettings').hide();
                $('#heliotropeSettings').show();
                break;
            case 'shutter':
                $('#heliotropeSettings').hide();
                $('#shutterSettings').show();
                $('#shutterHeliotropeSettings').show();
                break;
            case 'shuttersArea':
                $('#shutterSettings').hide();
                $('#shutterHeliotropeSettings').hide();
                $('#heliotropeSettings').show();
                break;
            default:
                $('#heliotropeSettings').hide();
                $('#shutterSettings').hide();
                $('#shutterHeliotropeSettings').hide();
        }
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

    if ($('#dawnType').val() === null) {
        $('#dawnType').val('sunrise');
    }
    if ($('#duskType').val() === null) {
        $('#duskType').val('sunset');
    }
    if ($('#wallAngle').val() === '') {
      $('#wallAngle').val(0);
    }

}