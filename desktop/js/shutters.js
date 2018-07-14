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
    if ($('#positionSensorType').val() == null) {
        $('#positionSensorType').val('analog');
    }
    tempValue = $('closedPosition').val();
    if (typeof tempValue == 'undefined') {
        $('#closedPosition').val(0);
    }
    tempValue = $('openedPosition').val();
    if (typeof tempValue == 'undefined') {
        $('#openedPosition').val(100);
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

$('#objectType').change(function(){
    if ($('#objectType').val() == 'shutter') {
        $('#heliotropeSettings').hide();
        $('#shutterSettings').show();
        $('#shutterHeliotropeSettings').show();
    }
    else if ($('#objectType').val() == 'shuttersArea') {
        $('#heliotropeSettings').show();
        $('#shutterSettings').hide();
        $('#shutterHeliotropeSettings').hide();
    }
});

$('#positionSensorType').change(function(){
    if ($('#positionSensorType').val() == 'analog') {
        $('#analogPositionSettings').show();
    }
    else if ($('#positionSensorType').val() == 'limitSwitch') {
        $('#analogPositionSettings').hide();
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
