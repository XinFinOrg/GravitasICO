<script src="<?php echo e(URL::asset('control/vendors/flot-chart/jquery.flot.js')); ?>"></script>
<script src="<?php echo e(URL::asset('control/vendors/flot-chart/jquery.flot.categories.js')); ?>"></script>
<script src="<?php echo e(URL::asset('control/vendors/flot-chart/jquery.flot.pie.js')); ?>"></script>
<script src="<?php echo e(URL::asset('control/vendors/flot-chart/jquery.flot.tooltip.js')); ?>"></script>

<script src="<?php echo e(URL::asset('control/vendors/flot-chart/jquery.flot.fillbetween.js')); ?>"></script>
<script src="<?php echo e(URL::asset('control/vendors/flot-chart/jquery.flot.stack.js')); ?>"></script>
<script src="<?php echo e(URL::asset('control/vendors/flot-chart/jquery.flot.spline.js')); ?>"></script>
<!-- <script src="<?php echo e(URL::asset('control/vendors/calendar/zabuto_calendar.min.js')); ?>"></script>
 --><script src="<?php echo e(URL::asset('control/js/index.js')); ?>"></script>

<script src="<?php echo e(URL::asset('control/js/main.js')); ?>"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


<script type="text/javascript">
    Highcharts.chart('container', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Admin profit'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'datetime',
        dateTimeLabelFormats: { // don't display the dummy year
            month: '%e. %b',
            year: '%b'
        },
        title: {
            text: 'Date'
        }
    },
    yAxis: {
        title: {
            text: 'Value'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%e. %b}: {point.y:.8f} m'
    },

    plotOptions: {
        spline: {
            marker: {
                enabled: true
            }
        }
    },

    series: [{
        name: 'XDC',
        // Define the data points. All series have a dummy year
        // of 1970/71 in order to be compared on the same x axis. Note
        // that in JavaScript, months start at 0 for January, 1 for February etc.
        data: [
            <?php echo e(dasboard_chart_btc('XDC')); ?>

        ]
    }, {
        name: 'BTC',
        data: [
           <?php echo e(dasboard_chart_btc('BTC')); ?>

        ]
    }, {
        name: 'ETH',
        data: [
            <?php echo e(dasboard_chart_btc('ETH')); ?>

        ]
    },
    {
        name: 'XRP',
        data: [
             <?php echo e(dasboard_chart_btc('XRP')); ?>

        ]
    }]
});


  //BEGIN COUNTER FOR SUMMARY BOX
    
    
    
    function counterNum(obj, start, end, step, duration) {
        $(obj).html(start);
        setInterval(function(){
            var val = Number($(obj).html());
            if (val < end) {
                $(obj).html(val+step);
            } else {
                clearInterval();
            }
        },duration);
    }

</script>