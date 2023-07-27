<script>
    import axios from 'axios';

  export default {
   
    data() {
        return {
            abrirModal : false ,
            token : ''
        }
    }, 
    methods:{
        getClass(param) {
            return {
                'modalCadastroServicos' : param ,
                'esconderModal' : !param 
                    }
        }
    }
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
                      <legend v-on:click="abrirModal= abrirModal == false">Cadastrar novo serviço</legend>
                    <div v-bind:class="getClass(abrirModal)">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label >Nome</label>
                            <input type="text" class="form-control form-control-sm" name="nome" placeholder="Nome do serviço">
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label >Tempo estimado</label>
                            <input type="time" class="form-control form-control-sm" value="00:30:00" name="tempoestimado">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Preço R$</label>
                            <input type="number" step="0.01" value="1.00" class="form-control form-control-sm" name="preco">
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="form-group">
                            <label >Descrição</label>
                            <textarea class="form-control" name="descricao" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <br>        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cadastrar cliente</button>
                        </div>
                    <br>
                </div>
            </fieldset>   
</template>