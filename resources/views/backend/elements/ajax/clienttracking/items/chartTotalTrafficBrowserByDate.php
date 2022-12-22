<script type="text/javascript">
    function chartTotalTrafficBrowserByDate(data) {
        // Load Data
        var categories = [];
        // Chrome array
        var chromeTitle = 'Chrome';
        var chromeValue = [];
        var chromeChartType = 'area';
        // OperaMini array
        var operaMiniTitle = 'Opera Mini';
        var operaMiniValue = [];
        var operaMiniChartType = 'line';
        // Opera array
        var operaTitle = 'Opera';
        var operaValue = [];
        var operaChartType = 'line';
        // Edge array
        var edgeTitle = 'Edge';
        var edgeValue = [];
        var edgeChartType = 'line';
        // Coc Coc array
        var coccocTitle = 'Coc Coc';
        var coccocValue = [];
        var coccocChartType = 'line';
        // UCBrowser array
        var uCBrowserTitle = 'UCBrowser';
        var uCBrowserValue = [];
        var uCBrowserChartType = 'line';
        // Vivaldi array
        var vivaldiTitle = 'Vivaldi';
        var vivaldiValue = [];
        var vivaldiChartType = 'line';
        // Firefox array
        var firefoxTitle = 'Firefox';
        var firefoxValue = [];
        var firefoxChartType = 'line';
        // Safari array
        var safariTitle = 'Safari';
        var safariValue = [];
        var safariChartType = 'line';
        // IE array
        var iETitle = 'IE';
        var iEValue = [];
        var iEChartType = 'line';
        // Netscape array
        var netscapeTitle = 'Netscape';
        var netscapeValue = [];
        var netscapeChartType = 'line';
        // Mozilla array
        var mozillaTitle = 'Mozilla';
        var mozillaValue = [];
        var mozillaChartType = 'line';


        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Thống kê truy cập trình duyệt theo thời gian';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette2';
        var index = '0';
        var constValue = '0';
        jQuery.each(data.totalTrafficBrowserByDate, function( i, item ) {
            operaMiniValue.push(parseInt(data.totalTrafficBrowserByDate[i].operamini));
            operaValue.push(parseInt(data.totalTrafficBrowserByDate[i].opera));
            edgeValue.push(parseInt(data.totalTrafficBrowserByDate[i].edge));
            coccocValue.push(parseInt(data.totalTrafficBrowserByDate[i].coccoc));
            uCBrowserValue.push(parseInt(data.totalTrafficBrowserByDate[i].ucbrowser));
            vivaldiValue.push(parseInt(data.totalTrafficBrowserByDate[i].vivaldi));
            chromeValue.push(parseInt(data.totalTrafficBrowserByDate[i].chrome));
            firefoxValue.push(parseInt(data.totalTrafficBrowserByDate[i].firefox));
            safariValue.push(parseInt(data.totalTrafficBrowserByDate[i].safari));
            iEValue.push(parseInt(data.totalTrafficBrowserByDate[i].ie));
            netscapeValue.push(parseInt(data.totalTrafficBrowserByDate[i].netscape));
            mozillaValue.push(parseInt(data.totalTrafficBrowserByDate[i].mozilla));
            categories.push(data.totalTrafficBrowserByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: chromeTitle,
            type: chromeChartType,
            data: chromeValue
          },
          {
            name: operaMiniTitle,
            type: operaMiniChartType,
            data: operaMiniValue
          },
          {
            name: operaTitle,
            type: operaChartType,
            data: operaValue
          },
          {
            name: edgeTitle,
            type: edgeChartType,
            data: edgeValue
          },
          {
            name: coccocTitle,
            type: coccocChartType,
            data: coccocValue
          },
          {
            name: uCBrowserTitle,
            type: uCBrowserChartType,
            data: uCBrowserValue
          },
          {
            name: vivaldiTitle,
            type: vivaldiChartType,
            data: vivaldiValue
          },
          {
            name: firefoxTitle,
            type: firefoxChartType,
            data: firefoxValue
          },
          {
            name: safariTitle,
            type: safariChartType,
            data: safariValue
          },
          {
            name: iETitle,
            type: iEChartType,
            data: iEValue
          },
          {
            name: netscapeTitle,
            type: netscapeChartType,
            data: netscapeValue
          },
          {
            name: mozillaTitle,
            type: mozillaChartType,
            data: mozillaValue
          },
        ],
          chart: {
          type: 'area',
          height: 500,
          zoom: {
            enabled: true
          },
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
          size: 1,
          hover: {
            sizeOffset: 6
          }
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
          width: 3,
          curve: 'smooth',
          lineCap: 'butt'
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

        var chart = new ApexCharts(document.querySelector("#chartTotalTrafficBrowserByDate"), options);
        chart.render(); 
    }
</script>