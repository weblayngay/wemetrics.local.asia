<script type="text/javascript">
    function chartTotalTrafficPlatformByDate(data) {
        // Load Data
        var categories = [];
        // iOS array
        var iOSTitle = 'iOS';
        var iOSValue = [];
        var iOSChartType = 'area';
        // OS X array
        var oSXTitle = 'OS X';
        var oSXValue = [];
        var oSXChartType = 'line';
        // BlackBerryOS array
        var blackBerryOSTitle = 'BlackBerryOS';
        var blackBerryOSValue = [];
        var blackBerryOSChartType = 'line';
        // AndroidOS array
        var androidOSTitle = 'AndroidOS';
        var androidOSValue = [];
        var androidOSChartType = 'line';
        // ChromeOS array
        var chromeOSTitle = 'ChromeOS';
        var chromeOSValue = [];
        var chromeOSChartType = 'line';
        // Linux array
        var linuxTitle = 'Linux';
        var linuxValue = [];
        var linuxChartType = 'line';
        // OpenBSD array
        var openBSDTitle = 'OpenBSD';
        var openBSDValue = [];
        var openBSDChartType = 'line';
        // PPC array
        var pPCTitle = 'PPC';
        var pPCValue = [];
        var pPCChartType = 'line';
        // Ubuntu array
        var ubuntuTitle = 'Ubuntu';
        var ubuntuValue = [];
        var ubuntuChartType = 'line';
        // Debian array
        var debianTitle = 'Debian';
        var debianValue = [];
        var debianChartType = 'line';
        // Mac OS X array
        var macOSXTitle = 'Mac OS X';
        var macOSXValue = [];
        var macOSXChartType = 'line';
        // Windows NT array
        var windowsNTTitle = 'Windows NT';
        var windowsNTValue = [];
        var windowsNTChartType = 'line';
        // Windows array
        var windowsTitle = 'Windows';
        var windowsValue = [];
        var windowsChartType = 'line';


        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Thống kê truy cập nền tảng theo thời gian';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette2';
        var index = '0';
        var constValue = '0';
        jQuery.each(data.totalTrafficPlatformByDate, function( i, item ) {
          iOSValue.push(parseInt(data.totalTrafficPlatformByDate[i].ios));
          oSXValue.push(parseInt(data.totalTrafficPlatformByDate[i].osx));
          blackBerryOSValue.push(parseInt(data.totalTrafficPlatformByDate[i].blackberryos));
          androidOSValue.push(parseInt(data.totalTrafficPlatformByDate[i].androidos));
          chromeOSValue.push(parseInt(data.totalTrafficPlatformByDate[i].chromeos));
          linuxValue.push(parseInt(data.totalTrafficPlatformByDate[i].linux));
          openBSDValue.push(parseInt(data.totalTrafficPlatformByDate[i].openbsd));
          pPCValue.push(parseInt(data.totalTrafficPlatformByDate[i].ppc));
          ubuntuValue.push(parseInt(data.totalTrafficPlatformByDate[i].ubuntu));
          debianValue.push(parseInt(data.totalTrafficPlatformByDate[i].debian));
          macOSXValue.push(parseInt(data.totalTrafficPlatformByDate[i].macosx));
          windowsNTValue.push(parseInt(data.totalTrafficPlatformByDate[i].windowsnt));
          windowsValue.push(parseInt(data.totalTrafficPlatformByDate[i].windows));
          categories.push(data.totalTrafficPlatformByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: iOSTitle,
            type: iOSChartType,
            data: iOSValue
          },
          {
            name: oSXTitle,
            type: oSXChartType,
            data: oSXValue
          },
          {
            name: blackBerryOSTitle,
            type: blackBerryOSChartType,
            data: blackBerryOSValue
          },
          {
            name: androidOSTitle,
            type: androidOSChartType,
            data: androidOSValue
          },
          {
            name: chromeOSTitle,
            type: chromeOSChartType,
            data: chromeOSValue
          },
          {
            name: linuxTitle,
            type: linuxChartType,
            data: linuxValue
          },
          {
            name: openBSDTitle,
            type: openBSDChartType,
            data: openBSDValue
          },
          {
            name: pPCTitle,
            type: pPCChartType,
            data: pPCValue
          },
          {
            name: ubuntuTitle,
            type: ubuntuChartType,
            data: ubuntuValue
          },
          {
            name: debianTitle,
            type: debianChartType,
            data: debianValue
          },
          {
            name: macOSXTitle,
            type: macOSXChartType,
            data: macOSXValue
          },
          {
            name: windowsNTTitle,
            type: windowsNTChartType,
            data: windowsNTValue
          },
          {
            name: windowsTitle,
            type: windowsChartType,
            data: windowsValue
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

        var chart = new ApexCharts(document.querySelector("#chartTotalTrafficPlatformByDate"), options);
        chart.render(); 
    }
</script>