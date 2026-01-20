<template>
    <a-form
        ref="formRef"
        :model="form"
        :style="{ width: '600px' }"
        @submit="handleTicketFormUpdate"
    >
        <a-form-item label="Name" field="name">
            <a-input
                v-model="form.name"
                placeholder="please enter your name..."
            />
        </a-form-item>
        <a-form-item label="Gender" field="gender">
            <a-radio-group v-model="form.gender">
                <a-radio value="male">Male</a-radio>
                <a-radio value="female">Female</a-radio>
            </a-radio-group>
        </a-form-item>
        <a-form-item label="Inquiry" field="inquiry">
            <a-textarea v-model="form.inquiry" auto-size />
        </a-form-item>
        <a-form-item label="Status" field="status">
            <a-select
                v-model="form.status"
                placeholder="Please select ..."
                allow-clear
            >
                <a-option value="new">New</a-option>
                <a-option value="processing">Processing</a-option>
                <a-option value="complete">Complete</a-option>
                <a-option value="cancel">Cancel</a-option>
            </a-select>
        </a-form-item>
        <a-form-item>
            <a-space>
                <a-button html-type="submit">Update</a-button>
                <a-button @click="$refs.formRef.resetFields()">Reset</a-button>
            </a-space>
        </a-form-item>
    </a-form>
</template>

<script setup>
import { reactive, onMounted, ref } from "vue";
import { useRoute, useSanctumFetch } from "#imports";

const formRef = ref();
const errors = ref({});
const route = useRoute();
const id = route.params.id;

const form = reactive({
    name: "",
    gender: "",
    inquiry: "",
    status: "",
});

async function fetchTicketData() {
    console.log("Fetching ticket for ID:", id);
    try {
        const { data, status, error, refresh } = await useSanctumFetch(
            `/api/tickets/${id}`,
        );
        console.log("Full Data Object:", data.value);
        console.log("Status:", status.value);
        console.log("Error:", error.value);
        console.log("Refresh:", refresh.value);

        if (error.value) {
            console.error("Fetch Error Object:", error.value);
            console.error("Error Status Code:", error.value.statusCode);
            console.error("Error Message:", error.value.message);
            return;
        }

        const ticket = data.value;

        form.name = ticket.name;
        form.gender = ticket.gender;
        form.inquiry = ticket.inquiry;
        form.status = ticket.status;
    } catch (err) {
        console.error("Data Fetched Failed", err.data || err);
    }
}

async function handleTicketFormUpdate() {
    errors.value = {};
    console.log("Submitting update for ID:", id);
    console.log("Payload:", { ...form });
    try {
        const { data, error } = await useSanctumFetch(`/api/tickets/${id}`, {
            method: "PUT",
            body: {
                name: form.name,
                gender: form.gender,
                inquiry: form.inquiry,
                status: form.status,
            },
        });

        if (error.value) {
            if (error.value.statusCode === 422) {
                errors.value = error.value.data.errors;
                console.log("Full Object:", errors.value);
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
            } else {
                console.error("Server Error:", error.value.data);
            }
            throw error.value;
        }
        console.log("error message ", errors.value);
        console.log("Ticket data updated into database:", data.value);
        await navigateTo("/dashboard");
    } catch (err) {
        console.error("Ticket data insertion failed.", err.data || err);
    }
}

onMounted(fetchTicketData);
</script>
