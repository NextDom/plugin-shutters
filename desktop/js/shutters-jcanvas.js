function drawWallPlan() {
    var angle = convertAngleToDegree($('#wallAngle').val(), $('#wallAngleUnit').val());
    
    $('#wallPlan').addLayer({
        type: 'image',
        name: 'wall',
        source: 'plugins/shutters/resources/images/window.png',
        rotate: angle - 90,
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
        type: 'vector',
        name: 'axe',
        strokeStyle: '#d9534f',
        strokeWidth: 5,
        strokeDash: [10],
        strokeDashOffset: 0,
        rounded: true,
        x: 200, y: 200,
        a1: angle,
        l1: 150
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
        start: 0,
        end:  angle
    })
    .drawLayers();
}

/**
 * Draw heliotrope plan
 */
function drawHeliotropePlan() {
    var dawnTypeElement = $('[data-l1key=configuration][data-l2key=dawnType]');
    var duskTypeElement = $('[data-l1key=configuration][data-l2key=duskType]');
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
        x1: 50, y1: 200,
        x2: 350, y2: 200
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
        fillStyle: '#7d7d7d',
        x: 200, y: 200,
        radius: 165,
      	rotate: 102,
        fontSize: '12pt',
        align: 'center',
        text: 'Aube'
    })
    .addLayer({
        type: 'text',
        fillStyle: '#7d7d7d',
        x: 200, y: 200,
        radius: 165,
      	rotate: 258,
        fontSize: '12pt',
        align: 'center',
        text: 'Crépuscule'
    })
    .addLayer({
        type: 'image',
		name: 'sun',
        source: 'plugins/shutters/resources/images/sun1.png',
        x: 200, y: 50,
        scale: 0.15,
        fromCenter: true
    })
    .addLayer({
        type: 'text',
		name: 'info',
      	fillStyle: '#000',
        x: 200, y: 375,
        maxWidth: 380,
        fontSize: '12pt',
        align: 'center',
        text: 'Cliquer sur les points jaunes pour sélectionner l\'aube ou le crépuscule'
    })
    .addLayer({
        type: 'arc',
        strokeStyle: '#B3B3B3',
        strokeWidth: 2,
        x: 200, y: 200,
        radius: 185,
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
            dawnTypeElement.val('sunrise').trigger('change');
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
            dawnTypeElement.val('civilDawn').trigger('change');
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
            dawnTypeElement.val('nauticalDawn').trigger('change');
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
            dawnTypeElement.val('astronomicalDawn').trigger('change');
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
            duskTypeElement.val('sunset').trigger('change');
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
            duskTypeElement.val('civilDusk').trigger('change');
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
            duskTypeElement.val('nauticalDusk').trigger('change');
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
            duskTypeElement.val('astronomicalDusk').trigger('change');
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
        $('.cursor-tooltip').css({
            top: event.pageY + 20,
            left: event.pageX
        })
    });
}

/**
 * Refresh wall plan
 */
function refreshWallPlan() {
    var angle = convertAngleToDegree($('#wallAngle').val(), $('#wallAngleUnit').val());
    $('#wallPlan').setLayer('wall', {
            rotate: angle - 90
        })
        .setLayer('axe', {
            a1: angle
        })
        .setLayer('arc', {
            end:  convertAngleToDegree($('#wallAngle').val(), $('#wallAngleUnit').val())
        })
        .drawLayers();  
}

/**
 * Update display of selected dawn or dusk
 * @param {*} _layerName Canvas layer name
 */
function displaySelectedDawnOrDusk(_layerName) {
    var element = $('#heliotropePlan');
    var deselectedGroupName = _layerName + 'DeselectedGroup';
    element.animateLayer(_layerName, {
        fillStyle: '#d9534f'
    });
    element.animateLayerGroup(deselectedGroupName, {
        fillStyle: '#FEE200'
    });
}
/**
 * Convert angle to Degree
 * @param {int} _angle Angle value
 * @param {string} _unit Unit angle
 */
function convertAngleToDegree(_angle = 0, _unit = 'deg') {
    switch (_unit) {
        case 'deg':
            return parseInt(_angle);
        case 'gon':
            return parseInt(_angle) * 0.9;
        default:
            return 0;
    }
}
