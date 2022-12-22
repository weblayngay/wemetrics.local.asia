<script type="text/javascript">
    function chartorderUsedVoucherByReseller(data) {
        // Load Data
        var quantityRange = [];
        var amountRange = [];
        var categories = [];
        var fontFamily = 'labgrotesquevn-regular';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Tình hình sử dụng mã giảm giá tại cửa hàng - Top 10';
        var name_quantity = 'Số lượng';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette6';
        jQuery.each(data.totalorderUsedVoucherByReseller, function( i, item ) {
          quantityRange.push(parseInt(data.totalorderUsedVoucherByReseller[i].totalOrder));
          categories.push(data.totalorderUsedVoucherByReseller[i].reseller);
        });
        var options = {
          series: [
          {
            name: name_quantity,
            data: quantityRange
          }
        ],
          chart: {
          type: 'bar',
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
          horizontalAlign: 'center'
        },
        plotOptions: {
          bar: {
            horizontal: true,
            columnWidth: '100%',
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

        var chart = new ApexCharts(document.querySelector("#chartorderUsedVoucherByReseller"), options);
        chart.render(); 
    }
</script>