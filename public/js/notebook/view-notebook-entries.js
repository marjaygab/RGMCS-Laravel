$(document).ready(function() {

    var itemsSelection = document.getElementById("itemsSelection");
    var supplierName = document.getElementById('supplierName');
    var transactionDateView = document.getElementById('transactionDateView');
    var vendors = [];
    var myReceipt;
    var table;
    var selectedRid = null;
    var base_url = "http://rgmcs-laravel.test";


    var toUpdateIndex = null;

    $('.input-group.date').datepicker({
        orientation: "bottom"
    });

    $('.input-group.date').datepicker("setDate", new Date);

    toggleAddingControls(true);
    var dateSelected = new Date();
    var dateString = dateSelected.getFullYear() + "-" + minTwoDigits(dateSelected.getMonth() + 1) + "-" + minTwoDigits(dateSelected.getDate());
    $('#transactionDateView').html(dateString);
    $('#receiptColumn').hide();
    $('#placeholderColumn').show();
    $('#fromDate').datepicker('setEndDate', $('#toDate').datepicker('getDate'));
    $('#toDate').datepicker('setStartDate', $('#fromDate').datepicker('getDate'));



    $.ajax({
        url: base_url + '/getAllVendors.php',
        type: 'GET',
        success: function(result) {
            result.vendors.forEach(function(value, i) {
                vendors.push({ vid: value.vid, vendor: value.vendor });

            });
            generateHTMLVendors(result);
            $.ajax({
                url: base_url + 'getReceipts.php',
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    // response = JSON.parse(result);
                    receipts = result.receipts;

                    if (receipts.length > 0) {
                        var dates = [];
                        receipts.forEach(function(value, i) {
                            dates.push({ dateString: value.tdate, dateValue: Date.parse(value.tdate) });
                        });
                        var result = dates.sort(function(a, b) {
                            return a.dateValue - b.dateValue;
                        });

                        $('#fromDate').datepicker('setDate', new Date(result[0].dateValue));
                        $('#toDate').datepicker('setDate', new Date(result[result.length - 1].dateValue));
                        $('#fromDate').datepicker('setEndDate', new Date(result[result.length - 1].dateValue));
                        $('#toDate').datepicker('setStartDate', new Date(result[0].dateValue));
                    } else {
                        $('#fromDate').prop('disabled', true);
                        $('#toDate').prop('disabled', true);
                    }

                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var minDate = Date.parse($('#fromDate').datepicker('getDate'));
                            var maxDate = Date.parse($('#toDate').datepicker('getDate'));
                            var tdate = Date.parse(data[2]);
                            console.log("Testing");
                            if ((tdate >= minDate) && (tdate <= maxDate)) {
                                return true;
                            }
                            return false;
                        }
                    );
                    $('#receiptsRows').html(generateReceiptHTML(receipts));
                    table = $('#dataTables-example').DataTable({
                        responsive: true,
                        searching: false,
                        hover: false,
                        paging: true
                    });



                    $('#fromDate').datepicker().on('changeDate', function() {
                        $('#toDate').datepicker('setStartDate', $(this).datepicker('getDate'));
                        // var minDate = Date.parse($(this).datepicker('getDate'));
                        // var maxDate = Date.parse($('#toDate').datepicker('getDate'));
                        // var result = receipts.filter(r => (Date.parse(r.tdate) >= minDate) && (Date.parse(r.tdate) <= maxDate));
                        // $('#receiptsRows').html(generateReceiptHTML(result));
                        table.draw();
                    });

                    $('#toDate').datepicker().on('changeDate', function() {
                        $('#fromDate').datepicker('setEndDate', $('#toDate').datepicker('getDate'));
                        // var minDate = Date.parse($('#fromDate').datepicker('getDate'));
                        // var maxDate = Date.parse($(this).datepicker('getDate'));
                        // var result = receipts.filter(r => (Date.parse(r.tdate) >= minDate) && (Date.parse(r.tdate) <= maxDate));
                        // $('#receiptsRows').html(generateReceiptHTML(result));
                        table.draw();
                    });

                },
                error: function(error) {
                    console.log(`Error: ${error}`);
                }
            });
        },
        error: function(error) {
            console.log(`Error: ${error}`);
        }
    });

    $(document).on('click', ".receiptsSelect", function() {
        selectedRid = $(this).attr('class').split(/\s+/)[1];
        $('tr.bg-info').toggleClass("bg-info");
        $(this).parent().parent().toggleClass("bg-info");
        if (selectedRid != null) {
            $.ajax({
                url: base_url + 'getAllReceiptItems.php',
                type: 'GET',
                data: {
                    "rid": selectedRid
                },
                success: function(result) {
                    receiptItems = result.receiptitems;

                    if (receiptItems.length > 0) {
                        $('#receiptColumn').show();
                        $('#placeholderColumn').hide();

                        var myReceipt = new Receipt(
                            new Date(receiptItems[0].tdate),
                            receiptItems[0].vid,
                            receiptItems[0].vendor
                        );

                        $('#transactionDateView').html(receiptItems[0].tdate);
                        $('#supplierName').html(receiptItems[0].vendor);

                        receiptItems.forEach(function(value, i) {
                            myReceipt.addItem(new Items(value.itemno, value.itemdesc, value.baseprice, value.d1, value.d2,
                                value.d3, value.d4, value.netprice));
                        });

                        myReceipt.setTotalNetPrice();
                        $('#total-label').html(myReceipt.getTotalNetPrice());
                        $('#itemListContainer').html(myReceipt.generate(true));
                    } else {
                        $('#receiptColumn').hide();
                        $('#placeholderColumn').show();
                    }
                },
                error: function(error) {
                    console.log(`Error: ${error}`);
                }
            });


        }
    });




    $('#vendorSelection').on('change', function() {
        myReceipt.setVendor($(this).val(), $('#vendorSelection option:selected').text());
        supplierName.innerHTML = $('#vendorSelection option:selected').text();
    });


    function generateHTMLVendors(array) {
        htmlString = `<option disabled selected value> --Select a Vendor-- </option>`;
        vendors = array.vendors;
        vendors.forEach(function(element, i) {
            if (i === 0) {
                htmlString = htmlString + `<option value="${element.vid}">${element.vendor}</option>`;
            } else {
                htmlString = htmlString + `<option value="${element.vid}">${element.vendor}</option>`;
            }
        });


        $('#vendorSelection').html(htmlString);
    }

    function toggleAddingControls(toggle) {
        $('#discount1').prop('disabled', toggle);
        $('#discount2').prop('disabled', toggle);
        $('#discount3').prop('disabled', toggle);
        $('#discount4').prop('disabled', toggle);
        $('#addItemButton').prop('disabled', toggle);
    }

    function minTwoDigits(n) {
        return (n < 10 ? '0' : '') + n;
    }

    function validateFields() {
        //validate all fields before adding items    
    }

    function switchClass(oldClass, newClass, element) {
        element.removeClass(oldClass).addClass(newClass);
    }

    function generateReceiptHTML(items) {
        $html = "";


        items.forEach(function(value, i) {
            var vendorName = vendors.find(v => v.vid == value.vid);
            $html = $html + `<tr>
           <td class="text-center"><a href="#" class="receiptsSelect ${value.id}">${value.tdate}</a></td>
           <td class="text-center">${vendorName.vendor}</td>
           <td class="text-center">${value.total}</td>
       </tr>`;
        });

        return $html;
    }

});