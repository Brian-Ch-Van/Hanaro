
	<!-- Begin page content -->
	<main role="main" class="flex-shrink-0">
		<div class="container">
		
			<h2 class="mt-4" style="font-weight: bold;">Home</h2>
			<div class="card-deck mb-3 text-center">
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">Coquitlam</h4>
					</div>
					<div class="card-body" >
						<div id="cqChart"></div>
						<button type="button" class="btn btn-lg btn-block btn-outline-primary">Details</button>
					</div>
				</div>
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">Downtown</h4>
					</div>
					<div class="card-body">
						<div id="dnChart"></div>
						<button type="button" class="btn btn-lg btn-block btn-primary">Details</button>
					</div>
				</div>
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">Langley</h4>
					</div>
					<div class="card-body">
						<div id="llChart"></div>
						<button type="button" class="btn btn-lg btn-block btn-primary">Details</button>
					</div>
				</div>
			</div>
			
			<div class="card-deck mb-3 text-center">
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">Richmond</h4>
					</div>
					<div class="card-body">
						<div id="rmChart"></div>
						<button type="button" class="btn btn-lg btn-block btn-outline-primary">Details</button>
					</div>
				</div>
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">Port Coquitlam</h4>
					</div>
					<div class="card-body">
						<div id="pcChart"></div>
						<button type="button" class="btn btn-lg btn-block btn-primary">Details</button>
					</div>
				</div>
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">Dunbar</h4>
					</div>
					<div class="card-body">
						<div id="dbChart"></div>
						<button type="button" class="btn btn-lg btn-block btn-primary">Details</button>
					</div>
				</div>
			</div>

			<div class="card-deck mb-3 text-center">
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">UBC</h4>
					</div>
					<div class="card-body">
						<div id="ubChart"></div>
						<button type="button" class="btn btn-lg btn-block btn-outline-primary">Details</button>
					</div>
				</div>
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">TBD</h4>
					</div>
					<div class="card-body">
						<h1 class="card-title pricing-card-title"><small class="text-muted">Unused</small></h1>
						<ul class="list-unstyled mt-3 mb-4">
							<li>Comming soon</li>
						</ul>
					</div>
				</div>
				<div class="card mb-4 shadow-sm">
					<div class="card-header">
						<h4 class="my-0 font-weight-normal">TBD</h4>
					</div>
					<div class="card-body">
						<h1 class="card-title pricing-card-title"><small class="text-muted">Unused</small></h1>
						<ul class="list-unstyled mt-3 mb-4">
							<li>Comming soon</li>
						</ul>
					</div>
				</div>
			</div>

		</div>
	</main>

<script>
	
	// chart - test
	var cqChart = bb.generate({
		size: {
			height: 200
			//width: 900
		},
	    data: {
			x: "x",
			xFormat: "%m-%d",
	      	columns: [
	  			["x", "09-01", "09-02", "09-03", "09-04", "09-05", "09-06"],
	  			//["data1", 30, 200, 100, 400, 150, 250],
	  			["코퀴틀람" <?php foreach ($sales_amt as $row) { if($row['br_cd'] == 'CQ01') echo ",". $row['sales_amt']; }?>]
	      	],
	      	labels: true,
// 	      	labels: {
// 				colors: "white",
// 				centered: true
// 		    }
	    },
	    axis: {
			x: {
	        	type: "timeseries",
	        	localtime: false,
	        	tick: {
	          		format: "%m-%d"
	        	}
			},
			/*
			y: {
				label: {
					text: "$, K",
					position: "outer-middle"
				}
			}
			*/
	    },
	    bar: {
		    padding: 4
		},
	    bindto: "#cqChart"
	});

	var dnChart = bb.generate({
		size: {
			height: 200
			//width: 900
		},
	    data: {
			x: "x",
			xFormat: "%m-%d",
	      	columns: [
	  			["x", "09-01", "09-02", "09-03", "09-04", "09-05", "09-06"],
	  			//["data1", 30, 200, 100, 400, 150, 250],
	  			["다운타운" <?php foreach ($sales_amt as $row) { if($row['br_cd'] == 'DN01') echo ",". $row['sales_amt']; }?>]
	      	],
	      	labels: true,
// 	      	labels: {
// 				colors: "white",
// 				centered: true
// 		    }
	    },
	    axis: {
			x: {
	        	type: "timeseries",
	        	localtime: false,
	        	tick: {
	          		format: "%m-%d"
	        	}
			},
	    },
	    bar: {
		    padding: 4
		},
	    bindto: "#dnChart"
	});	

	var llChart = bb.generate({
		size: {
			height: 200
			//width: 900
		},
	    data: {
			x: "x",
			xFormat: "%m-%d",
	      	columns: [
	  			["x", "09-01", "09-02", "09-03", "09-04", "09-05", "09-06"],
	  			//["data1", 30, 200, 100, 400, 150, 250],
	  			["랭리" <?php foreach ($sales_amt as $row) { if($row['br_cd'] == 'LL01') echo ",". $row['sales_amt']; }?>]
	      	],
	      	labels: true,
// 	      	labels: {
// 				colors: "white",
// 				centered: true
// 		    }
	    },
	    axis: {
			x: {
	        	type: "timeseries",
	        	localtime: false,
	        	tick: {
	          		format: "%m-%d"
	        	}
			},
	    },
	    bar: {
		    padding: 4
		},
	    bindto: "#llChart"
	});	

	var rmChart = bb.generate({
		size: {
			height: 200
			//width: 900
		},
	    data: {
			x: "x",
			xFormat: "%m-%d",
	      	columns: [
	  			["x", "09-01", "09-02", "09-03", "09-04", "09-05", "09-06"],
	  			//["data1", 30, 200, 100, 400, 150, 250],
	  			["리치몬드" <?php foreach ($sales_amt as $row) { if($row['br_cd'] == 'RM01') echo ",". $row['sales_amt']; }?>]
	      	],
	      	labels: true,
// 	      	labels: {
// 				colors: "white",
// 				centered: true
// 		    }
	    },
	    axis: {
			x: {
	        	type: "timeseries",
	        	localtime: false,
	        	tick: {
	          		format: "%m-%d"
	        	}
			},
	    },
	    bar: {
		    padding: 4
		},
	    bindto: "#rmChart"
	});	

	var pcChart = bb.generate({
		size: {
			height: 200
			//width: 900
		},
	    data: {
			x: "x",
			xFormat: "%m-%d",
	      	columns: [
	  			["x", "09-01", "09-02", "09-03", "09-04", "09-05", "09-06"],
	  			//["data1", 30, 200, 100, 400, 150, 250],
	  			["포트코퀴틀람" <?php foreach ($sales_amt as $row) { if($row['br_cd'] == 'PC01') echo ",". $row['sales_amt']; }?>]
	      	],
	      	labels: true,
// 	      	labels: {
// 				colors: "white",
// 				centered: true
// 		    }
	    },
	    axis: {
			x: {
	        	type: "timeseries",
	        	localtime: false,
	        	tick: {
	          		format: "%m-%d"
	        	}
			},
	    },
	    bar: {
		    padding: 4
		},
	    bindto: "#pcChart"
	});

	var dbChart = bb.generate({
		size: {
			height: 200
			//width: 900
		},
	    data: {
			x: "x",
			xFormat: "%m-%d",
	      	columns: [
	  			["x", "09-01", "09-02", "09-03", "09-04", "09-05", "09-06"],
	  			//["data1", 30, 200, 100, 400, 150, 250],
	  			["던바" <?php foreach ($sales_amt as $row) { if($row['br_cd'] == 'DB01') echo ",". $row['sales_amt']; }?>]
	      	],
	      	labels: true,
// 	      	labels: {
// 				colors: "white",
// 				centered: true
// 		    }
	    },
	    axis: {
			x: {
	        	type: "timeseries",
	        	localtime: false,
	        	tick: {
	          		format: "%m-%d"
	        	}
			},
	    },
	    bar: {
		    padding: 4
		},
	    bindto: "#dbChart"
	});	

	var ubChart = bb.generate({
		size: {
			height: 200
			//width: 900
		},
	    data: {
			x: "x",
			xFormat: "%m-%d",
	      	columns: [
	  			["x", "09-01", "09-02", "09-03", "09-04", "09-05", "09-06"],
	  			//["data1", 30, 200, 100, 400, 150, 250],
	  			["UBC" <?php foreach ($sales_amt as $row) { if($row['br_cd'] == 'UB01') echo ",". $row['sales_amt']; }?>]
	      	],
	      	labels: true,
// 	      	labels: {
// 				colors: "white",
// 				centered: true
// 		    }
	    },
	    axis: {
			x: {
	        	type: "timeseries",
	        	localtime: false,
	        	tick: {
	          		format: "%m-%d"
	        	}
			},
	    },
	    bar: {
		    padding: 4
		},
	    bindto: "#ubChart"
	});		
		
	// chart timeout
	/*
	setTimeout(function() {
		chart.load({
	  		columns: [
	  		  ["던바" <?php foreach ($sales_amt as $row) { if($row['br_cd'] == 'DB01') echo ",". $row['sales_amt']; }?>]
	  		]
	  	});
	}, 500);
	*/

</script>	


