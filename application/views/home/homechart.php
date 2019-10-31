
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
						<!-- 여기에 chart 삽입 test
						<h1 class="card-title pricing-card-title">0 <small class="text-muted">/ mo</small></h1>
						<ul class="list-unstyled mt-3 mb-4">
							<li>10 users included</li>
							<li>2 GB of storage</li>
							<li>Email support</li>
							<li>Help center access</li>
						</ul>
						 -->
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

<!--  document loading 후에 실행되어야 되기 때문에 script 여기로 -->
<script>
	
	// Chart type 변경
	function chType(val){
		chart.transform(val);
	}

	// time series chart
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

	// time series chart
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
	    bindto: "#dnChart"
	});	

	// time series chart
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
	    bindto: "#llChart"
	});	

	// time series chart
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
	    bindto: "#rmChart"
	});	

	// time series chart
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
	    bindto: "#pcChart"
	});

	// time series chart
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
	    bindto: "#dbChart"
	});	

	// time series chart
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
	    bindto: "#ubChart"
	});		
		
	// 추가 chart timeout
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


