<script type="text/javascript">
    function chartTotalTrafficDeviceByDate(data) {
        // Load Data
        var categories = [];
        // Phone array
        var phoneTitle = 'Phone';
        var phoneValue = [];
        var phoneChartType = 'line';
        // Tablet array
        var tabletTitle = 'Tablet';
        var tabletValue = [];
        var tabletChartType = 'line';
        // Desktop array
        var desktopTitle = 'Desktop';
        var desktopValue = [];
        var desktopChartType = 'line';

        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Thống kê truy cập thiết bị theo thời gian';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette2';
        var index = '0';
        var constValue = '0';
        jQuery.each(data.totalTrafficDeviceByDate, function( i, item ) {
          phoneValue.push(parseInt(data.totalTrafficDeviceByDate[i].phone));
          tabletValue.push(parseInt(data.totalTrafficDeviceByDate[i].tablet));
          desktopValue.push(parseInt(data.totalTrafficDeviceByDate[i].desktop));
          categories.push(data.totalTrafficDeviceByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: phoneTitle,
            type: phoneChartType,
            data: phoneValue
          },
          {
            name: tabletTitle,
            type: tabletChartType,
            data: tabletValue
          },
          {
            name: desktopTitle,
            type: desktopChartType,
            data: desktopValue
          },
        ],
          chart: {
          type: 'area',
          height: 500,
          zoom: {
            enabled: true
          },
          fontFamily: fontFamily,
          fontSize: fontSize,
        },
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        markers: {
          size: 1,
          hover: {
            sizeOffset: 6
          }
        },
        theme: {
          mode: 'light', 
          palette: palette, 
          monochrome: {
              enabled: false,
              color: '#255aee',
              shadeTo: 'light',
              shadeIntensity: 0.65
          },
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return abbreviateNumber(val)
          }
        },
        stroke: {
          show: true,
          width: 3,
          curve: 'smooth',
          lineCap: 'butt'
        },
        fill: {
          type: 'gradient',
          opacity: 1
        },
        legend: {
          show: true,
          position: 'bottom',
          horizontalAlign: 'center',
          tooltipHoverFormatter: function(val, opts) {
            pointValue = opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex];
            if(pointValue == 'undefined')
            {
              pointValue = '0';
            }
            return "<b>" + val + ' - ' + abbreviateNumber(pointValue) + '' + "</b>"
          }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '80%',
            borderRadius: 10,
            distributed: true,
            dataLabels: {
              position: 'center', // top, center, bottom
            },
          },
        },
        yaxis: [
          {
            labels: {
              formatter: function (val) {
                return abbreviateNumber(val)
              }
            },
          },
        ],
        xaxis: {
          categories: categories,
          labels: {
            style: {
              fontSize: xaxis_fontSize,
              fontWeight: xaxis_fontWeight,
            },
          }
        },
        title: {
          text: title_text,
          style: {
            fontSize:  title_fontSize,
            fontWeight:  title_fontWeight,
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return abbreviateNumber(val)
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chartTotalTrafficDeviceByDate"), options);
        chart.render(); 
    }
</script>