$(document).ready(function() {
    var costColumn = document.getElementById("cost");
    var costColumnContent = document.getElementsByClassName("costColumnContent");
    var toggleButton = document.getElementById("toggleButton");
    var toggleState = true;

    var toggleView = $('#toggleView').bootstrapToggle();
    var toggleSelect = $('#toggleSelect').bootstrapToggle();

    var toggleViewStatus = false;
    var toggleSelectStatus = false;

    console.log(toggleView);
    console.log(toggleSelect);

    if (toggleButton != null && costColumn != null) {
        toggleButton.classList.add("btn-success");
        if (toggleState) {
            toggleButton.classList.add("btn-success");
            costColumn.hidden = false;
            for (let index = 0; index < costColumnContent.length; index++) {
                costColumnContent.item(index).hidden = false;
            }
        } else {
            toggleButton.classList.add("btn-danger");
            costColumn.hidden = true;
            for (let index = 0; index < costColumnContent.length; index++) {
                costColumnContent.item(index).hidden = true;
            }
        }
        toggleButton.onclick = function () {
            toggleState = !toggleState;
            toggleButton.classList.remove("btn-success");
            toggleButton.classList.remove("btn-danger");
            if (toggleState) {
                toggleButton.classList.add("btn-success");
                costColumn.hidden = false;
                for (let index = 0; index < costColumnContent.length; index++) {
                    costColumnContent.item(index).hidden = false;
                }
            } else {
                toggleButton.classList.add("btn-danger");
                costColumn.hidden = true;
                for (let index = 0; index < costColumnContent.length; index++) {
                    costColumnContent.item(index).hidden = true;
                }
            }
        }
    }

    if (toggleView != null) {
        $('#receiptView').toggleClass('d-none');
        toggleView.change(function() {
            if ($(this).prop('checked')) {
                //receipt view

                console.log("Receipt view");

                if ($('#receiptView').hasClass('d-none')) {
                    $('#receiptView').removeClass('d-none');
                }
                $('#itemsView').addClass('d-none');
                
                if (!$('#aggregatedItemsView').hasClass('d-none')) {
                    $('#aggregatedItemsView').addClass('d-none');
                }
                
                toggleViewStatus = true;
                $('#toggleSelect').bootstrapToggle('disable');
            }else{
                //items view

                console.log("Items view");
                if(!toggleSelectStatus){
                    if ($('#itemsView').hasClass('d-none')) {
                        $('#itemsView').removeClass('d-none');
                    }
                }else{
                    if ($('#aggregatedItemsView').hasClass('d-none')) {
                        $('#aggregatedItemsView').removeClass('d-none');
                    }
                }

                $('#receiptView').addClass('d-none');
                $('#toggleSelect').bootstrapToggle('enable');
                // if (!$('#aggregatedItemsView').hasClass('d-none')) {
                //     $('#aggregatedItemsView').addClass('d-none');
                // }
                toggleViewStatus = false;
            }        
        });
    }

    if (toggleSelect != null && toggleView != null) {
        $('#aggregatedItemsView').toggleClass('d-none');
        toggleSelect.change(function () {
            if(toggleViewStatus == false){
                if ($(this).prop('checked')) {
                    //aggregated view
                    toggleSelectStatus = true;
                    if ($('#aggregatedItemsView').hasClass('d-none')) {
                        $('#aggregatedItemsView').removeClass('d-none');
                    }
                    $('#itemsView').addClass('d-none');

                    console.log("Aggregated");
                }else{
                    //non aggregated view
                    toggleSelectStatus = false;
                    if ($('#itemsView').hasClass('d-none')) {
                        $('#itemsView').removeClass('d-none');
                    }
                    $('#aggregatedItemsView').addClass('d-none');

                    console.log("Non Aggregated");
                }  
            }
        });
    }


    



})