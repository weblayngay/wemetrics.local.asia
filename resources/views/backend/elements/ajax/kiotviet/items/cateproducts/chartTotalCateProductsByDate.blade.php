<script type="text/javascript">
    function chartTotalCateProductByDate(data) {
        // Load Data
        var categories = [];
        // Cặp xách
        var capxachTitle = 'Cặp xách';
        var capxachValue = [];
        var capxachChartType = 'line';
        // Túi đeo
        var tuideoTitle = 'Túi đeo';
        var tuideoValue = [];
        var tuideoChartType = 'line';
        // Túi quàng
        var tuiquangTitle = 'Túi quàng';
        var tuiquangValue = [];
        var tuiquangChartType = 'line';
        // Túi xách
        var tuixachTitle = 'Túi xách';
        var tuixachValue = [];
        var tuixachChartType = 'line';
        // Bóp ví
        var bopviTitle = 'Bóp ví';
        var bopviValue = [];
        var bopviChartType = 'line';
        // Balo
        var baloTitle = 'Balo';
        var baloValue = [];
        var baloChartType = 'line';
        // Túi du lịch
        var tuidulichTitle = 'Túi du lịch';
        var tuidulichValue = [];
        var tuidulichChartType = 'line';
        // Dây nịt
        var daynitTitle = 'Dây nịt';
        var daynitValue = [];
        var daynitChartType = 'line';
        // Phụ kiện
        var phukienTitle = 'Phụ kiện';
        var phukienValue = [];
        var phukienChartType = 'line';

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
          capxachValue.push(parseInt(data.totalCateProductByDate[i].subTotal_capxach));
          tuideoValue.push(parseInt(data.totalCateProductByDate[i].subTotal_tuideo));
          tuiquangValue.push(parseInt(data.totalCateProductByDate[i].subTotal_tuiquang));
          tuixachValue.push(parseInt(data.totalCateProductByDate[i].subTotal_tuixach));
          //
          bopviValue.push(parseInt(data.totalCateProductByDate[i].subTotal_bopvi));
          baloValue.push(parseInt(data.totalCateProductByDate[i].subTotal_balo));
          tuidulichValue.push(parseInt(data.totalCateProductByDate[i].subTotal_tuidulich));
          daynitValue.push(parseInt(data.totalCateProductByDate[i].subTotal_daynit));
          phukienValue.push(parseInt(data.totalCateProductByDate[i].subTotal_phukien));
          categories.push(data.totalCateProductByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: capxachTitle,
            type: capxachChartType,
            data: capxachValue
          },
          {
            name: tuideoTitle,
            type: tuideoChartType,
            data: tuideoValue
          },
          {
            name: tuiquangTitle,
            type: tuiquangChartType,
            data: tuiquangValue
          },
          {
            name: tuixachTitle,
            type: tuixachChartType,
            data: tuixachValue
          },
          {
            name: bopviTitle,
            type: bopviChartType,
            data: bopviValue
          },
          {
            name: baloTitle,
            type: baloChartType,
            data: baloValue
          },
          {
            name: tuidulichTitle,
            type: tuidulichChartType,
            data: tuidulichValue
          },
          {
            name: daynitTitle,
            type: daynitChartType,
            data: daynitValue
          },
          {
            name: phukienTitle,
            type: phukienChartType,
            data: phukienValue
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