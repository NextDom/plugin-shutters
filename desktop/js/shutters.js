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
