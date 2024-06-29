        var myChart = echarts.init(document.getElementById('main'));
        var data = [];
        var filteredData = [];
        var times = [];

        // 读取 JSON 文件
        fetch('data-webs/res.json')
            .then(response => response.json())
            .then(jsonData => {
                data = jsonData;
            })
            .catch(error => {
                console.error('Error fetching the JSON file:', error);
            });

        // 根据城市名称和时间范围过滤数据
        function searchCity() {
            var city = document.getElementById('province').value;
            var startDateStr = document.getElementById('startDate').value;
            var endDateStr = document.getElementById('endDate').value;

            // 将时间字符串转换为默认年份的日期对象
            var startDate = new Date(`2023-${startDateStr}`);
            var endDate = new Date(`2023-${endDateStr}`);

            if (!data.length) {
                alert("数据尚未加载，请稍候再试！");
                return;
            }

            filteredData = data.filter(item => {
                var itemDate = new Date(`2023-${item.time}`);
                return item.city === city && itemDate >= startDate && itemDate <= endDate;
            });

            if (filteredData.length > 50) {
                filteredData = filteredData.slice(0, 100);
            }

            times = filteredData.map(item => item.time); // 使用原始时间字符串
            updateChart('WaterTemperature');
        }

        // 更新图表函数
        function updateChart(indicator) {
            if (!filteredData.length) {
                alert("请先输入城市名称和时间范围并搜索数据！");
                return;
            }

            var indicatorNames = {
                'WaterTemperature': '水温',
                'PH': 'pH',
                'DissolvedOxygen': '溶解氧',
                'ElectricalConductivity': '电导率',
                'TotalPhosphorus': '总磷',
                'TotalNitrogen': '总氮'
            };

            // 聚合数据并确保时间唯一化
            var aggregatedData = {};
            filteredData.forEach(item => {
                var value = parseFloat(item[indicator]);
                if (!isNaN(value)) {
                    if (!aggregatedData[item.time]) {
                        aggregatedData[item.time] = { count: 0, value: 0 };
                    }
                    aggregatedData[item.time].count += 1;
                    aggregatedData[item.time].value += value;
                }
            });

            var chartData = Object.keys(aggregatedData).map(time => ({
                time,
                value: aggregatedData[time].count ? aggregatedData[time].value / aggregatedData[time].count : 0
            })).sort((a, b) => new Date(`2023-${a.time}`) - new Date(`2023-${b.time}`));

            var barData = chartData.map(item => ({
                name: item.time,
                value: item.value,
                itemStyle: {
                    color: (item.value >= 20 && item.value <= 25) ? 'green' : 'red'
                }
            }));

            var times = chartData.map(item => item.time);

            var option = {
                backgroundColor: 'transparent',
                title: {
                    text: filteredData[0].city + ' ' + indicatorNames[indicator] + ' 指标',
                    textStyle: {
                        color: '#ffffff'
                    }
                },
                tooltip: {
                    trigger: 'axis',
                    formatter: function(params) {
                        var dateString = params[0].name;
                        return dateString + ': ' + params[0].value.toFixed(2);
                    }
                },
                xAxis: {
                    type: 'category',
                    data: times,
                    axisLabel: {
                        //rotate: 45,
                        formatter: function(value) {
                            var date = new Date(`2023-${value}`);
                            return (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes();
                        },
                        textStyle: {
                            color: '#ffffff'
                        }
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#ffffff'
                        }
                    }
                },
                yAxis: {
                    type: 'value',
                    name: indicatorNames[indicator],
                    min: 'dataMin',
                    max: 'dataMax',
                    axisLabel: {
                        textStyle: {
                        color: '#ffffff'
                        }
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#ffffff'
                        }
                    }
                },
                series: [
                    {
                        name: indicatorNames[indicator],
                        type: 'bar',
                        data: barData
                    },
                    {
                        name: indicatorNames[indicator],
                        type: 'line',
                        data: chartData.map(item => item.value),
                        symbol: 'circle',
                        symbolSize: 8,
                        itemStyle: {
                            normal: {
                                color: 'white' // 折线图点的颜色
                            }
                        },
                        emphasis: {
                            itemStyle: {
                                color: 'white',
                                borderColor: 'yellow',
                                borderWidth: 2,
                                symbolSize: 16 // 鼠标悬停时点的大小
                            }
                        },
                        lineStyle: {
                            color: '#66ccFF' // 折线的颜色
                        }
                    }
                ]
            };
            myChart.setOption(option);
        }