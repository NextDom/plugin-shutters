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

var $shuttersAreaPlan = $('shuttersAreaPlan');
$shuttersAreaPlan.drawSlice({
    fillStyle: '#f63',
    x: 100, y: 100,
    radius: 150,
    // start and end angles in degrees
    start: 60, end: 120
  });

$(document).ready(function() {
    
    var tempValue;

    if ($('#dawnType').val() == null) {
        $('#dawnType').val('sunrise');
    }
    if ($('#duskType').val() == null) {
        $('#duskType').val('sunset');
    }
    if ($('#openingType').val() == null) {
        $('#openingType').val('window');
    }
    tempValue = $('analogClosedPosition').val();
    if (typeof tempValue == 'undefined') {
        $('#analogClosedPosition').val(0);
    }
    tempValue = $('analogOpenedPosition').val();
    if (typeof tempValue == 'undefined') {
        $('#analogOpenedPosition').val(100);
    }
    tempValue = $('wallAngle').val();
    if (typeof tempValue == 'undefined') {
        $('#wallAngle').val(0);
    }
    tempValue = $('incomingAzimuthAngle').val();
    if (typeof tempValue == 'undefined') {
        $('#incomingAzimuthAngle').val(-90);
    }
    tempValue = $('outgoingAzimuthAngle').val();
    if (typeof tempValue == 'undefined') {
        $('#outgoingAzimuthAngle').val(90);
    }
});

$('#objectType').change(function() {
    var objectType = $('#objectType').val();
    switch (objectType) {
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

$('body').off('click','.listCmd').on('click','.listCmd', function () {
    var dataType = $(this).attr('data-type');
    var dataInput = $(this).attr('data-input');
    var el = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
    jeedom.cmd.getSelectModal({cmd: {type: dataType}}, function (result) {
        el.value(result.human);
    });
});

var positionSensorType = $('#positionSensorType');
    console.log(positionSensorType.val());
    console.log($('#analogPositionSettings'));
    console.log($('#closedLimitSwitchSettings'));
    console.log($('#openedLimitSwitchSettings'));
    positionSensorType.on('change', function() {
        switch (positionSensorType.val()) {
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