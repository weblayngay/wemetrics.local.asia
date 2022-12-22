<script type="text/javascript">
    function chartTotalCustomer(data) {
        // Load Data
        var series = [];
        var labels = [];
        var fontFamily = 'labgrotesquevn-regular';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Tỷ lệ khách mới/ khách quay lại';
        var legend_fontSize = '14px';
        var legend_fontWeight = 'bolder';
        var palette = 'palette2';
        var totalCustomerNew = 0;
        var totalCustomerLoyalty = 0;
        // /
        jQuery.each(data.totalCustomerByDate, function( i, item ) {
          totalCustomerNew += parseInt(data.totalCustomerByDate[i].totalCustomerNew);
          totalCustomerLoyalty += parseInt(data.totalCustomerByDate[i].totalCustomerLoyalty);
        });
        //
        series.push(parseInt(totalCustomerNew));
        labels.push('Khách mới');
        series.push(parseInt(totalCustomerLoyalty));
        labels.push('Khách quay lại');

        var options = {
        chart: {
          type: 'pie',
          fontSize: fontSize,
          fontFamily: fontFamily,
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
        fill: {
          type: 'gradient',
          opacity: 1
        },
        stroke: {
          show: true,
          width: 2,
          curve: 'smooth'
        },
        legend: {
          show: true,
          position: 'bottom',
          fontSize: legend_fontSize,
          fontWeight: legend_fontWeight,
          formatter: function(val, opts) {
            return val + " - " + abbreviateNumber(opts.w.globals.series[opts.seriesIndex]);
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
        },
        series: series,
        labels: labels,
        plotOptions: {
              pie: {
                customScale: 1
              }
            }
        }
        var chart = new ApexCharts(document.querySelector("#chartTotalCustomer"), options);
        chart.render();
    }
</script>