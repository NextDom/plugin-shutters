/**
 * Init events
 */
function initEvents() {

    // List commands
    $('body').off('click','.listCmd').on('click','.listCmd', function () {
        var dataType = $(this).attr('data-type');
        var dataInput = $(this).attr('data-input');
        var el = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        jeedom.cmd.getSelectModal({cmd: {type: dataType}}, function (result) {
            el.val(result.human);
        });
    });

    $('body').off('click','.getCmdStatus').on('click','.getCmdStatus', function () {
        var dataInput = $(this).attr('data-input');
        var dataInputLink = $(this).attr('data-input-link');
        var dataMessage = $(this).attr('data-message');
        var cmd = $('input[id=' + dataInputLink + ']').val();
        bootbox.confirm('{{Avant de récupérer le statut de la commande}}' + cmd + '{{, êtes vous sûr que }}' + dataMessage, function (result) {
            if (result) {
                var el = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
                el.val(getCmdStatus(cmd));
            }
        }) 
    });

    // General events
    $('a.button-lock').on('click',function() {
        lockControl($(this));
    });
    $('input[type=range]').on('change mousemove', function() {
        $(this).parent().next().html($(this).val() + '%');
    });

    // General settings events
     $('#objectType').off('change').on('change', function() {
        displaySettingPanel($(this).val());
    });


    // External info settings events
    $('#absenceInformation').off('change').on('change', function() {
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

    //shutter settings events
}