<script type="text/javascript">
    function chartTotalCustomerByDate(data) {
        // Load Data
        var categories = [];
        // New customer
        var customerNewTitle = 'Khách mới';
        var customerNewValue = [];
        var customerNewChartType = 'line';
        // Loayalty customer
        var customerLoyaltyTitle = 'Khách quay lại';
        var customerLoyaltyValue = [];
        var customerLoyaltyChartType = 'line';

        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Phát sinh khách hàng theo thời gian';
        var name_customerNew = 'Khách mới';
        var name_customerLoyalty = 'Khách quay lại';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette2';
        jQuery.each(data.totalCustomerByDate, function( i, item ) {
          customerNewValue.push(parseInt(data.totalCustomerByDate[i].totalCustomerNew));
          customerLoyaltyValue.push(parseInt(data.totalCustomerByDate[i].totalCustomerLoyalty));
          categories.push(data.totalCustomerByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: customerNewTitle,
            type: customerNewChartType,
            data: customerNewValue
          },
          {
            name: customerLoyaltyTitle,
            type: customerLoyaltyChartType,
            data: customerLoyaltyValue
          },
        ],
          chart: {
          type: 'area',
          height: 500,
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
          size: 1
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
          width: 2,
          curve: 'smooth'
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
            title: {
              text: name_customerNew,
            },
            labels: {
              formatter: function (val) {
                return abbreviateNumber(val)
              }
            },
          },
          {
          opposite: true,
          title: 
            {
              text: name_customerLoyalty,
            },
            labels: {
              formatter: function (val) {
                return abbreviateNumber(val)
              }
            },
          }
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

        var chart = new ApexCharts(document.querySelector("#chartTotalCustomerByDate"), options);
        chart.render(); 
    }
</script>