$(document).ready(function() {
    var costColumn = document.getElementById("cost");
    var costColumnContent = document.getElementsByClassName("costColumnContent");
    var toggleButton = document.getElementById("toggleButton");
    var toggleState = true;

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
})