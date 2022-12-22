<script type="text/javascript">
function chartTotalTrafficBrowser(data) {
    // Load Data
    var series = [];
    var labels = [];
    var fontFamily = 'var(--bs-body-font-family)';
    var fontSize = '14px';
    var title_fontSize = '18px';
    var title_fontWeight = 'bold';
    var title_text = 'Thống kê truy cập trình duyệt';
    var legend_fontSize = '14px';
    var legend_fontWeight = 'bolder';
    var palette = 'palette1';
    jQuery.each(data.totalTrafficBrowser, function( i, item ) {
      series.push(parseInt(data.totalTrafficBrowser[i].total));
      labels.push(data.totalTrafficBrowser[i].label);
    });
    var options = {
    chart: {
      type: 'donut',
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
    var chart = new ApexCharts(document.querySelector("#chartTotalTrafficBrowser"), options);
    chart.render();
}
</script>