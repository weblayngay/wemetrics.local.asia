<script type="text/javascript">
    function chartTotalQuantityCateProduct(data) {
        // Load Data
        var valueRange = [];
        var categories = [];
        var name = 'Số lượng bán';
        var title_text = 'Thống kê số lượng bán';
        var textTitle = 'Số lượng bán';
        var fontFamily = 'labgrotesquevn-regular';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var legend_fontSize = '14px';
        var legend_fontWeight = 'bolder';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette1';
        var quantity_capxach = 0;
        var quantity_tuideo = 0;
        var quantity_tuiquang = 0;
        var quantity_tuixach = 0;
        var quantity_bopvi = 0;
        var quantity_balo = 0;
        var quantity_tuidulich = 0;
        var quantity_daynit = 0;
        var quantity_phukien = 0;

        jQuery.each(data.totalCateProductByDate, function( i, item ) {
          quantity_capxach += parseInt(data.totalCateProductByDate[i].quantity_capxach);
          quantity_tuideo += parseInt(data.totalCateProductByDate[i].quantity_tuideo);
          quantity_tuiquang += parseInt(data.totalCateProductByDate[i].quantity_tuiquang);
          quantity_tuixach += parseInt(data.totalCateProductByDate[i].quantity_tuixach);
          //
          quantity_bopvi += parseInt(data.totalCateProductByDate[i].quantity_bopvi);
          quantity_balo += parseInt(data.totalCateProductByDate[i].quantity_balo);
          quantity_tuidulich += parseInt(data.totalCateProductByDate[i].quantity_tuidulich);
          quantity_daynit += parseInt(data.totalCateProductByDate[i].quantity_daynit);
          quantity_phukien += parseInt(data.totalCateProductByDate[i].quantity_phukien);
        });

        valueRange.push(parseInt(quantity_capxach));
        categories.push('Cặp xách');
        valueRange.push(parseInt(quantity_tuideo));
        categories.push('Túi đeo');
        valueRange.push(parseInt(quantity_tuiquang));
        categories.push('Túi quàng');
        valueRange.push(parseInt(quantity_tuixach));
        categories.push('Túi xách');
        valueRange.push(parseInt(quantity_bopvi));
        categories.push('Bóp ví');
        valueRange.push(parseInt(quantity_balo));
        categories.push('Balo');
        valueRange.push(parseInt(quantity_tuidulich));
        categories.push('Túi du lịch');
        valueRange.push(parseInt(quantity_daynit));
        categories.push('Dây nịt');
        valueRange.push(parseInt(quantity_phukien));
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

        var chart = new ApexCharts(document.querySelector("#chartTotalQuantityCateProduct"), options);
        chart.render(); 
    }
</script>