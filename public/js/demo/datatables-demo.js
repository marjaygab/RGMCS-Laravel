// Call the dataTables jQuery plugin

$(document).ready(function () {

	var base_url = "http://localhost/RGMCS-Laravel/public";

	
	var originalTransactionsPath = "/RGMCS-Laravel/public/transaction/view/";
	var currentPath = window.location.pathname;

	if (currentPath.includes(originalTransactionsPath,0)) {
		var itemNo = currentPath.replace(originalTransactionsPath,"");
		transactionsURL = "/fetchtransactions/" + itemNo;	
	}else{
		transactionsURL = "/fetchtransactions";	
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
		"ajax": {
			url: (base_url + "/fetchcartitems"),
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



	$('#transactionsTable').DataTable({
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
			url: (base_url + transactionsURL),
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





});	