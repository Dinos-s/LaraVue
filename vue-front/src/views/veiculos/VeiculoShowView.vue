<script setup lang="ts">
    import AlertMessage from '@/components/AlertMessage.vue';
import axios from 'axios';
    import { ref, onMounted } from 'vue';
    import { useRoute } from 'vue-router';

    const route = useRoute()
    const veiculo = ref<any>(null)
    const loading = ref(true)
    const erroMsg = ref('')
    const successMsg = ref((Array.isArray(route.query.success) ? route.query.success[0] : route.query.success) || '')

    const loadVeiculo = async () => {
        loading.value = true
        erroMsg.value = ''
        veiculo.value = null

        try {
            const response = await axios.get(`http://localhost:8000/api/veiculos/${route.params.id}`)

            if (response.data.status === true) {
                veiculo.value = response.data.veiculo
            }
        } catch (error: any) {
            if (error.response && error.response.status === 404) {
                erroMsg.value = error.response.data.message
            } else {
                erroMsg.value = "Erro ao caregar as informações do usuário"
            }
        } finally {
            loading.value = false
        }
    }

    onMounted(() => {
        loadVeiculo()
    })
</script>

<template>
    <main class="p-6">
        <h1>Detalhes do Veículo</h1>
        <RouterLink to="/veiculos">Listagem de Veículos</RouterLink>
        <RouterLink v-if="veiculo" :to="{ name: 'veiculo.edit', params: { id: veiculo.id }}">Editar</RouterLink>

        <div v-if="loading">Carregando...</div>

        <!-- <div v-if="erroMsg" class="text-red-700">
            {{ erroMsg }}
        </div> -->
        <AlertMessage :message="erroMsg" type="danger" />

        <!-- <div v-if="successMsg" class="text-green-700">
            {{ successMsg }}
        </div> -->
        <AlertMessage :message="successMsg" type="success" />

        <div v-if="veiculo">
            <p><strong>Modelo: </strong>{{ veiculo.model }}</p>
            <p><strong>Ano: </strong>{{ veiculo.year }}</p>
            <p><strong>Criado em: </strong>{{ veiculo.created_at }}</p>
        </div>
    </main>
</template>