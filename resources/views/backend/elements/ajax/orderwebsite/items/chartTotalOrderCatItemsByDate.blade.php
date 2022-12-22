<script type="text/javascript">
    function chartTotalOrderCatItemsByDate(data) {
        // Load Data
        var categories = [];
        // Wallet array
        var walletTitle = 'Bóp - Ví';
        var walletValue = [];
        var walletChartType = 'line';
        // Backpack array
        var backPackTitle = 'Balo';
        var backPackValue = [];
        var backPackChartType = 'line';
        // TravelBag array
        var travelBagTitle = 'Túi du lịch';
        var travelBagValue = [];
        var travelBagChartType = 'line';
        // HandBag array
        var handBagTitle = 'Túi xách';
        var handBagValue = [];
        var handBagChartType = 'line';
        // Belt array
        var beltTitle = 'Dây nịt';
        var beltValue = [];
        var beltChartType = 'line';
        // Accessory array
        var accessoryTitle = 'Phụ kiện';
        var accessoryValue = [];
        var accessoryChartType = 'line';
        // Gift array
        var giftTitle = 'Quà tặng';
        var giftValue = [];
        var giftChartType = 'line';

        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Phát sinh bán nhóm sản phẩm theo thời gian';
        var name_paid = 'Số lượng';
        var name_notpaid = 'Nhóm sản phẩm';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette1';
        jQuery.each(data.orderCatItemsByDate, function( i, item ) {
          walletValue.push(parseInt(data.orderCatItemsByDate[i].totalQuantity3));
          backPackValue.push(parseInt(data.orderCatItemsByDate[i].totalQuantity6));
          travelBagValue.push(parseInt(data.orderCatItemsByDate[i].totalQuantity17));
          handBagValue.push(parseInt(data.orderCatItemsByDate[i].totalQuantity21));
          beltValue.push(parseInt(data.orderCatItemsByDate[i].totalQuantity24));
          accessoryValue.push(parseInt(data.orderCatItemsByDate[i].totalQuantity31));
          giftValue.push(parseInt(data.orderCatItemsByDate[i].totalQuantity33));
          categories.push(data.orderCatItemsByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: walletTitle,
            type: walletChartType,
            data: walletValue
          },
          {
            name: backPackTitle,
            type: backPackChartType,
            data: backPackValue
          },
          {
            name: travelBagTitle,
            type: travelBagChartType,
            data: travelBagValue
          },
          {
            name: handBagTitle,
            type: handBagChartType,
            data: handBagValue
          },
          {
            name: beltTitle,
            type: beltChartType,
            data: beltValue
          },
          {
            name: accessoryTitle,
            type: accessoryChartType,
            data: accessoryValue
          },
          {
            name: giftTitle,
            type: giftChartType,
            data: giftValue
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
              text: name_paid,
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

        var chart = new ApexCharts(document.querySelector("#chartTotalOrderCatItemsByDate"), options);
        chart.render(); 
    }
</script>