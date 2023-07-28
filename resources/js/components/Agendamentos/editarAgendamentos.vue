<script>
    import axios from 'axios';
    import _ from 'lodash';
    export default {
    props : ['email'] , 
    data() {
        return {
            abrirModal : false ,
            clientesDataSource : null , 
            servicosDataSource : null ,
            servicosQuantidade : 0 , 
            servicosPreco : 0.00 , 
            servicosTempo :'00:00',
            servicoSelecionado : null ,

            servicosSelecionadosDataSource : [] ,
            clientesDataSourceSelect : null ,
            descricao :"", 
            desconto : '0.00' , 
            acrescimo : '0.00' ,
            dataAgendamento :'' , 
            observacao : '' , 
        }
    }, 
    methods:{
        adicionarServico(){
            if(this.servicosDataSourceSelect){
            let jaExiste = false ; 
            for(let i = 0 ; i <this.servicosSelecionadosDataSource.length ; i++ ) {
                    if(this.servicosSelecionadosDataSource[i].id === this.servicosDataSourceSelect ){
                        jaExiste=true ; 
                    }
                }

            if(jaExiste==false){
                if(this.servicoSelecionado != null ){
                    let elementoAntigo = document.getElementById('servicosSelecionado_id'+this.servicoSelecionado);
                    elementoAntigo.className = ''; 
                    this.servicoSelecionado= null ; 
                }
            
                for( let i = 0; i < this.servicosDataSource.length ; i++ ) {
                    if(this.servicosDataSource[i].id === this.servicosDataSourceSelect) {

                        this.servicosSelecionadosDataSource.push(this.servicosDataSource[i]);
                        this.servicosQuantidade++; 
                        this.servicosPreco = parseFloat(this.servicosPreco);
                        this.servicosPreco+=parseFloat(this.servicosDataSource[i].preco);
                        this.servicosPreco=parseFloat(this.servicosPreco).toFixed(2);
                        let tempo =this.servicosDataSource[i].tempoestimado.substring(0 , 5 );
                        
                        let horas = parseInt(this.servicosTempo.substring(0,2))+ parseInt(tempo.substring(0,2));
                        let minutos = parseInt(this.servicosTempo.substring(3 , 5 ))+ parseInt(tempo.substring(3 , 5 ));
                        horas+=parseInt(minutos/60);
                        minutos= minutos%60; 
                        this.servicosTempo = horas.toString().padStart(2, '0')+':'+minutos.toString().padStart(2, '0');
                    }
                }
            }
            }
        },
        selecionarServicoIncluido(id){
        let elemento= document.getElementById('servicosSelecionado_id'+id);
        if( this.servicoSelecionado != null ){
            let elementoAntigo = document.getElementById('servicosSelecionado_id'+this.servicoSelecionado);
            elementoAntigo.className = ''; 
            this.servicoSelecionado= null ; 
        }
        elemento.className='table-warning';
        this.servicoSelecionado = id ;
    },
    removerServico(){
            if(this.servicosSelecionadosDataSource != null && this.servicoSelecionado != null  ){
                for( let i = 0; i < this.servicosSelecionadosDataSource.length ; i++ ) {
                    if(this.servicosSelecionadosDataSource[i].id === this.servicoSelecionado ) {

                        if(this.servicoSelecionado != null ){
                        let elementoAntigo = document.getElementById('servicosSelecionado_id'+this.servicoSelecionado);
                        elementoAntigo.className = ''; 
                        this.servicoSelecionado= null ; 
                        }
                        
                        this.servicosPreco=parseFloat(this.servicosPreco)-parseFloat(this.servicosSelecionadosDataSource[i].preco);
                        this.servicosPreco = this.servicosPreco.toFixed(2);

                        this.servicosQuantidade--;

                        let tempo =this.servicosSelecionadosDataSource[i].tempoestimado.substring(0 , 5 );
                        let horasremovidas = parseInt(tempo.substring(0, 2))*60; 
                        let minutosremovidos = parseInt(tempo.substring(3, 5) );
                        let temporemovidototal = horasremovidas+minutosremovidos;

                        let horas = parseInt(this.servicosTempo.substring(0,2))*60;
                        let minutos = parseInt(this.servicosTempo.substring(3 , 5 ))
                        let tempototal = horas+minutos;

                        this.servicosTempo= parseInt((tempototal-temporemovidototal)/60).toString().padStart(2 , '0')
                        +':'+
                        (parseInt(tempototal-temporemovidototal)%60).toString().padStart(2 , '0');
                        this.servicoSelecionado=null;
                        this.servicosSelecionadosDataSource.splice(i , 1 );
                        
                        if(this.servicoSelecionado != null ){
                        let elementoAntigo = document.getElementById('servicosSelecionado_id'+this.servicoSelecionado);
                        elementoAntigo.className = ''; 
                        this.servicoSelecionado= null ; 
                    }
                    }
                }
                this.servicoSelecionado = null ; 
                if(this.servicosSelecionadosDataSource.length == 0 ){
                    this.servicosPreco = 0 ;
                    this.servicosTempo = '00:00'; 
                    this.servicosQuantidade = 0 ;
                }
            }
            
    },
    },
    mounted(){
        const dataAtual = moment.utc();
                const dataSaoPaulo = dataAtual.tz('America/Sao_Paulo');
                const dataFormatada = dataSaoPaulo.format('YYYY-MM-DDTHH:mm');
                this.dataAgendamento = dataFormatada;

                axios.get('/api/agendamentos/getClientes').then(response => this.clientesDataSource = response.data);
                axios.get('api/agendamentos/getServicos').then(response => this.servicosDataSource = response.data);
    },
    
  }
</script>
<style scoped>
   
    .modalCadastroServicos{
        display: block ;
    }
    .esconderModal{
        display: none; 
    }
    legend{
        border: 2px  ;
        border-radius: 4px;
        font-size: 1.4em;
    }
    legend:hover{
        color : aqua;
        cursor: pointer;
    }

</style>
<template>
                 <fieldset>
                      <legend >Cadastrar novo agendamento</legend>
                    <div >
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label >Descricao</label>
                            <input type="text" class="form-control form-control-sm" v-model="descricao" maxlength="60" placeholder="Descrição do agendamento">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Data do agendamento</label>
                            <input type="datetime-local" class="form-control form-control-sm" v-model="dataAgendamento" :min="dataAgendamento" name="dataagendamento">
                        </div>                        
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <select class="form-select"  v-model="clientesDataSourceSelect">
                                <option v-for=" clientes in clientesDataSource " :id="'clientes_id'+clientes.id" :value="'clientes_id'+clientes.id" >
                                    {{ clientes.nome }} {{ clientes.telefone }}</option>

                            </select>  
                        </div>
                       
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-9">
                            <select class="form-select" v-model="servicosDataSourceSelect" >
                                <option v-for=" servicos in servicosDataSource " :ref="'servicos_id'+servicos.id" :value="servicos.id" >
                                     {{ servicos.nome }} R${{ servicos.preco }}, duração {{ servicos.tempoestimado.substr(0,5)  }} </option>
                            </select>                 
                        </div>
                    <div class="form-group col-md-3">
                        <button class="btn btn-success btn-sm" @click="adicionarServico" >Incluir</button>
                    </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-9">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th><th>Nome do servico</th><th>Preço</th><td><b>Tempo</b></td> 
                                    </tr>
                                </thead>
                                <tbody v-for="servicos in servicosSelecionadosDataSource" >
                                        <tr :id="'servicosSelecionado_id' + servicos.id" @click="selecionarServicoIncluido(servicos.id)" >
                                        <td>{{ servicos.id }}</td>
                                        <td>{{ servicos.nome }}</td>
                                        <td>{{ servicos.preco}}</td>
                                        <td>{{ servicos.tempoestimado.substring( 0 ,5) }}</td> 
                                        
                                        </tr>
                                </tbody>
                                        
                                <tfoot>
                                    <tr>
                                        <td>Total</td><td>{{ servicosQuantidade }}</td> <td>{{ servicosPreco }}</td><td>{{ servicosTempo }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> 
                        <div class="form-group col-md-3">
                            <button class="btn btn-danger btn-sm" @click="removerServico" >Remover</button>
                        </div>
                    </div>
                    
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label >Desconto R$</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" v-model="desconto">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Acrescimo R$</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" v-model="acrescimo">
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="form-group">
                            <label >Observação</label>
                            <textarea class="form-control" v-model="observacao" rows="3" maxlength="255"></textarea>
                        </div>
                    </div>
                    <br>        
                        <div class="form-group">
                            <button @click="cadastrarAgendamento" class="btn btn-primary"
                            :disabled="(!this.clientesDataSourceSelect || (this.servicosQuantidade==0) )"
                            >Cadastrar cliente</button>
                        </div>
                    <br>
                </div>
            </fieldset>   
</template>