$(function() {

	Morris.Area({
		element : 'morris-area-chart',
		data : [ {
			period : '2010 Q1',
			網站訪問流量 : 2666,
			新註冊會員 : 11,
			新列登物品 : 2647
		}, {
			period : '2010 Q2',
			網站訪問流量 : 2778,
			新註冊會員 : 23,
			新列登物品 : 2441
		}, {
			period : '2010 Q3',
			網站訪問流量 : 4912,
			新註冊會員 : 45,
			新列登物品 : 2501
		}, {
			period : '2010 Q4',
			網站訪問流量 : 3767,
			新註冊會員 : 110,
			新列登物品 : 5689
		}, {
			period : '2011 Q1',
			網站訪問流量 : 6810,
			新註冊會員 : 25,
			新列登物品 : 2293
		}, {
			period : '2011 Q2',
			網站訪問流量 : 5670,
			新註冊會員 : 77,
			新列登物品 : 1881
		}, {
			period : '2011 Q3',
			網站訪問流量 : 4820,
			新註冊會員 : 123,
			新列登物品 : 1588
		}, {
			period : '2011 Q4',
			網站訪問流量 : 15073,
			新註冊會員 : 111,
			新列登物品 : 5175
		}, {
			period : '2012 Q1',
			網站訪問流量 : 10687,
			新註冊會員 : 333,
			新列登物品 : 2028
		}, {
			period : '2012 Q2',
			網站訪問流量 : 8432,
			新註冊會員 : 19,
			新列登物品 : 1791
		} ],
		xkey : 'period',
		ykeys : [ '網站訪問流量', '新註冊會員', '新列登物品' ],
		labels : [ '網站訪問流量', '新註冊會員', '新列登物品' ],
		pointSize : 5,
		hideHover : 'auto',
		resize : true
	});

	Morris.Donut({
		element : 'morris-donut-chart',
		data : [ {
			label : "今日成交",
			value : 12
		}, {
			label : "今日交互確認",
			value : 30
		}, {
			label : "今日違規",
			value : 2
		} ],
		resize : true
	});

	Morris.Bar({
		element : 'morris-bar-chart',
		data : [ {
			y : '2006',
			a : 100,
			b : 90
		}, {
			y : '2007',
			a : 75,
			b : 65
		}, {
			y : '2008',
			a : 50,
			b : 40
		}, {
			y : '2009',
			a : 75,
			b : 65
		}, {
			y : '2010',
			a : 50,
			b : 40
		}, {
			y : '2011',
			a : 75,
			b : 65
		}, {
			y : '2012',
			a : 100,
			b : 90
		} ],
		xkey : 'y',
		ykeys : [ 'a', 'b' ],
		labels : [ 'Series A', 'Series B' ],
		hideHover : 'auto',
		resize : true
	});

});
