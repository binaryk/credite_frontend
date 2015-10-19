function sweetConfirmDelete (successCallback, errorCallback) {
        swal({
            title: "Sunteti sigur?",
            text: 'Doriti sa stergeti inregistrarea ?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Da, sunt sigur!',
            cancelButtonText: 'Anuleaza!!',
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(confirmed) {
            if(confirmed && typeof successCallback === "function") {
                successCallback();
            }else if(!confirmed && typeof errorCallback === "function") {
                errorCallback();
            }
        });
}