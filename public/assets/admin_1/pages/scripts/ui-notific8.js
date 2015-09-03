var UINotific8 = function () {

    return {
        //main function to initiate the module
        init: function () {
                $('#notific8_show').click(function(event) {
                    var settings = {
                            theme: 'lime',
                            sticky: false,
                            horizontalEdge: 'top',
                            verticalEdge: 'right'
                        },
                        $button = $(this);
                    
                    console.log($button);
                    if (!settings.sticky) {
                        settings.life = '10000';
                    }

                    $.notific8('zindex', 11500);
                    $.notific8("Salut", settings);
                    
                    $button.attr('disabled', 'disabled');
                    
                    setTimeout(function() {
                        $button.removeAttr('disabled');
                    }, 1000);

                });

        }

    };

}();