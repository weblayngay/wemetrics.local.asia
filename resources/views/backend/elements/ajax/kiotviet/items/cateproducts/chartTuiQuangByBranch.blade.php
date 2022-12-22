<script type="text/javascript">
    function chartTuiQuangByBranch(data) {
        // Load Data
        var series = [];
        var labels = [];
        var branchIds = [];
        var productCates = [];
        var fontFamily = 'labgrotesquevn-regular';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Thống kê túi quàng theo cửa hàng';
        var legend_fontSize = '14px';
        var legend_fontWeight = 'bolder';
        var palette = 'palette1';
        var subTotal_tuixach = 0;
        var subTotal_bopvi = 0;
        var subTotal_balo = 0;
        var subTotal_tuidulich = 0;
        var subTotal_daynit = 0;
        var subTotal_phukien = 0;
        jQuery.each(data.tuiquangByBranch, function( i, item ) {
          if(i < 5)
          {
            series.push(parseInt(data.tuiquangByBranch[i].quantity));
            labels.push(data.tuiquangByBranch[i].branchName);
            branchIds.push(data.tuiquangByBranch[i].branchId);
            productCates.push(data.tuiquangByBranch[i].productCateCode);
          }
        });

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
        var chart = new ApexCharts(document.querySelector("#chartTuiQuangByBranch"), options);
        chart.render();
    }
</script>