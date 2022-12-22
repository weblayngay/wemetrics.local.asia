<script type="text/javascript">
    function chartorderAndVoucherByDate(data) {
        // Load Data
        var quantityRange = [];
        var amountRange = [];
        var categories = [];
        var fontFamily = 'labgrotesquevn-regular';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Tình hình đơn hàng và mã giảm giá';
        var name_quantity = 'Mã giảm giá';
        var name_amount = 'Đơn hàng';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette6';
        jQuery.each(data.totalOrderAndVoucherByDate, function( i, item ) {
          quantityRange.push(parseInt(data.totalOrderAndVoucherByDate[i].totalVoucher));
          amountRange.push(parseInt(data.totalOrderAndVoucherByDate[i].totalOrder));
          categories.push(data.totalOrderAndVoucherByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: name_quantity,
            type: 'area',
            data: quantityRange
          },
          {
            name: name_amount,
            type: 'line',
            data: amountRange
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
          show: false,
          position: 'bottom',
          horizontalAlign: 'center'
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
          {
            opposite: true,
            title: {
              text: name_amount,
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

        var chart = new ApexCharts(document.querySelector("#chartorderAndVoucherByDate"), options);
        chart.render(); 
    }
</script>