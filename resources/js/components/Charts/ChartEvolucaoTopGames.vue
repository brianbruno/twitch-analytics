<script>
    import { Line } from 'vue-chartjs'

    export default {
        extends: Line,
        data () {
            return {
                datacollection: null,
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        },
        mounted() {
            const self = this;
            self.getData();
        },
        methods: {
            getData () {
                const self = this;
                axios.get('/chart/evolucaotopgames')
                    .then(function (response) {
                        const dados = response.data;

                        self.datacollection = {
                            labels: dados.labels,
                            datasets: dados.datasets
                        };

                        self.renderChart(self.datacollection, self.options);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        setTimeout(function () {
                            self.getData();
                        }, 60000)
                    });
            }
        }
    }
</script>
