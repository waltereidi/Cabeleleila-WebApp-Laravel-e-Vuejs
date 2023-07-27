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
                'modalCadastroCliente' : param ,
                'esconderModal' : !param 
                    }
        }
    }
  }
</script>
<style scoped>
    .modalCadastroCliente{
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
                      <legend v-on:click="abrirModal= abrirModal == false">Cadastrar novo cliente</legend>
                    <div v-bind:class="getClass(abrirModal)">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Nome</label>
                            <input type="text" class="form-control form-control-sm" name="nome" placeholder="Nome completo">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" placeholder="Email">
                        </div>
                        
                    </div>

                    <div class="row">
                            <div class="form-group col-md-6">
                            <label>Cpf</label>
                            <input type="text" class="form-control form-control-sm" name="cpf" placeholder="000.000.000-00">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Rg</label>
                            <input type="text" class="form-control form-control-sm" name="rg" placeholder="00.000.000-0">
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Telefone</label>
                            <input type="text" class="form-control form-control-sm" name="telefone" placeholder="00 00000-0000">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Telefone 2</label>
                            <input type="text" class="form-control form-control-sm" name="telefone2" placeholder="00 00000-0000">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Data de nascimento</label>
                            <input type="date" class="form-control form-control-sm" name="datanascimento" >
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label>Observações</label>
                            <textarea class="form-control" name="observacao" rows="3"></textarea>
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