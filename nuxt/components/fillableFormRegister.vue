<template>
  <a-form ref="formRef" :model="form" :style="{width:'600px'}"  @submit="handleRegisterFormSubmit" layout="horizontal" :label-col-props="{ span: 6, offset: 0 }" :wrapper-col-props="{ span: 18, offset: 0 }">
    <a-form-item field="name" label="Username">
      <a-input v-model="form.name" placeholder="please enter your username..." validate-trigger="blur"/>
    </a-form-item>
    <a-form-item field="email" label="email">
      <a-input v-model="form.email" placeholder="please enter your email..." validate-trigger="blur"/>
    </a-form-item>
    <a-form-item field="password" label="password">
      <a-input-password v-model="form.password" placeholder="please enter your password..." validate-trigger="blur"/>
    </a-form-item>
    <a-form-item field="password_confirmation" label="confirm password">
      <a-input-password v-model="form.password_confirmation" placeholder="please confirm your password..." validate-trigger="blur"/>
    </a-form-item>
    <a-form-item>
      <a-space>
        <a-button html-type="submit">Submit</a-button>
        <a-button @click="$refs.formRef.resetFields()">Reset</a-button>
      </a-space>
    </a-form-item>
  </a-form>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useSanctumFetch } from '#imports'

const formRef = ref();
const errors = ref({});
const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

async function handleRegisterFormSubmit (){
  errors.value = {};
  try{
    const { data, error } = await useSanctumFetch('/api/register', {
      method: 'POST',
      body:{
        name: form.name,
        email: form.email,
        password: form.password,
        password_confirmation: form.password_confirmation,
      },
    })

    if (error.value) {
      if (error.value.statusCode === 422){
        errors.value = error.value.data.errors;
        console.log("Full Object error for registering", errors.value);
        if (errors.value.name){
          formRef.value.setFields({
            name: {
              status:'error',
              message: errors.value.name[0],
            },
          });
        }
        if (errors.value.email){
          formRef.value.setFields({
            email: {
              status: 'error',
              message: errors.value.email[0],
            },
          });
        }
        if (errors.value.password){
          formRef.value.setFields({
            password: {
              status: 'error',
              message: errors.value.password[0],
            },
          });
        }
        if (errors.value.password_confirmation){
          formRef.value.setFields({
            password_confirmation: {
              status: 'error',
              message: errors.value.password_confirmation[0],
            },
          });
        }
      }
      throw error.value;
    }

    console.log('Data inserted into database:', data.value)
    
  } catch(err){
    console.error('Database insertion failed.' , err.data || err)
  }
}

</script>

