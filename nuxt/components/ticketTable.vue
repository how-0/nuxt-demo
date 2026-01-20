<template>
  <a-table :data="tickets" style="margin-top: 30px">
    <template #columns>
      <a-table-column title="id" data-index="id" v-if="false"></a-table-column>
      <a-table-column title="Name" data-index="name"></a-table-column>
      <a-table-column title="Gender" data-index="gender"></a-table-column>
      <a-table-column title="Inquiry" data-index="inquiry"></a-table-column>
      <a-table-column title="Status" data-index="status"></a-table-column>
      <a-table-column title="Action">
        <template #cell="{ record }">
          <a-space>
          <a-button @click="handleTicketDeletion(record.id)">Delete</a-button>
          <a-button @click="handleTicketEdit(record.id)">Edit</a-button>
          </a-space>
        </template>
      </a-table-column>
    </template>
  </a-table>
</template>

<script setup lang = "ts">
import { ref, onMounted } from 'vue';
import { useSanctumFetch, navigateTo } from '#imports';

const tickets = ref([]);

async function handleTicketRetrieval(){
  try{
    const { data } = await useSanctumFetch('/api/tickets');
    tickets.value = data.value?.data || data.value || [];
  }catch(err){
    console.error("Failed to fetch tickets", err)
  }
}

async function handleTicketDeletion(id:number){
  try{
    await useSanctumFetch(`/api/tickets/${id}`, {method: 'DELETE'});
    await handleTicketRetrieval();
  }catch(err){
    console.error("Failed to delete tickets", err)
  }
}

async function handleTicketEdit(id:number){
  navigateTo(`/tickets/${id}/edit`)
}

onMounted(handleTicketRetrieval)

</script>