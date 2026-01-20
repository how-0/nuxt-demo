<template>
  <a-form ref="formRef" :size="large" :model="form" :style="{width:'600px'}" @submit="handleTicketFormSubmit">
    <a-form-item field="name" label="Name" validate-trigger="blur">
      <a-input v-model="form.name" placeholder="please enter your name..." />
    </a-form-item>
    <a-form-item field="gender" label="Gender">
      <a-radio-group v-model="form.gender" validate-trigger="change">
        <a-radio value="male">Male</a-radio>
        <a-radio value="female">Female</a-radio>
      </a-radio-group>
    </a-form-item>
    <a-form-item field="inquiry" label="Inquiry" validate-trigger="blur">
      <a-textarea v-model="form.inquiry" auto-size />
    </a-form-item>
    <a-form-item field="status" label="Status" validate-trigger="blur">
      <a-select v-model="form.status" placeholder="Please select ..." allow-clear>
        <a-option value="new">New</a-option>
        <a-option value="processing">Processing</a-option>
        <a-option value="complete">Complete</a-option>
        <a-option value="cancel">Cancel</a-option>
      </a-select>
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
import { useSanctumClient } from '#imports'

const formRef = ref();
const errors = ref({});
const form = reactive({
  name: '',
  gender: '',
  inquiry: '',
  status: ''
})

async function handleTicketFormSubmit (){
  errors.value = {};
  try{
    const { data, error } = await useSanctumFetch('/api/ticketForm', {
      method: 'POST',
      body:{
        name: form.name,
        gender: form.gender,
        inquiry: form.inquiry,
        status: form.status,
      },
    })

    if (error.value) {
      if(error.value.statusCode === 422){
        errors.value = error.value.data.errors
        console.log("Full error object for new ticket: ", errors.value)
        if (errors.value.name) {
          formRef.value.setFields({
              name: {
                  status: "error",
                  message: errors.value.name[0],
              },
          });
        }
        if (errors.value.gender) {
          formRef.value.setFields({
              gender: {
                  status: "error",
                  message: errors.value.gender[0],
              },
          });
        }
        if (errors.value.inquiry) {
          formRef.value.setFields({
              inquiry: {
                  status: "error",
                  message: errors.value.inquiry[0],
              },
          });
        }
        if (errors.value.status) {
          formRef.value.setFields({
              status: {
                  status: "error",
                  message: errors.value.status[0],
              },
          });
        }
      }
      throw error.value;
    }

    console.log('Ticket data inserted into database:', data.value)
    await navigateTo('/dashboard')
    
  } catch(err){
    console.error('Ticket data insertion failed.' , err.data || err)
  }
}

</script>