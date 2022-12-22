<script type="text/javascript">
    function chartTotalCateProductByDate(data) {
        // Load Data
        var categories = [];
        //
        var productCateTitle = 'Nhóm hàng';
        var productCateValue = [];
        var productCateChartType = 'line';
        //
        var productCateQuantity = 0;
        //
        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Phát sinh nhóm hàng theo thời gian';
        var name_quantity = 'Tiền hàng';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette2';
        jQuery.each(data.totalCateProductByDate, function( i, item ) {
          productCateQuantity = parseInt(data.totalCateProductByDate[i].quantity);
          //
          productCateTitle = data.totalCateProductByDate[i].productCateName;
          title_text = 'Phát sinh '+ productCateTitle +' theo thời gian';
          //
          productCateValue.push(parseInt(productCateQuantity));
          categories.push(data.totalCateProductByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: productCateTitle,
            type: productCateChartType,
            data: productCateValue
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

        var chart = new ApexCharts(document.querySelector("#chartTotalCateProductByDate"), options);
        chart.render(); 
    }
</script>