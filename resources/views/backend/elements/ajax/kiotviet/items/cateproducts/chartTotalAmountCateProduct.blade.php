<script type="text/javascript">
    function chartTotalAmountCateProduct(data) {
        // Load Data
        var valueRange = [];
        var categories = [];
        var name = 'Tiền hàng thu';
        var title_text = 'Thống kê tiền hàng thu';
        var textTitle = 'Tiền hàng thu';
        var fontFamily = 'labgrotesquevn-regular';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var legend_fontSize = '14px';
        var legend_fontWeight = 'bolder';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette2';
        var subTotal_capxach = 0;
        var subTotal_tuideo = 0;
        var subTotal_tuiquang = 0;
        var subTotal_tuixach = 0;
        var subTotal_bopvi = 0;
        var subTotal_balo = 0;
        var subTotal_tuidulich = 0;
        var subTotal_daynit = 0;
        var subTotal_phukien = 0;

        jQuery.each(data.totalCateProductByDate, function( i, item ) {
          subTotal_capxach += parseInt(data.totalCateProductByDate[i].subTotal_capxach);
          subTotal_tuideo += parseInt(data.totalCateProductByDate[i].subTotal_tuideo);
          subTotal_tuiquang += parseInt(data.totalCateProductByDate[i].subTotal_tuiquang);
          subTotal_tuixach += parseInt(data.totalCateProductByDate[i].subTotal_tuixach);
          //
          subTotal_bopvi += parseInt(data.totalCateProductByDate[i].subTotal_bopvi);
          subTotal_balo += parseInt(data.totalCateProductByDate[i].subTotal_balo);
          subTotal_tuidulich += parseInt(data.totalCateProductByDate[i].subTotal_tuidulich);
          subTotal_daynit += parseInt(data.totalCateProductByDate[i].subTotal_daynit);
          subTotal_phukien += parseInt(data.totalCateProductByDate[i].subTotal_phukien);
        });

        valueRange.push(parseInt(subTotal_capxach));
        categories.push('Cặp xách');
        valueRange.push(parseInt(subTotal_tuideo));
        categories.push('Túi đeo');
        valueRange.push(parseInt(subTotal_tuiquang));
        categories.push('Túi quàng');
        valueRange.push(parseInt(subTotal_tuixach));
        categories.push('Túi xách');
        valueRange.push(parseInt(subTotal_bopvi));
        categories.push('Bóp ví');
        valueRange.push(parseInt(subTotal_balo));
        categories.push('Balo');
        valueRange.push(parseInt(subTotal_tuidulich));
        categories.push('Túi du lịch');
        valueRange.push(parseInt(subTotal_daynit));
        categories.push('Dây nịt');
        valueRange.push(parseInt(subTotal_phukien));
        categories.push('Phụ kiện');

        // Load chartRevenue
        var options = {
          series: [{
          name: name,
          data: valueRange
        }],
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
            columnWidth: '60%',
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
              text: textTitle,
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
        tooltip: {
          y: {
            formatter: function (val) {
              return abbreviateNumber(val)
            }
          }
        },
        title: {
            text: title_text,
            align: 'top',
            margin: 10,
            offsetX: 0,
            offsetY: 0,
            floating: false,
            style: {
              fontSize:  title_fontSize,
              fontWeight:  title_fontWeight,
            },
          }
        };

        var chart = new ApexCharts(document.querySelector("#chartTotalAmountCateProduct"), options);
        chart.render(); 
    }
</script>