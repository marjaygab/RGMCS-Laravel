$(document).ready(function () {

    var base_url = "http://localhost/RGMCS-Laravel/public";
    currentPath = parsePath("/RGMCS-Laravel/public/","");

    console.log(currentPath);
    
    if (currentPath == "/notebook" || currentPath.includes("/notebook/edit",0)) {

        var vendorSelection = document.getElementById("vendorSelection");
        var itemsSelection = document.getElementById("itemsSelection");
        var basePrice = document.getElementById('basePrice');
        var netPrice = document.getElementById('netPrice');
        var discount1 = document.getElementById('discount1');
        var discount2 = document.getElementById('discount2');
        var discount3 = document.getElementById('discount3');
        var discount4 = document.getElementById('discount4');
        var supplierName = document.getElementById('supplierName');
        var transactionDateView = document.getElementById('transactionDateView');
    
        var dataSource = [];
        var discountFields = [discount1, discount2, discount3, discount4];
        
    
        var toUpdateIndex = null;
        var ToUpdateReceiptIndex = "";
    
        $('.input-group.date').datepicker({
            orientation: "bottom"
        });
    
        $('.input-group.date').datepicker("setDate", new Date);

        var myReceipt = new Receipt($('#transactionDateView').html());
    
        discount1.value = 0;
        discount2.value = 0;
        discount3.value = 0;
        discount4.value = 0;
        basePrice.value = 0.00;
        toggleAddingControls(true);
        var dateSelected = new Date();
        var dateString = dateSelected.getFullYear() + "-" + minTwoDigits(dateSelected.getMonth() + 1) + "-" + minTwoDigits(dateSelected.getDate());
        $('#transactionDateView').html(dateString);
    

        if (currentPath.includes("/notebook/edit",0)) {
            receipt_no = currentPath.replace("/notebook/edit/","");
            
            $.ajax({
                url: base_url + '/receipt/' + receipt_no,
                type: 'GET',
                success: function (result) {
                    var responseBody = JSON.parse(result);
                    var receipt = responseBody.receipt;
                    var receiptItems = responseBody.receipt_items;                    

                    myReceipt = new Receipt(receipt.tdate,receipt.vid,receipt.vendor);
                    
                    receiptItems.forEach(item => {
                        tempItem = new Items(
                            item.itemno,
                            item.itemdesc,
                            item.baseprice,
                            item.d1,
                            item.d2,
                            item.d3,
                            item.d4,
                            item.netprice
                        );
                        tempItem.setReceiptItemIndex(item.id);
                        myReceipt.addItem(tempItem);

                    });
                    myReceipt.setTotalNetPrice();
                    myReceipt.setReceiptIndex(receipt_no);

                    $('#transactionDateView').html(myReceipt.getDate());
                    $('.input-group.date').datepicker("setDate", new Date(myReceipt.getDate()));
                    $('#itemListContainer').html(myReceipt.generate());
                    $('#total-label').html(myReceipt.getTotalNetPrice());
                    $('#supplierName').html(myReceipt.getVendor())
                    $('#vendorSelection').val(myReceipt.getVid());
                    
                    console.log(myReceipt);
                    
                },
                error: function (error) {
                    console.log(`Error: ${error}`);
                }
            });

        }


    
        $('#receiptItemsTable').DataTable({
            "data":dataSource
        });
    
    
        $('#basePrice').on('change', function () {
            try {
                base = parseFloat($(this).val());
                if (Number.isNaN(base)) {
                    throw "NaN"
                } else if (base < 0) {
                    throw "Less that 0";
                }
                if (base > 0) {
                    toggleAddingControls(false);
                    netPrice.value = computeNetPrice(base, discount1.value, discount2.value, discount3.value, discount4.value);
                } else {
                    toggleAddingControls(true);
                    netPrice.value = 0;
                }
            } catch (error) {
                $(this).val(0)
                netPrice.value = 0;
                toggleAddingControls(true);
            }
        });
    
        $('#discount1').on('change', function () {
            try {
                base = parseFloat($('#basePrice').val());
                discount = parseInt($(this).val());
                if (Number.isNaN(discount)) {
                    throw "NaN"
                }
                netPrice.value = computeNetPrice(base, discount, discount2.value, discount3.value, discount4.value);
            } catch (error) {
                base = parseFloat($('#basePrice').val());
                $(this).val(0);
                discount = 0;
                netPrice.value = computeNetPrice(base, discount, discount2.value, discount3.value, discount4.value);
            }
        });
        $('#discount2').on('change', function () {
            try {
                base = parseFloat($('#basePrice').val());
                discount = parseInt($(this).val());
                if (Number.isNaN(discount)) {
                    throw "NaN"
                }
                netPrice.value = computeNetPrice(base, discount1.value, discount, discount3.value, discount4.value);
            } catch (error) {
                console.log(error);
                base = parseFloat($('#basePrice').val());
                $(this).val(0);
                discount = 0;
                netPrice.value = computeNetPrice(base, discount1.value, discount, discount3.value, discount4.value);
            }
        });
        $('#discount3').on('change', function () {
            try {
                base = parseFloat($('#basePrice').val());
                discount = parseInt($(this).val());
                if (Number.isNaN(discount)) {
                    throw "NaN"
                }
                netPrice.value = computeNetPrice(base, discount1.value, discount2.value, discount, discount4.value);
            } catch (error) {
                base = parseFloat($('#basePrice').val());
                $(this).val(0);
                discount = 0;
                netPrice.value = computeNetPrice(base, discount1.value, discount2.value, discount, discount4.value);
            }
        });
        $('#discount4').on('change', function () {
            try {
                base = parseFloat($('#basePrice').val());
                discount = parseInt($(this).val());
                if (Number.isNaN(discount)) {
                    throw "NaN"
                }
                netPrice.value = computeNetPrice(base, discount1.value, discount2.value, discount3.value, discount);
            } catch (error) {
                base = parseFloat($('#basePrice').val());
                $(this).val(0);
                discount = 0;
                netPrice.value = computeNetPrice(base, discount1.value, discount2.value, discount3.value, discount);
            }
        });
    
    
    
    
        $('#vendorSelection').on('change', function () {
            myReceipt.setVendor($(this).val(), $('#vendorSelection option:selected').text());
            supplierName.innerHTML = $('#vendorSelection option:selected').text();
        });
    
    
        $('.input-group.date').datepicker().on('changeDate', function (e) {
            dateSelected = new Date(e.date);
            dateString = dateSelected.getFullYear() + "-" + minTwoDigits(dateSelected.getMonth() + 1) + "-" + minTwoDigits(dateSelected.getDate());
            myReceipt.tDate = dateString;
            $('#transactionDateView').html(dateString);
        })
    
    
    
        $('#addItemButton').click(function () {
            //validate first before submitting
            var tdate = dateString;
            var vid = $('#vendorSelection').val();
            var base = $('#basePrice').val();
            var itemno = $('#itemsSelection').val();
            var itemdesc = $('#itemsSelection option:selected').text();
            var d1 = discount1.value;
            var d2 = discount2.value;
            var d3 = discount3.value;
            var d4 = discount4.value;
            var net = netPrice.value;
            if ($(this).val() == "Add Item") {
                myReceipt.addItem(new Items(itemno, itemdesc, base, d1, d2, d3, d4, net));
                $('#itemListContainer').html(myReceipt.generate());
                myReceipt.setTotalNetPrice();
                $('#total-label').html(myReceipt.getTotalNetPrice());
            }else if($(this).val() == "Save"){
                myReceipt.updateItem(toUpdateIndex,new Items(itemno, itemdesc, base, d1, d2, d3, d4, net));
                $('#itemListContainer').html(myReceipt.generate());
                myReceipt.setTotalNetPrice();
                $('#total-label').html(myReceipt.getTotalNetPrice());
                toUpdateIndex = null;
                $('.control').prop('disabled',false);
                $(this).val('Add Item');
                $('tr.bg-info').toggleClass('table-info');


                $('#basePrice').val(0);
                netPrice.value = 0;
                $('#discount1').val(0);
                $('#discount2').val(0);
                $('#discount3').val(0);
                $('#discount4').val(0);
                toggleAddingControls(true);
            }
    
        });
    
        $('#submitButton').on('click',function() {
            if (myReceipt.getItems().length <= 0) {
                alert("No Items added. Please add a/an item/s to continue.");
            }else{
                //POST to PHP
                console.log(JSON.stringify(myReceipt));
                $.ajax({
                    url: base_url + '/notebook/new',
                    type: 'POST',
                    data:{
                        "_token": $('#token').val(),
                        "receipts":myReceipt,
                        "receiptId":ToUpdateReceiptIndex
                    },
                    success: function (result) {
                        var responseBody = result;
                        
                        if (responseBody.success) {
                            alert("Adding Notebook Entry successful.");
                            window.location.reload();
                        }
                    },
                    error: function (error) {
                        console.log(`Error: ${error}`);
                    }
                });
            }
        })
    
    
        $(document).on('click', ".deleteItem", function () {
            myReceipt.deleteItemByIndex($(this).attr('class').split(/\s+/)[2]);
            $('#itemListContainer').html(myReceipt.generate());
            myReceipt.setTotalNetPrice();
            $('#total-label').html(myReceipt.getTotalNetPrice());
        });
    
        $(document).on('click', ".editItem", function () {
            $('.control').prop('disabled', true);
            toggleAddingControls(false);
            toUpdateIndex = $(this).attr('class').split(/\s+/)[2];
            toUpdateItemNo = $(this).attr('class').split(/\s+/)[3];
            var item = myReceipt.getItemByIndex(toUpdateIndex);
            console.log(item);
            $('#itemsSelection').val(toUpdateItemNo);
            $('#basePrice').val(item.base);
            $('#discount1').val(parseInt(item.d1));
            $('#discount2').val(parseInt(item.d2));
            $('#discount3').val(parseInt(item.d3));
            $('#discount4').val(parseInt(item.d4));
            netPrice.value = item.netprice;
            $('#addItemButton').val("Save");
            $(this).parent().parent().toggleClass("table-primary");
        });
    
    
        $('#clearFieldsButton').on('click', function () {
            $('#basePrice').val(0);
            netPrice.value = 0;
            $('#discount1').val(0);
            $('#discount2').val(0);
            $('#discount3').val(0);
            $('#discount4').val(0);
            toggleAddingControls(true);
        });
    
    
        $('#clearButton').on('click',function() {
           myReceipt.clearItems();
           $('#itemListContainer').html(myReceipt.generate());
           myReceipt.setTotalNetPrice();
           $('#total-label').html(myReceipt.getTotalNetPrice());
        });
    
    
        function setDiscounts(index, basePriceElement, discountElement) {
            try {
                base = parseFloat(basePriceElement.val());
                discount = parseInt(discountElement.val());
                if (Number.isNaN(discount)) {
                    throw "NaN"
                }
                netPrice.value = computeNetPrice(base, discount1.value, discount2.value, discount3.value, discount);
            } catch (error) {
                base = parseFloat($('#basePrice').val());
                $(this).val(0);
                discount = 0;
                netPrice.value = computeNetPrice(base, discount1.value, discount2.value, discount3.value, discount);
            }
        }
    
        function generateHTMLVendors(array) {
            htmlString = "";
            vendors = array.vendors;
    
            // vendors.forEach(element => {
            //     htmlString = htmlString + `<option value="${element.vid}">${element.vendor}</option>`;    
            // });
            vendors.forEach(function (element, i) {
                if (i === 0) {
                    htmlString = htmlString + `<option selected value="${element.vid}">${element.vendor}</option>`;
                } else {
                    htmlString = htmlString + `<option value="${element.vid}">${element.vendor}</option>`;
                }
            });
    
            vendorSelection.innerHTML = htmlString;
        }
    
        function generateHTMLItems(array) {
            htmlString = "";
            items = array.items;
    
            items.forEach(element => {
                htmlString = htmlString + `<option value="${element.itemno}">${element.itemdesc}</option>`
            });
    
            itemsSelection.innerHTML = htmlString;
        }
    
    
        function computeNetPrice(base, d1, d2, d3, d4) {
            d1 = parseInt(d1);
            d2 = parseInt(d2);
            d3 = parseInt(d3);
            d4 = parseInt(d4);
            base = parseFloat(base);
            discounts = [d1, d2, d3, d4];
    
            net = base;
            discounts.forEach(element => {
                if (element != 0) {
                    net = net + (net * (element / 100))
                }
            });
    
            return net.toFixed(2);
        }
    
        function toggleAddingControls(toggle) {
            $('#discount1').prop('disabled', toggle);
            $('#discount2').prop('disabled', toggle);
            $('#discount3').prop('disabled', toggle);
            $('#discount4').prop('disabled', toggle);
            $('#addItemButton').prop('disabled',toggle);
        }        
    }


    function minTwoDigits(n) {
        return (n < 10 ? '0' : '') + n;
    }

    function validateFields() {
        //validate all fields before adding items    
    }

    function switchClass(oldClass,newClass,element) {
        element.removeClass(oldClass).addClass(newClass);
    }

    function parsePath(originalTransactionsPath,desiredPath) {
		var currentPath = window.location.pathname;
		toPath = desiredPath;
		if (currentPath.includes(originalTransactionsPath,0)) {
			var path = currentPath.replace(originalTransactionsPath,"");
			toPath = desiredPath + "/" + path;	
		}else{
			toPath = desiredPath;
		}

		return toPath;
	}

});	

