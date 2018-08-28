/**
 * Init events
 */
function initEvents () {

    /**
     * Select a command
     */
    $('.listCmd').off('click').on('click', function () {
        var dataInput = $(this).attr('data-input');
        var dataType = $(this).attr('data-type');
        var dataSubType = $(this).attr('data-subtype');
        if (dataSubType === undefined) {
            dataSubType = '';
        }
        var element = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        jeedom.cmd.getSelectModal({cmd: {type: dataType, subType: dataSubType}}, function (result) {
            element.val(result.human);
            if (dataInput === 'absenceInfoCmd' || dataInput === 'fireDetectionCmd') {
                element.trigger('change');
            }
        });
    });


    /**
     * Delete a command and it's status
     */
    $('.delCmd').off('click').on('click', function () {
        var dataInput = $(this).attr('data-input');
        var cmdElement = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        var cmdStatusElement = $(this).closest('div.form-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + 'Status]');
        var cmd = cmdElement.val();
        bootbox.confirm('{{Effacer la  commande }}' + cmd + '{{ peut engendrer une modification du fonctionnement de vos volets. Confirmez vous la suppression?}}', function (result) {
            if (result) {
                cmdElement.val(null);
                cmdStatusElement.val(null);
                if (dataInput === 'absenceInfoCmd' || dataInput === 'fireDetectionCmd') {
                    cmdElement.trigger('change');
                }
            }
        }) 
    });

    /**
     * Get status of a command 'info'
     */
    $('.getCmdStatus').off('click').on('click', function () {
        var dataInput = $(this).attr('data-input');
        var dataCmdInput = $(this).attr('data-cmdinput');
        var dataMessage = $(this).attr('data-message');
        var cmd = $('input[id=' + dataCmdInput + ']').val();
        var element = $(this).closest('div.input-group').find('input[data-l1key=configuration][data-l2key=' + dataInput + ']');
        if (cmd === null || cmd === '') {
            return;
        }
        if (dataMessage !== '') {
            bootbox.confirm('{{Avant de récupérer le statut de la commande }}' + cmd + '{{, êtes vous sûr que }}' + dataMessage, function (result) {
                if (result) {
                    element.val(getCmdStatus(cmd));
                }
            }) 
        } else {
            element.val(getCmdStatus(cmd));
        }
    });

    /**
     *  Display value of input range
     */
    $('input[type=range]').on('change mousemove', function () {
        $(this).parent().next('span.input-range-value').html($(this).val() + '%');
    });

    /**
     * Unlock button events
     */
    $('.btn-lock').off('click').on('click', function () {
        var lockBtn = $(this);
        var dataInput = lockBtn.attr('data-input');
        var element = lockBtn.closest('div.input-group').children('select[data-l1key=configuration][data-l2key=' + dataInput + ']');

        if (dataInput === 'eqType' && element.is(':disabled')) {
            bootbox.confirm('{{Etes-vous sûr de vouloir changer le type d\'objet? Cela peut entraîner des dysfonctionnements du plugin!}}', function (result) {
                if (result) {
                    element.prop('disabled', false);
                    lockBtn.children('i.fa-lock').removeClass('fa-lock').addClass('fa-unlock');
                    return;
                }
            }) 
        }
    });

    /**
     * External info settings events
     */
    $('#absenceInfoCmd').off('change').on('change', function () {
        updatePriorityFunction();
    });
    $('#fireDetectionCmd').off('change').on('change', function () {
        updatePriorityFunction();
    });

    // Heliotrope zone settings events
    $('[data-l1key=configuration][data-l2key=dawnType]').off('change').on('change', function () {
        var element = $(this);
        displaySelectedDawnOrDusk(element.val());
    });
    $('[data-l1key=configuration][data-l2key=duskType]').off('change').on('change', function () {
        var element = $(this);
        displaySelectedDawnOrDusk(element.val());
    });
    $('[data-l1key=configuration][data-l2key=wallAngle]').off('change').on('change', function () {
        refreshWallPlan();
    });
    $('[data-l1key=configuration][data-l2key=wallAngleUnit]').off('change').on('change', function () {
        updateAngleRange()
        refreshWallPlan();
    });

    // Shutters group settings events
    $('[data-l1key=configuration][data-l2key=shuttersGroupLink]').off('change').on('change', function () {
        var element = $(this);
        if (element.val() !== 'none' && element.val() !== null) {
            $('[data-l1key=configuration][data-l2key=shutterExternalInfoLink]').attr('disabled', true);
            $('[data-l1key=configuration][data-l2key=shutterHeliotropeZoneLink]').attr('disabled', true);
        } else {
            $('[data-l1key=configuration][data-l2key=shutterExternalInfoLink]').attr('disabled', false);
            $('[data-l1key=configuration][data-l2key=shutterHeliotropeZoneLink]').attr('disabled', false);
        }
    });

    // Shutter settings events
    $('[data-l1key=configuration][data-l2key=shutterPositionType]').off('change').on('change', function () {
        var element = $(this);
        displaySettings(element.attr('data-settinggroup'), element.val());
    });
    $('[data-l1key=configuration][data-l2key=shutterCmdType]').off('change').on('change', function () {
        var element = $(this);
        displaySettings(element.attr('data-settinggroup'), element.val());
    });
}