<script>
    import axios from 'axios';
    import _ from 'lodash';
    import moment from 'moment-timezone';
import { stringify } from 'postcss';
    export default {
    props : ['email' , 'editaragendamentosid' , 'tipousuario'] , 
    data() {
        return {
            abrirModal : false ,
            clientesDataSource : null , 
            servicosDataSource : null ,
            servicosQuantidade : 0 , 
            servicosPreco : 0.00 , 
            servicosTempo :'00:00',
            servicoSelecionado : null ,
            dias : 0 ,
            iniciarTransacao : false , 

            situacaoAgendamentos : 0 ,
            servicosSelecionadosDataSource : [] ,
            clientesDataSourceSelect : null ,
            descricao :"", 
            desconto : '0.00' , 
            acrescimo : '0.00' ,
            dataAgendamento :'' , 
            observacao : '' , 
            dataTermino : null ,
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
    
    editarAgendamento(){
        this.iniciarTransacao = true ;
        let clientes_id =this.clientesDataSourceSelect.replace('clientes_id' , '') ;
        let dados = {
        "clientes_id" : clientes_id ,
        "dataagendamento" : this.dataAgendamento  };

        let dadosCadastro = {
                     "servicos" : this.servicosSelecionadosDataSource ,
                     "clientes_id" : clientes_id ,
                     "descricao" : this.descricao ,
                     "desconto" :  parseFloat(this.desconto).toFixed(2),
                     "acrescimo" : parseFloat(this.acrescimo).toFixed(2) ,
                     "dataagendamento" : this.dataAgendamento ,
                     "observacao" : this.observacao ,
                     "situacaoagendamento" : this.situacaoAgendamentos,
                     "datatermino" :  this.dataTermino , 
                     "email" : this.email ,
                     "id" : this.editaragendamentosid , 
                };
        console.log(JSON.stringify(dadosCadastro));
            axios.post('/api/agendamentos/editarAgendamentos' , dadosCadastro ).then( retornoCadastro =>{
                    if(retornoCadastro.data=='OK'){
                        window.location.href=('/agendamentos');
                    }else{
                        alert(retornoCadastro);
                        this.iniciarTransacao = true ;
                    }
                });
    }

    },
    mounted(){
        const dataAtual = moment.utc();
                const dataSaoPaulo = dataAtual.tz('America/Sao_Paulo');
                const dataFormatada = dataSaoPaulo.format('YYYY-MM-DDTHH:mm');
                this.dataAgendamento = dataFormatada;
                
                axios.get('/api/agendamentos/getClientes').then(response => this.clientesDataSource = response.data);
                axios.get('/api/agendamentos/getServicos').then(resources => {
                     this.servicosDataSource = resources.data;
                     axios.get('/api/agendamentos/getEditarAgendamentos/'+this.editaragendamentosid ).then(response =>{
                     this.descricao = response.data.descricao;
                     this.desconto = response.data.desconto; 
                     this.acrescimo = response.data.acrescimo;
                     this.dataAgendamento = response.data.dataagendamento;
                     this.observacao = response.data.observacao;
                     this.situacaoAgendamentos = response.data.situacaoagendamento ;
                     this.clientesDataSourceSelect = 'clientes_id'+response.data.clientes_id ;
                     this.dias = response.data.dias ; 
                     this.dataTermino = response.data.datatermino ; 
                     let dataSource = resources.data ; 
                     let servicos = response.data.servicos;
                     let servicosSelecionados =[];
                     var self = this ; 
                     _.forEach( servicos , function(value) {
                         _.forEach( dataSource , function(servico){
                            if(value.servicos_id === servico.id ){
                                servicosSelecionados.push(servico);
                                self.servicosDataSourceSelect =value.servicos_id ;
                                self.adicionarServico();
                                }
                         } ) 
                    });
                     this.servicosSelecionadosDataSource = servicosSelecionados;
                });
                
                });
                    

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
                            <input :disabled="this.dias<2 && this.tipousuario != 1" type="text" class="form-control form-control-sm" v-model="descricao" maxlength="60" placeholder="Descrição do agendamento">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Data do agendamento</label>
                            <input :disabled="this.dias<2 && this.tipousuario != 1" type="datetime-local" class="form-control form-control-sm" v-model="dataAgendamento" :min="dataAgendamento" name="dataagendamento">
                        </div>                        
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <select :disabled="true" class="form-select"  v-model="clientesDataSourceSelect">
                                <option v-for=" clientes in clientesDataSource " :id="'clientes_id'+clientes.id" :value="'clientes_id'+clientes.id" >
                                    {{ clientes.nome }} {{ clientes.telefone }}</option>

                            </select>  
                        </div>
                       
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-9">
                            <select :disabled="this.dias<2 && this.tipousuario != 1" class="form-select" v-model="servicosDataSourceSelect" >
                                <option v-for=" servicos in servicosDataSource " :ref="'servicos_id'+servicos.id" :value="servicos.id" >
                                     {{ servicos.nome }} R${{ servicos.preco }}, duração {{ servicos.tempoestimado }} </option>
                            </select>                 
                        </div>
                    <div class="form-group col-md-3">
                        <button :disabled="this.dias<2 && this.tipousuario != 1" class="btn btn-success btn-sm" @click="adicionarServico" >Incluir</button>
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
                                        <td>{{ servicos.tempoestimado }}</td> 
                                        
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
                            <button :disabled="this.dias<2 && this.tipousuario != 1" class="btn btn-danger btn-sm" @click="removerServico" >Remover</button>
                        </div>
                    </div>
                    
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label >Desconto R$</label>
                            <input :disabled="this.dias<2 && this.tipousuario != 1" type="number" step="0.01" class="form-control form-control-sm" v-model="desconto">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Acrescimo R$</label>
                            <input :disabled="this.dias<2 && this.tipousuario != 1" type="number" step="0.01" class="form-control form-control-sm" v-model="acrescimo">
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="form-group">
                            <label >Observação</label>
                            <textarea :disabled="this.dias<2 && this.tipousuario != 1" class="form-control" v-model="observacao" rows="3" maxlength="255"></textarea>
                        </div>
                    </div>
                    <br>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label >Situação do agendamento</label>
                            <select v-model="situacaoAgendamentos" :disabled="this.dias<2 && this.tipousuario != 1" class="form-select" >
                                <option value="1"> Ativo </option>
                                <option value="2"> Em andamento </option>
                                <option value="9"> Finalizado </option>
                                <option value="10"> Cancelado </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label >Data de encerramento do agendamento</label>
                            <input :disabled="this.dias<2 && this.tipousuario != 1" type="datetime-local" class="form-control form-control" v-model="dataTermino" :min="dataAgendamento" >
                        </div> 
                    </div>

                    <br>        
                        <div class="form-group">
                            <button @click="editarAgendamento" class="btn btn-warning"
                            :disabled="( (this.servicosQuantidade==0 ) || this.iniciarTransacao)"
                            v-show ="this.dias>=2 || this.tipousuario == 1"
                            >Enviar modificações</button>
                        </div>
                        <br>
                        <div v-show="this.dias<2" class="alert alert-danger" role="alert">
                        Apenas o gerente pode alterar o agendamento quando a quantidade dias <br>
                        para a data do agendamento for menor que 2.<br>
                        intervalo atual : {{ this.dias }} dias.
                        </div>
                        
                    <br>
                </div>
            </fieldset>   
</template>