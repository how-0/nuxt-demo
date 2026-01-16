<template>
  <a-form ref="formRef" :rules="rules" :model="form" :style="{width:'600px'}" @submit="handleRegisterFormSubmit">
    <a-form-item field="name" label="Username" validate-trigger="blur">
      <a-input v-model="form.name" placeholder="please enter your username..." />
    </a-form-item>
    <a-form-item field="email" label="email">
      <a-input v-model="form.email" placeholder="please enter your email..." />
    </a-form-item>
    <a-form-item field="password" label="密码" validate-trigger="blur">
      <a-input-password v-model="form.password" placeholder="please enter your password..." />
    </a-form-item>
    <a-form-item field="password_confirmation" label="Confirm Password" validate-trigger="blur">
      <a-input-password v-model="form.password_confirmation" placeholder="please confirm your password..." />
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
import { Message } from '@arco-design/web-vue'
import { useSanctumClient } from '#imports'

const formRef = ref(null)
const client = useSanctumClient()
const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

async function handleRegisterFormSubmit (){
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
      throw error.value;
    }

    console.log('Data inserted into database:', data.value)
    
  } catch(err){
    console.error('Database insertion failed.' , err.data || err)
  }
}

const rules = {
  name: [{ required: true, message: 'Username is required' }],
  email: [{ required: true, type: 'email', message: 'Valid email is required' }],
  password: [{ required: true, message: 'Password is required' }],
  password_confirmation: [
    { required: true, message: 'Please confirm' },
    {
      validator: (value, cb) => {
        if (value !== form.password) cb('Passwords do not match')
        else cb()
      }
    }
  ]
}
</script>

