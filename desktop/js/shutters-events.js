/**
 * Init events
 */
function initEvents() {

    // List commands
    $('body').off('click', '.listCmd').on('click', '.listCmd', function () {
        var dataInput = $(this).attr('data-input');
        var dataType = $(this).attr('data-type');
        var element = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        jeedom.cmd.getSelectModal({cmd: {type: dataType}}, function (result) {
            element.val(result.human);
        });
    });

    //Delete command and it's status
    $('body').off('click', '.delCmd').on('click', '.delCmd', function () {
        var dataInput = $(this).attr('data-input');
        var cmd = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        var cmdStatus = $(this).closest('div.form-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + 'Status]');
        cmd.val(null);
        cmdStatus.val(null);
    });

    // Get status of a command of type 'info'
    $('body').off('click', '.getCmdStatus').on('click', '.getCmdStatus', function () {
        var dataInput = $(this).attr('data-input');
        var dataCmdInput = $(this).attr('data-cmdinput');
        var dataMessage = $(this).attr('data-message');
        var cmd = $('input[id=' + dataCmdInput + ']').val();
        var element = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        bootbox.confirm('{{Avant de récupérer le statut de la commande }}' + cmd + '{{, êtes vous sûr que }}' + dataMessage, function (result) {
            if (result) {
                element.val(getCmdStatus(cmd));
            }
        }) 
    });

    // General events
    $('input[type=range]').on('change mousemove', function() {
        $(this).parent().next().html($(this).val() + '%');
    });

    // General settings events
    $('body').off('click', '.btn-lock').on('click', '.btn-lock', function() {
        var lockBtn = $(this);
        var dataInput = lockBtn.attr('data-input');
        var element = lockBtn.closest('div.input-group').children('select[data-l1key=configuration][data-l2key=' + dataInput + ']');

        if (dataInput =='objectType' && element.is(':disabled')) {
            bootbox.confirm('{{Etes-vous sûr de vouloir changer le type d\'objet? Cela peut entraîner des dysfonctionnements du plugin!}}', function (result) {
                if (result) {
                    element.prop('disabled', false);
                    lockBtn.children('i.fa-lock').removeClass('fa-lock').addClass('fa-unlock');
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