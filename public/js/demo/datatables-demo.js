// Call the dataTables jQuery plugin

$(document).ready(function () {

	var base_url = "http://localhost/RGMCS-Laravel/public";

	var defaultSelection = "RENES_ENCODER";

	var deviceCode = $('#deviceCode').html();

	var selectedReceipt;
	var stocksColumnDefs;
	var fromDate;
	var toDate;


	var stocksColumnDefsDefault = [
		{"width": "30%", "targets": [1,6]},
		{"className": "text-center", "targets": [0,1,2,3,4,5,6]},
		{"orderable":false,"targets":[4,5,6]},
		{ "width": "10%", "targets": [3,4,6] }
	];

	var stocksColumnDefsWarehouse = [
		{"width": "30%", "targets": [1,5]},
		{"className": "text-center", "targets": [0,1,2,3,4,5]},
		{"orderable":false,"targets":[4,5]},
		{ "width": "10%", "targets": [3,4,5] }
	];

	if (deviceCode == "WAREHOUSE_ENCODER") {
		stocksColumnDefs = stocksColumnDefsWarehouse;
	}else{
		stocksColumnDefs = stocksColumnDefsDefault;
	}


	if (parsePath("/RGMCS-Laravel/public/","") == "/notebook") {
		$('#receiptItemsTable').DataTable();
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

	$('#datepicker').datepicker({
		"format":"yyyy-mm-dd",
	});
	$("#datepicker").datepicker("setDate", new Date());

	$('#itemsTable').DataTable({
		"lengthMenu": [10, 25, 50, 75, 100],
		"pageLength": 50,
		"responsive": true,
		"processing": true,
		"order": [1, 'asc'],
		"serverSide": true,
		"columnDefs": [
			{"className":"text-center","targets":[0,1,2,3]},
			{"orderable":false,"targets":[3]}
		],
		"ajax": {
			url: (base_url + "/fetchitems"),
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		},
		"initComplete": function () {
			var input = $('.dataTables_filter input').unbind(),
				self = this.api(),
				$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
					.text('Search')
					.click(function () {
						self.search(input.val()).draw();
					}),
				$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
					.text('Reset')
					.click(function () {
						input.val('');
						$searchButton.click();
					})
			$('.dataTables_filter').append($searchButton, $clearButton);
		}
	});

	$('#vendorsTable').DataTable({
		"lengthMenu": [10, 25, 50, 75, 100],
		"pageLength": 10,
		"responsive": true,
		"processing": true,
		"order": [1, 'asc'],
		"serverSide": true,
		"columnDefs": [
			{"className":"text-center","targets":[0,1,2,3,4]},
			{"orderable":false,"targets":[4]}
		],
		"ajax": {
			url: (base_url + "/fetchvendors"),
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}, "initComplete": function () {
			var input = $('.dataTables_filter input').unbind(),
				self = this.api(),
				$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
					.text('Search')
					.click(function () {
						self.search(input.val()).draw();
					}),
				$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
					.text('Reset')
					.click(function () {
						input.val('');
						$searchButton.click();
					})
			$('.dataTables_filter').append($searchButton, $clearButton);
		}
	});

	$('#itemOverviewTable').DataTable({
		"lengthMenu": [10, 25, 50, 75, 100],
		"pageLength": 10,
		"responsive": true,
		"processing": true,
		"order": [1, 'asc'],
		"serverSide": true,
		"columnDefs": [
			{"className":"text-center","targets":[0,1,2,3,4]},
			{"orderable":false,"targets":[4]}
		],
		"ajax": {
			url: (base_url + "/fetchitemoverview"),
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}, "initComplete": function () {
			var input = $('.dataTables_filter input').unbind(),
				self = this.api(),
				$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
					.text('Search')
					.click(function () {
						self.search(input.val()).draw();
					}),
				$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
					.text('Reset')
					.click(function () {
						input.val('');
						$searchButton.click();
					})
			$('.dataTables_filter').append($searchButton, $clearButton);
		}
	});

	$('#cartOverViewTable').DataTable({
		"lengthMenu": [10, 25, 50, 75, 100],
		"pageLength": 10,
		"responsive": true,
		"processing": true,
		"order": [1, 'asc'],
		"serverSide": true,
		"ajax": {
			url: (base_url + "/fetchcartitems"),
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}, "initComplete": function () {
			var input = $('.dataTables_filter input').unbind(),
				self = this.api(),
				$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
					.text('Search')
					.click(function () {
						self.search(input.val()).draw();
					}),
				$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
					.text('Reset')
					.click(function () {
						input.val('');
						$searchButton.click();
					})
			$('.dataTables_filter').append($searchButton, $clearButton);
		}
	});

	$('#stocksOverviewTable').DataTable({
		"lengthMenu": [10, 25, 50, 75, 100],
		"pageLength": 10,
		"responsive": true,
		"processing": true,
		"order": [1, 'asc'],
		"serverSide": true,
		"columnDefs": stocksColumnDefs,
		"ajax": {
			url: (base_url + "/fetchstocks"),
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}, "initComplete": function () {
			var input = $('.dataTables_filter input').unbind(),
				self = this.api(),
				$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
					.text('Search')
					.click(function () {
						self.search(input.val()).draw();
					}),
				$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
					.text('Reset')
					.click(function () {
						input.val('');
						$searchButton.click();
					})
			$('.dataTables_filter').append($searchButton, $clearButton);
		}
	});

	var adminstocksOverviewTable;

	adminstocksOverviewTable = $('#adminstocksOverviewTable').DataTable({
		"lengthMenu": [10, 25, 50, 75, 100],
		"pageLength": 10,
		"responsive": true,
		"processing": true,
		"order": [1, 'asc'],
		"serverSide": true,
		"info":false,
		"columnDefs": [
			{"orderable":false , "targets":[3,4,5,6,7]},
			{ "width": "10%", "targets": [3,4,6] }
		],
		"ajax": {
			url: (base_url + "/fetchadminstocks"),
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataSrc:function (json) {
				console.log(json);
				
				return json.data;
			}
		}, 
		"initComplete": function () {
			var input = $('.dataTables_filter input').unbind(),
				self = this.api(),
				$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
					.text('Search')
					.click(function () {
						self.search(input.val()).draw();
					}),
				$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
					.text('Reset')
					.click(function () {
						input.val('');
						$searchButton.click();
					})
			$('.dataTables_filter').append($searchButton, $clearButton);
		}
	}).on('init.dt',function() {
	});



	$('#transactionsTable').DataTable({
		"lengthMenu": [10, 25, 50, 75, 100],
		"pageLength": 10,
		"responsive": true,
		"processing": true,
		"order": [[10, 'desc']],
		"serverSide": true,
		"columnDefs": [
			{ className: "costColumnContent", "targets": [5] },
			{"className": "text-center", "targets": [0,1,2,3,4,5,6,7,8,9,10]},
		],
		"ajax": {
			url: (base_url + parsePath("/RGMCS-Laravel/public/transaction/view/","/fetchtransactions")),
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}, "initComplete": function () {
			var input = $('.dataTables_filter input').unbind(),
				self = this.api(),
				$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
					.text('Search')
					.click(function () {
						self.search(input.val()).draw();
					}),
				$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
					.text('Reset')
					.click(function () {
						input.val('');
						$searchButton.click();
					})
			$('.dataTables_filter').append($searchButton, $clearButton);
		}
	});

	$('#admintransactionsTable').DataTable({
		"lengthMenu": [10, 25, 50, 75, 100],
		"pageLength": 10,
		"responsive": true,
		"processing": true,
		"order": [[10, 'desc']],
		"serverSide": true,
		"columnDefs": [
			{ className: "costColumnContent", "targets": [5] }
		],
		"ajax": {
			url: (base_url + parsePath("/RGMCS-Laravel/public/transaction/adminview/","/fetchadmintransactions")),
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:function ( d ) {
                d.selection = document.getElementById("deviceSelection").value;
            }
			// data:{
			// 	"selection":$('#deviceSelection').val(),
			// 	"url":base_url + parsePath("/RGMCS-Laravel/public/transaction/adminview/","/fetchadmintransactions")
			// }
		}, "initComplete": function () {
			var input = $('.dataTables_filter input').unbind(),
				self = this.api(),
				$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
					.text('Search')
					.click(function () {
						self.search(input.val()).draw();
					}),
				$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
					.text('Reset')
					.click(function () {
						input.val('');
						$searchButton.click();
					})
			$('.dataTables_filter').append($searchButton, $clearButton);
		}
	});



	$('#admintransactionsTable').on('init.dt',function() {
		if ($('#deviceSelection').length) {
			$('#deviceSelection').change(function() {
				defaultSelection = this.value;
				$('#admintransactionsTable').DataTable().ajax.reload();
			});
		}	
	});


	var receiptItemsTable;
	var receiptItemsOverviewTable;
	$.ajax({
		"method":"GET",
		"url": (base_url + "/receipt-info/ranges"),
		"success":function(result) {
			resultObject = JSON.parse(result);

			fromDateString = resultObject.from;
			toDateString = resultObject.to;

			fromDate = new Date(fromDateString);
			toDate = new Date(toDateString);

			$('.input-daterange').datepicker({
				"format":"yyyy-mm-dd"
			});
		
			$('.input-daterange input').each(function(index) {
				if (index == 0) {
					$(this).datepicker('setDate',fromDate);
					$(this).datepicker().on('changeDate',function(e) {
						fromDateString = formatDate(e.date);
						$('#receiptsTable').DataTable().ajax.reload();
						$('#receiptItemsOverviewTable').DataTable().ajax.reload();
					});
				}else{
					$(this).datepicker('setDate',toDate);
					$(this).datepicker().on('changeDate',function(e) {
						toDateString = formatDate(e.date);
						$('#receiptsTable').DataTable().ajax.reload();
						$('#receiptItemsOverviewTable').DataTable().ajax.reload();
					});
				}
			});

			var receiptsTable = $('#receiptsTable').DataTable({
				"lengthMenu": [10, 25, 50, 75, 100],
				"pageLength": 10,
				"responsive": true,
				"processing": true,
				"serverSide": true,
				"columnDefs": [
					{"className": "text-center", "targets": [0,1,2,3]}
				],
				"ajax": {
					// url: (base_url + parsePath("/RGMCS-Laravel/public/transaction/view/","/fetchtransactions")),
					url: (base_url + "/fetchreceipts"),
					type: "post",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data:function ( d ) {
						d.fromDate = fromDateString;
						d.toDate = toDateString;
					}
				}, 
				"initComplete": function () {
					var input = $('.dataTables_filter input').unbind(),
						self = this.api(),
						$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
							.text('Search')
							.click(function () {
								self.search(input.val()).draw();
							}),
						$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
							.text('Reset')
							.click(function () {
								input.val('');
								$searchButton.click();
							})
					$('.dataTables_filter').append($searchButton, $clearButton);
		
		
				}
			}).on('init.dt',function() {
				receiptItemsTable = $('#receiptItemsTable').DataTable({
					"searching":false,
					"paging":false,
					"info":false,
					"columnDefs": [
						{"className": "text-center", "targets": [0,1,2,3,4,5,6]},
						{"width":"5%","targets":[2,3,4,5]},
						// {"width":"15%","targets":[6]},
						// {"width":"15%","targets":[1]}
		
					]
				});
		
				receiptItemsOverviewTable = $('#receiptItemsOverviewTable').DataTable({
					"lengthMenu": [10, 25, 50, 75, 100],
					"pageLength": 10,
					"responsive": true,
					"processing": true,
					"serverSide": true,
					"columnDefs": [
						{"className": "text-center", "targets": [0,1,2,3,10]},
						{"width":"5%","targets":[1]}
					],
					"ajax": {
						// url: (base_url + parsePath("/RGMCS-Laravel/public/transaction/view/","/fetchtransactions")),
						url: (base_url + "/fetchreceiptitemsoverview"),
						type: "post",
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data:function ( d ) {
							d.fromDate = fromDateString;
							d.toDate = toDateString;
						}
					}, "initComplete": function () {
						var input = $('#receiptItemsOverviewTable_filter input').unbind(),
							self = this.api(),
							$searchButton = $('<button class="btn btn-primary btn-sm ml-1">')
								.text('Search')
								.click(function () {
									self.search(input.val()).draw();
								}),
							$clearButton = $('<button class="btn btn-danger btn-sm ml-1">')
								.text('Reset')
								.click(function () {
									input.val('');
									$searchButton.click();
								})
						$('#receiptItemsOverviewTable_filter').append($searchButton, $clearButton);
					}
				}).on('draw.dt',function() {
					$('.receipt-items-edit').on('click',function() {
						var receipt_item_no = $(this).attr('value');
						var receipt_no = $(this).attr('receipt-no');
						$.ajax({
							"method":"GET",
							"url": (base_url + "/receipt-item"),
							"data":{
								"receipt_item_no":receipt_item_no
							},
							"success":function(result) {
								resultObject = JSON.parse(result);
								$.ajax({
									"method":"GET",
									"url": (base_url + "/items/options"),
									"data":{
										"itemno":resultObject.itemno
									},
									"success":function(result) {
										resultString = JSON.parse(result);
										
										$('#receiptId.modal-field').val(receipt_no);
										$('#receiptItemNo.modal-field').val(receipt_item_no);
										$('#itemsSelection.modal-field').html(resultString.optionsString);
										$('#basePrice.modal-field').val(resultObject.baseprice);
										$('#discount1.modal-field').val(resultObject.d1);
										$('#discount2.modal-field').val(resultObject.d2);
										$('#discount3.modal-field').val(resultObject.d3);
										$('#discount4.modal-field').val(resultObject.d4);
										$('#netPrice.modal-field').val(resultObject.netprice);

										var currentBasePrice = resultObject.baseprice;
										var currentD1 = resultObject.d1;
										var currentD2 = resultObject.d2;
										var currentD3 = resultObject.d3;
										var currentD4 = resultObject.d4;
										var currentNetPrice = resultObject.netprice;


										var showComputed = function() {
											$('#netPrice.modal-field').val(computeNetPrice(
												currentBasePrice,
												currentD1,
												currentD2,
												currentD3,
												currentD4,
											));
										}

										$('#basePrice.modal-field').on('change',function() {
											currentBasePrice = $(this).val();
											showComputed();
										});
										$('#discount1.modal-field').on('change',function() {
											currentD1 = $(this).val();
											showComputed();
										});
										$('#discount2.modal-field').on('change',function() {
											currentD2 = $(this).val();
											showComputed();
										});
										$('#discount3.modal-field').on('change',function() {
											currentD3 = $(this).val();
											showComputed();
										});
										$('#discount4.modal-field').on('change',function() {
											currentD4 = $(this).val();
											showComputed();
										});

									}
								});
							}
						});
					});
				});
			}).on('click','tr', function() {
		
				if ($(this).hasClass('table-primary')) {
					$(this).removeClass('table-primary');
				}else{
					receiptsTable.$('tr.table-primary').removeClass('table-primary');
					$(this).toggleClass('table-primary');
				}
				
				if (receiptsTable.$('tr.table-primary').length == 0) {
					console.log("Nothing is Selected");
				} else {
					console.log("Something is Selected");
				}
				
				selectedRow = receiptsTable.row(this).data();
		
				$.ajax({
					"method":"GET",
					"url": (base_url + "/notebook/view/receipt"),
					"data":{
						"receipt_no":selectedRow[0]
					},
					"success":function(result) {
						resultObject = JSON.parse(result);
		
						receipt = resultObject.receipt;
						receiptItems = resultObject.receipt_items;
						receiptItemsTable.clear().draw();
						$('#supplierName').html(receipt.vendor);
						$('#transactionDateView').html(receipt.tdate);
						$('#total-label').html(receipt.total);
						receiptItems.forEach(item => {
							receiptItemsTable.row.add([
								item.itemdesc,
								item.baseprice,
								item.d1,
								item.d2,
								item.d3,
								item.d4,
								item.netprice
							]).draw(false);
						});
					}
				});
		
			});
		}
	});






	$('#vendorsTable').on('init.dt',function() {
		$('#vendorBinTable').DataTable({
			"paging": false,
			"searching": false,
			"info": false,
			"responsive": true,
			"processing": true,
			"ordering": true,
			"order": [2, 'desc'],
			"serverSide": true,
			"ajax": {
				url: (base_url + "/fetchvendorbin"),
				type: "post",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}
		});
	});



	$('#itemsTable').on('init.dt',function() {
		$('#itemBinTable').DataTable({
			"paging": false,
			"searching": false,
			"info": false,
			"responsive": true,
			"processing": true,
			"ordering": true,
			"order": [1, 'desc'],
			"serverSide": true,
			"ajax": {
				url: (base_url + "/fetchitembin"),
				type: "post",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}
		});
	});


	function formatDate(date) {
		return date.getFullYear() + "-" +  (date.getMonth() + 1) + "-" + date.getDate()
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
				net = net - (net * (element / 100))
			}
		});

		return net.toFixed(2);
	}





});	