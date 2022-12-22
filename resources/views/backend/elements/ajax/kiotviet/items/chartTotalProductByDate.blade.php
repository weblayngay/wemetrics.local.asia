<script type="text/javascript">
    function chartTotalProductByDate(data) {
        // Load Data
        var categories = [];
        // Tiền hàng
        var productAmountTitle = 'Tiền hàng';
        var productAmountValue = [];
        var productAmountChartType = 'line';
        // Số lượng
        var productQuantityTitle = 'Số lượng';
        var productQuantityValue = [];
        var productQuantityChartType = 'line';

        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Phát sinh mặt hàng theo thời gian';
        var name_amount = 'Tiền hàng'
        var name_quantity = 'Số lượng';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette2';
        var adgroup = data.adgroup;
        jQuery.each(data.totalProductByDate, function( i, item ) {
          if(adgroup == 1)
          {
            productAmountValue.push(parseInt(data.totalProductByDate[i].subTotal));
          }
          else
          {
            productAmountValue.push(0);
          }
          productQuantityValue.push(parseInt(data.totalProductByDate[i].quantity));
          categories.push(data.totalProductByDate[i].purchaseDate);
          productName = data.totalProductByDate[i].productName;
          title_text = 'Phát sinh mặt hàng ' + productName + ' theo thời gian'
        });
        var options = {
          series: [
          {
            name: productQuantityTitle,
            type: productQuantityChartType,
            data: productQuantityValue
          },
          {
            name: productAmountTitle,
            type: productAmountChartType,
            data: productAmountValue
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
              text: name_quantity,
            },
            labels: {
              formatter: function (val) {
                return abbreviateNumber(Math.round(val))
              }
            },
          },
          {
          opposite: true,
          title: 
            {
              text: name_amount,
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

        var chart = new ApexCharts(document.querySelector("#chartTotalProductByDate"), options);
        chart.render(); 
    }
</script>