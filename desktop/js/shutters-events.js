/**
 * Init events
 */
function initEvents() {
    
    $('body').off('click','.listCmd').on('click','.listCmd', function () {
        var dataType = $(this).attr('data-type');
        var dataInput = $(this).attr('data-input');
        var el = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        jeedom.cmd.getSelectModal({cmd: {type: dataType}}, function (result) {
            el.value(result.human);
        });
    });

    // General settings events
    $('a.button-lock').on('click',function() {
        lockControl($(this));
    })
    $('#objectType').off('change').on('change', function() {
        displaySettingPanel($(this).val());
    });

    // External info settings events
    $('#absenceInformation').off('change').on('change', function() {
        priorityManagement();
    });
    $('#fireDetection').off('change').on('change', function() {
        priorityManagement();
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

    
}