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
    
    var tempValue;

    if ($('#dawnType').val() == null) {
        $('#dawnType').val('sunrise');
//        $('#dawnType option[value="sunrise"]').prop('selected', true);
    }
    if ($('#duskType').val() == null) {
        $('#duskType').val('sunset');
//        $('#duskType option[value="sunset"]').prop('selected', true);
    }
    if ($('#openingType').val() == null) {
        $('#openingType').val('window');
//        $('#openingType option[value="window"]').prop('selected', true);
    }
    tempValue = $('closedPosition').val();
    if (typeof tempValue == 'undefined') {
        $('#closedPosition').val(0);
    }
    tempValue = $('openedPosition').val();
    if (typeof tempValue == 'undefined') {
        $('#openedPosition').val(100);
    }
    tempValue = $('incomingAzimuthAngle').val();
    if (typeof tempValue == 'undefined') {
        $('#incomingAzimuthAngle').val(0);
    }
    tempValue = $('outgoingAzimuthAngle').val();
    if (typeof tempValue == 'undefined') {
        $('#outgoingAzimuthAngle').val(180);
    }
    var map = L.map('map', {
        center: [49.0,0.3],
        zoom: 20,
        layers: [
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            })
        ]
    })
    var arrow = L.polyline([[49.0,0.3], [49.001,0.301]], {}).addTo(map);
    var arrowHead = L.polylineDecorator(arrow, {
        patterns: [
            {offset: '100%', repeat: 0, symbol: L.Symbol.arrowHead({pixelSize: 15, polygon: false, pathOptions: {stroke: true}})}
        ]
    }).addTo(map);
    var markerPatterns = L.polylineDecorator(arrow, {
        patterns: [
            { offset: '0%', repeat: '0%', symbol: L.Symbol.marker()}
        ]
}).addTo(map);
});

$('#objectType').change(function(){
    if ($('#objectType').val() == 'shutter') {
        $('#heliotropeSettings').hide();
        $('#shutterSettings').show();
    }
    else if ($('#objectType').val() == 'shuttersArea') {
        $('#heliotropeSettings').show();
        $('#shutterSettings').hide();
    }
});

$('body').off('click','.listCmdAction').on('click','.listCmdAction', function () {
    var type = $(this).attr('data-type');
    var el = $(this).closest('.' + type).find('.expressionAttr[data-l1key=cmd]');
    jeedom.cmd.getSelectModal({cmd: {type: type}}, function (result) {
        el.value(result.human);
        jeedom.cmd.displayActionOption(el.value(), '', function (html) {
            el.closest('.' + type).find('.actionOptions').html(html);
        });
    });
});
