<template>
  <div>
    <a-card :bordered="false" :loading="loading" class="graph">
      <template slot="title">
        <a-icon type="line-chart" :style="{ marginRight: '10px' }" />
        Grafik Pengunjung
      </template>
      <template slot="extra">
        <a-tooltip placement="left">
          <template slot="title">
            <span>Refresh Data</span>
          </template>
          <a-button icon="reload" />
        </a-tooltip>
      </template>
      <apexchart
        type="area"
        height="350"
        :options="chartOptions"
        :series="series"
      ></apexchart>
    </a-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      series: [],
      loading: false,
      chartOptions: []
    };
  },
  created() {
    this.getChart();
  },
  methods: {
    async getChart() {
      try {
        this.loading = true;
        const response = await this.$store.dispatch(
          "user/getChart",
          "type=month"
        );
        this.series = response.series;
        this.chartOptions = {
          chart: {
            height: 350,
            type: "area",
            toolbar: {
              show: false
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: "smooth"
          },
          xaxis: {
            type: "datetime",
            categories: response.categories
          },
          tooltip: {
            x: {
              format: "dd/MM/yy HH:mm"
            }
          }
        };
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    }
  },
  reload() {
    this.getChart();
  }
};
</script>
