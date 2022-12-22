<script type="text/javascript">
    function chartTotalTrafficAdsByDate(data) {
        // Load Data
        var categories = [];
        // Google array
        var googleTitle = 'Google';
        var googleValue = [];
        var googleChartType = 'area';
        // Youtube array
        var youtubeTitle = 'Youtube';
        var youtubeValue = [];
        var youtubeChartType = 'area';
        // Fb array
        var fbTitle = 'Facebook';
        var fbValue = [];
        var fbChartType = 'area';
        // Twitter array
        var twitterTitle = 'Twitter';
        var twitterValue = [];
        var twitterChartType = 'area';
        // Instagram array
        var instagramTitle = 'Instagram';
        var instagramValue = [];
        var instagramChartType = 'area';
        // Pinterest array
        var pinterestTitle = 'Pinterest';
        var pinterestValue = [];
        var pinterestChartType = 'area';
        // Tiktok array
        var tiktokTitle = 'Tiktok';
        var tiktokValue = [];
        var tiktokChartType = 'area';
        // Bing array
        var bingTitle = 'Bing';
        var bingValue = [];
        var bingChartType = 'area';
        // CocCoc array
        var coccocTitle = 'CocCoc';
        var coccocValue = [];
        var coccocChartType = 'area';
        // Zalo array
        var zaloTitle = 'Zalo';
        var zaloValue = [];
        var zaloChartType = 'area';
        // Mailchimp array
        var mailchimpTitle = 'Mailchimp';
        var mailchimpValue = [];
        var mailchimpChartType = 'area';
        // Tumblr array
        var tumblrTitle = 'Tumblr';
        var tumblrValue = [];
        var tumblrChartType = 'area';

        var fontFamily = 'var(--bs-body-font-family)';
        var fontSize = '14px';
        var title_fontSize = '18px';
        var title_fontWeight = 'bold';
        var title_text = 'Thống kê truy cập nguồn quảng cáo theo thời gian';
        var xaxis_fontSize = '14px';
        var xaxis_fontWeight = 'bolder';
        var palette = 'palette7';
        var index = '0';
        var constValue = '0';
        jQuery.each(data.totalTrafficAdsByDate, function( i, item ) {
            googleValue.push(parseInt(data.totalTrafficAdsByDate[i].google));
            youtubeValue.push(parseInt(data.totalTrafficAdsByDate[i].youtube));
            fbValue.push(parseInt(data.totalTrafficAdsByDate[i].facebook));
            twitterValue.push(parseInt(data.totalTrafficAdsByDate[i].twitter));
            instagramValue.push(parseInt(data.totalTrafficAdsByDate[i].instagram));
            pinterestValue.push(parseInt(data.totalTrafficAdsByDate[i].pinterest));
            tiktokValue.push(parseInt(data.totalTrafficAdsByDate[i].tiktok));
            bingValue.push(parseInt(data.totalTrafficAdsByDate[i].bing));
            coccocValue.push(parseInt(data.totalTrafficAdsByDate[i].coccoc));
            zaloValue.push(parseInt(data.totalTrafficAdsByDate[i].zalo));
            mailchimpValue.push(parseInt(data.totalTrafficAdsByDate[i].mailchimp));
            tumblrValue.push(parseInt(data.totalTrafficAdsByDate[i].tumblr));
            categories.push(data.totalTrafficAdsByDate[i].created_at);
        });
        var options = {
          series: [
          {
            name: googleTitle,
            type: googleChartType,
            data: googleValue
          },
          {
            name: youtubeTitle,
            type: youtubeChartType,
            data: youtubeValue
          },
          {
            name: fbTitle,
            type: fbChartType,
            data: fbValue
          },
          {
            name: twitterTitle,
            type: twitterChartType,
            data: twitterValue
          },
          {
            name: instagramTitle,
            type: instagramChartType,
            data: instagramValue
          },
          {
            name: pinterestTitle,
            type: pinterestChartType,
            data: pinterestValue
          },
          {
            name: tiktokTitle,
            type: tiktokChartType,
            data: tiktokValue
          },
          {
            name: bingTitle,
            type: bingChartType,
            data: bingValue
          },
          {
            name: coccocTitle,
            type: coccocChartType,
            data: coccocValue
          },
          {
            name: zaloTitle,
            type: zaloChartType,
            data: zaloValue
          },
          {
            name: mailchimpTitle,
            type: mailchimpChartType,
            data: mailchimpValue
          },
          {
            name: tumblrTitle,
            type: tumblrChartType,
            data: tumblrValue
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

        var chart = new ApexCharts(document.querySelector("#chartTotalTrafficAdsByDate"), options);
        chart.render(); 
    }
</script>