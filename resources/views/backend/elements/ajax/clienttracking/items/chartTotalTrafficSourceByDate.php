<script type="text/javascript">
    function chartTotalTrafficSourceByDate(data) {
        // Load Data
        var categories = [];
        // Direct array
        var directTitle = 'Direct';
        var directValue = [];
        var directChartType = 'area';
        // Google Search array
        var googleSearchTitle = 'Google Search';
        var googleSearchValue = [];
        var googleSearchChartType = 'line';
        // Fb Messenger array
        var fbMessengerTitle = 'Fb Messenger';
        var fbMessengerValue = [];
        var fbMessengerChartType = 'line';
        // Fb Post array
        var fbPostTitle = 'Fb Post';
        var fbPostValue = [];
        var fbPostChartType = 'line';
        // Zalo Messenger array
        var zaloMessengerTitle = 'Zalo Messenger';
        var zaloMessengerValue = [];
        var zaloMessengerChartType = 'line';
        // Referral array
        var referralTitle = 'Referral';
        var referralValue = [];
        var referralChartType = 'line';

        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Thống kê truy cập nguồn theo thời gian';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette1';
        var index = '0';
        var constValue = '0';
        jQuery.each(data.totalTrafficSourceByDate, function( i, item ) {
          directValue.push(parseInt(data.totalTrafficSourceByDate[i].direct));
          googleSearchValue.push(parseInt(data.totalTrafficSourceByDate[i].google_search));
          fbMessengerValue.push(parseInt(data.totalTrafficSourceByDate[i].facebook_messenger));
          fbPostValue.push(parseInt(data.totalTrafficSourceByDate[i].facebook_post));
          zaloMessengerValue.push(parseInt(data.totalTrafficSourceByDate[i].zalo_messenger));
          referralValue.push(parseInt(data.totalTrafficSourceByDate[i].referral));
          index = jQuery.inArray(data.totalTrafficSourceByDate[i].created_at, categories);
          if(index == '-1')
          {
            categories.push(data.totalTrafficSourceByDate[i].created_at);
          }
        });
        var options = {
          series: [
          {
            name: directTitle,
            type: directChartType,
            data: directValue
          },
          {
            name: googleSearchTitle,
            type: googleSearchChartType,
            data: googleSearchValue
          },
          {
            name: fbMessengerTitle,
            type: fbMessengerChartType,
            data: fbMessengerValue
          },
          {
            name: fbPostTitle,
            type: fbPostChartType,
            data: fbPostValue
          },
          {
            name: zaloMessengerTitle,
            type: zaloMessengerChartType,
            data: zaloMessengerValue
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

        var chart = new ApexCharts(document.querySelector("#chartTotalTrafficSourceByDate"), options);
        chart.render(); 
    }
</script>