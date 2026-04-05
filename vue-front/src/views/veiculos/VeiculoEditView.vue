<script setup lang="ts">
    import axios from 'axios';
    import { onMounted, ref } from 'vue';
    import { useRoute, useRouter } from 'vue-router';

    const route = useRoute()
    const router = useRouter()
    const model = ref('')
    const year = ref('')
    const errors = ref<any>({})
    const successMsg = ref('')
    const loading = ref(false)

    const submitForm = async () => {
        loading.value = true
        successMsg.value = ''
        errors.value = {}

        try {
            const response = await axios.put(`http://localhost:8000/api/veiculos/${route.params.id}`, {
                model: model.value,
                year: year.value
            })

            if (response.data.status === true) {
                router.push(
                    { 
                        name: 'veiculo.show', 
                        params: { id: response.data.veiculo.id },
                        query: { success: response.data.message }
                    }
                )
            }

        } catch (error: any) {
            if (error.response && error.response.erros) {
                errors.value = error.response.data.errors
            } else {
                errors.value = {
                    general: ['Ocorreu um erro ao processar a requisição. Tente novamente.']
                }
            }
        } finally {
            loading.value = false
        }
    }

    const loadVeiculo = async () => {
        loading.value = true
        successMsg.value = ''
        errors.value = {}

        try {
            const response = await axios.get(`http://localhost:8000/api/veiculos/${route.params.id}`)

            if (response.data.status === true) {
                model.value = response.data.veiculo.model
                year.value = response.data.veiculo.year
            }
            console.log(response.data.veiculo);
            
        } catch (error: any) {
            if (error.response && error.response.erros) {
                errors.value = error.response.data.message
                
            } else {
                errors.value = {
                    general: ['Ocorreu um erro ao processar a requisição. Tente novamente.']
                }
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
        <h1>Editar Veículo</h1>

        <RouterLink to="/veiculos">Listagem de Veículos</RouterLink>
        <RouterLink :to="{ name: 'veiculo.show', params: { id: route.params.id }}">Visualizar</RouterLink>

        <form @submit.prevent="submitForm">

            <div>
                <label>Modelo:</label>
                <input type="text" placeholder="Modelo do veículo" v-model="model" class="w-full border rounded px-3 py-2 focus:outline-none">

                <div v-if="errors.model" class="text-red-700">
                    {{ errors.model[0] }}
                </div>
            </div>

            <div>
                <label>Ano:</label>
                <input type="text" placeholder="Ano do veículo" v-model="year" class="w-full border rounded px-3 py-2 focus:outline-none">

                <div v-if="errors.year" class="text-red-700">
                    {{ errors.year[0] }}
                </div>
            </div>

            <button type="submit" :disabled="loading" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition disabled:bg-gray-400">
                {{ loading ? 'Carregando...' : 'Salvar' }}
            </button>
        </form>
    </main>
</template>