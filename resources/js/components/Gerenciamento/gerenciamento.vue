
  <script>
  import { Bar } from 'vue-chartjs';
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
  import axios from 'axios';
  import _ from 'lodash';
  
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
  
  export default {
    name: 'BarChart',
    components: { Bar },
    data() {
      return {
        graficoAgendamentosMensalMesInicio : null  ,
        graficoAgendamentosMensalMesFim : null  ,
        graficoArrecadamentosMensalMesInicio : null ,
        graficoArrecadamentosMensalMesFim : null , 

        chartArrecadamentosData: {
          labels: [],
          datasets: [ { data: [] } ]
        },
        chartData: {
          labels: [],
          datasets: [ { data: [] } ]
        },
        chartOptions: {
          responsive: true
        }
      }
    },
    methods: {
        getGraficoArrecadamentosMensalBusca(){
            let dados = {
                mesanoInicio : this.graficoArrecadamentosMensalMesInicio , 
                mesanoFim : this.graficoArrecadamentosMensalMesFim 
            };
            console.log(dados);
            axios.post('/api/gerenciamento/getGraficoArrecadamentosMensalBusca' , dados ).then( retorno => {
            let label= [] ;
            let dataset = [] ; 
            
            _.forEach(retorno.data ,function(value) {
                label.push(value.labels);
                dataset.push( value.values );
              
            });
            this.chartArrecadamentosData = {
                labels : label , 
                datasets : [{ data : dataset , backgroundColor : '#f87979' ,label: 'Quantidade de agendamentos por dia do mês'} ]
            };
        });
        } , 

        getGraficoAgendamentosMensalBusca(){

            let dados = {
                mesanoInicio : this.graficoAgendamentosMensalMesInicio , 
                mesanoFim : this.graficoAgendamentosMensalMesFim 
            };
            console.log(dados);
            axios.post('/api/gerenciamento/getGraficoAgendamentosMensalBusca' , dados ).then( retorno => {
            let label= [] ;
            let dataset = [] ; 
            
            _.forEach(retorno.data ,function(value) {
                label.push(value.labels);
                dataset.push( value.values );
              
            });
            this.chartData = {
                labels : label , 
                datasets : [{ data : dataset , backgroundColor : '#f87979' ,label: 'Quantidade de agendamentos por dia do mês'} ]
            };
        });
        }

    },
    mounted() {
        axios.get('/api/gerenciamento/gerenciamentosGraficoRendaMensal').then( retorno => {
            let label= [] ;
            let dataset = [] ; 
            
            _.forEach(retorno.data ,function(value) {
                label.push(value.labels);
                dataset.push( value.values );
              
            });
            this.chartData = {
                labels : label , 
                datasets : [{ data : dataset , backgroundColor : '#f87979' ,label: 'Quantidade de agendamentos por dia'} ]
            };
        });
        
        let dados ={
            mesanoInicio : null ,
            mesanoFim : null 
        };
        axios.post('/api/gerenciamento/getGraficoArrecadamentosMensalBusca' , dados ).then( retorno => {
            let label= [] ;
            let dataset = [] ; 
            
            _.forEach(retorno.data ,function(value) {
                label.push(value.labels);
                dataset.push( value.values );
              
            });
            this.chartArrecadamentosData = {
                labels : label , 
                datasets : [{ data : dataset , backgroundColor : '#f87979' ,label: 'Quantidade de R$ esperados pelos agendamentos do dia.'} ]
            };
        });


    }
  }
  </script>
  <style scoped>
    .grafico {
        margin: 0 auto 0 auto ;
    }
    .spacing{
        height: 50px;
    }

  </style>
  
  <template>

      
            <div class="spacing"></div>
            <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="mes">Mês inicio</label>
                    <input type="month" class="form-control form-control-sm" id="mes" v-model="graficoAgendamentosMensalMesInicio" v-on:change="getGraficoAgendamentosMensalBusca" />
                </div>    
                
                <div class="form-group col-md-6">
                    <label for="mes">Mês fim</label>
                    <input type="month" class="form-control form-control-sm" id="mes" v-model="graficoAgendamentosMensalMesFim" v-on:change="getGraficoAgendamentosMensalBusca" />
                </div>
            </div>

            <div class="spacing"></div>

            <Bar id="my-chart-id" :options="chartOptions" :data="chartArrecadamentosData" />
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="mes">Mês inicio</label>
                    <input type="month" class="form-control form-control-sm" id="mes" v-model="graficoArrecadamentosMensalMesInicio" v-on:change="getGraficoArrecadamentosMensalBusca" />
                </div>    
                
                <div class="form-group col-md-6">
                    <label for="mes">Mês fim</label>
                    <input type="month" class="form-control form-control-sm" id="mes" v-model="graficoArrecadamentosMensalMesFim" v-on:change="getGraficoArrecadamentosMensalBusca" />
                </div>
            </div>

            <div class="spacing"></div>
</template>
  