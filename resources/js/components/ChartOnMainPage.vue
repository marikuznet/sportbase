<template>
<div id="chart">
    <apexchart type="area" height="350" :options="chartOptions" :series="series"></apexchart>
</div>
</template>

<script>
export default {
    data() {
        return {
            chartOptions: {
                chart: {
                    stacked: false,
                    height: 350,
                    type: 'area',
                    fontFamily: "Muller",
                    animations: {
                        enabled: false
                    },
                },
                title: {
                    text: 'Цена на человека',
                    align: 'left',
                    margin: 10,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold',
                        fontFamily: "Muller",
                        color: '#30316e'
                    },
                },
                dataLabels: {
                    enabled: true,
                    position: 'top',
                    offsetY: -10,
                    background: {
                        enabled: false,
                        foreColor: '#e45868',
                    },
                },
                colors: ['#e45868'],
                markers: {
                    colors: '#fff',
                    strokeWidth: 3,
                    strokeColors: '#e45868',
                    size: 7,
                    hover: {
                        size: 7
                    },
                },
                stroke: {
                    curve: 'smooth'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.5,
                        gradientToColors: undefined,
                        inverseColors: false,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [20, 100, 100, 100],
                        colorStops: []
                    },
                },
                xaxis: {
                    type: 'string',
                    tickAmount: 24,
                    axisBorder: {
                        show: true,
                        color: '#6283e5',
                        offsetX: 0,
                        offsetY: 0,
                        height: 3
                    },
                    axisTicks: {
                        show: true,
                        borderType: 'solid',
                        color: '#78909C',
                        height: 15,
                        width: 5,
                        color: '#6283e5',
                        offsetX: 0,
                        offsetY: 0
                    },
                    labels: {
                        show: true,
                        
                        style: {

                            //colors: '#ffffff'
                        }
                    },
                },
                grid: {
                    show: true,
                    borderColor: '#dfdff3',
                    strokeDashArray: 0,
                    position: 'back',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    row: {
                        colors: undefined,
                        opacity: 0.4
                    },
                    column: {
                        colors: undefined,
                        opacity: 0.4
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                },
                yaxis: {

                    axisBorder: {
                        show: false,
                        //color: '#FFFFFF',
                        offsetX: 0,
                        offsetY: 0
                    },
                    labels: {
                        show: true,
                        style: {
                            //colors: ['#ffffff']
                        }
                    }
                },
                tooltip: {
                    shared: true
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetX: -10
                }

            },
            series: [{
                name: 'Значение за месяц',
                data: [{
                        x: ' ',
                        y: null
                    },
                    {
                        x: 'Январь',
                        y: 1000
                    },
                    {
                        x: 'Февраль',
                        y: 1250
                    },
                    {
                        x: 'Март',
                        y: 1750
                    },
                    {
                        x: 'Апрель',
                        y: 2200
                    },
                    {
                        x: 'Май',
                        y: 3000
                    },
                    {
                        x: 'Июнь',
                        y: 4000
                    },
                    {
                        x: 'Июль',
                        y: 3000
                    },
                    {
                        x: 'Август',
                        y: 2750
                    },
                    {
                        x: 'Сентябрь',
                        y: 3000
                    },
                    {
                        x: 'Октябрь',
                        y: 4000
                    },
                    {
                        x: 'Ноябрь',
                        y: 3400
                    },
                    {
                        x: 'Декабрь',
                        y: 3000
                    },
                    {
                        x: 'Январь',
                        y: 1000
                    },
                ],
            }],
        }
    },
}
</script>
