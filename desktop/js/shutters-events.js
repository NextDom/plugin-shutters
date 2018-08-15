/**
 * Init events
 */
function initEvents() {

    // List commands
    $('body').off('click','.listCmd').on('click','.listCmd', function () {
        var dataInput = $(this).attr('data-input');
        var dataType = $(this).attr('data-type');
        var el = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        jeedom.cmd.getSelectModal({cmd: {type: dataType}}, function (result) {
            el.val(result.human).event('change');
        });
    });

    // Get status of a command of type 'info'
    $('body').off('click','.getCmdStatus').on('click','.getCmdStatus', function () {
        var dataInput = $(this).attr('data-input');
        var dataInputLink = $(this).attr('data-input-link');
        var dataMessage = $(this).attr('data-message');
        var cmd = $('input[id=' + dataInputLink + ']').val();
        var el = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        bootbox.confirm('{{Avant de récupérer le statut de la commande }}' + cmd + '{{, êtes vous sûr que }}' + dataMessage, function (result) {
            if (result) {
                el.val(getCmdStatus(cmd));
            }
        }) 
    });

    // General events
    $('input[type=range]').on('change mousemove', function() {
        $(this).parent().next().html($(this).val() + '%');
    });

    // General settings events
     $('#objectType').off('change').on('change', function() {
        displaySettingPanel($(this).val());
    });
    $('.btn-lock').off('click').on('click',function() {
        var dataInput = $(this).attr('data-input');
        var element = $(this).closest('.input-group').children('select[data-l1key=configuration][data-l2key=' + dataInput + ']');

        if (dataInput =='objectType' && element.is(':disabled')) {
            bootbox.confirm('{{Etes-vous sûr de vouloir changer le type d\'objet? Cela peut entraîner des dysfonctionnements du plugin!}}', function (result) {
                if (result) {
                    element.prop('disabled', false);
                    $(this).children('.fa-unlock, .fa-lock').removeClass('fa-lock').addClass("fa-unlock");
                    return;
                }
            }) 
        }
    });

    // External info settings events
    $('#absenceInfo').off('change').on('change', function() {
        updatePriorityManagement();
    });
    $('#fireDetection').off('change').on('change', function() {
        updatePriorityManagement();
    });

    // Heliotrope zone settings events
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

    // Shutter settings events
    $('#positionSensorType').off('change').on('change', function() {
        displaySettings($(this).val(), $(this).attr('data-settings-group'));
    });
    $('#commandType').off('change').on('change', function() {
        displaySettings($(this).val(), $(this).attr('data-settings-group'));
    });

}