$(document).ready(function () {
	$(".valueFormat").number(true, 2);
	var donut = new Morris.Donut({
      element: 'donut-chart',
      resize: true,
      colors: ["#3c8dbc", "#f56954", "#00a65a"],
      data: donutData,
      hideHover: 'auto'
    });
	
	
});