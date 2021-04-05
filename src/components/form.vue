<template>
  <div>
    <ValidationObserver ref="observer" v-slot="{handleSubmit}">
      <form class="form_wrap" @submit.prevent="handleSubmit(sendSMS)">
        <template v-if="alert">
          <div v-if="alert.status" class="alert alert-success">{{alert.message}}</div>
          <div v-else class="alert alert-danger">{{alert.message}}</div>
        </template>

        <h1>Enviar SMS</h1>

        <p>Escreva o numero desejado</p>

        <div class="form-group">
          <ValidationProvider rules="required" name="phone" v-slot="{errors}">
            <input type="text" v-model="sms.phone" class="form-control" placeholder="Numero do Telefone">
            <span>{{errors[0]}}</span>
          </ValidationProvider>
        </div>

        <div class="form-group">
          <ValidationProvider rules="required" name="message" v-slot="{errors}">
            <textarea class="form-control" v-model="sms.message" placeholder="Mensagem"></textarea>
            <span>{{errors[0]}}</span>
          </ValidationProvider>
          <small v-if="sms.message">{{messageLength}} Caracteres restantes</small>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-success" >Enviar SMS</button>
        </div>

      </form>
    </ValidationObserver>
  </div>
</template>

<script>
import { parsePhoneNumberFromString } from "libphonenumber-js";

import { ValidationProvider, ValidationObserver } from "vee-validate/dist/vee-validate.full";

import Cleave from 'vue-cleave-component';
import 'cleave.js/dist/addons/cleave-phone.au.js';

export default {

  components:{
    ValidationObserver,
    ValidationProvider
    
  },

  data(){
      return{
          sms:{
              phone:null,
              formattedPhone:null,
              message:null,
          },
          phoneoptions:{
            phone:true,
            phoneRegionCode: 'BR',
          },
          alert:null,
          sending:false,
      }
  },
  methods:{
    sendSMS(){
      if (this.sms.message.length > 160){

        this.sendError(false,'Limete sua mensagem até 160 caracteres');

        return;
      }

      const phoneNumber = parsePhoneNumberFromString(this.sms.phone, 'BR');

      if(!phoneNumber.isValid()){

        this.sendError(false,'Numero de telefone invalido');

        return;
      }
      //envia para o servidor
      this.sms.formattedPhone = phoneNumber.number;
      this.sending = true;

      axios.post('sendsms.php',this.sms).then(res => {
        this.alert = res.data;

      }).catch(err =>{

      })

    },

    sendError(status,message){
      this.alert = {
        status: status,
        message: 'Numero de telefone invalido'
      };
    }
  },
  computed:{
    messageLength(){
      var limit = 160;
      var length = limit - this.sms.message.length;

      if(length < 0 ){
        return 0;
      }

      return length;
    }
  }
}
</script>

