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

    $('a.button-lock').on('click',function(){
        lockControl($(this));
    })

    $('#objectType').off('change').on('change', function() {
        displaySettingPanel($(this).val());
    });

    $('#absenceInformation').off('change').on('change', function() {
        priorityManagement();
    });
    $('#fireDetection').off('change').on('change', function() {
        priorityManagement();
    });

    
    
}