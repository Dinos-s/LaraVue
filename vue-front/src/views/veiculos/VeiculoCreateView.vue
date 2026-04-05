<script setup lang="ts">
    import axios from 'axios';
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';

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
            const response = await axios.post('http://localhost:8000/api/veiculos', {
                model: model.value,
                year: year.value
            })

            if (response.data.status === true) {
                router.push(
                    { 
                        name: 'veiculo.show', 
                        params: { id: response.data.veiculo.id },
                        query: { successMsg: response.data.message }
                    }
                )
            }

        } catch (error: any) {
            if (error.response && error.response.status === 400 || error.response.status === 422) {
                errors.value = error.response.data.errors
            } else {
                console.error(error)
            }
        } finally {
            loading.value = false
        }
    }
</script>

<template>
    <main class="p-6">
        <h1>Criando Veículo</h1>

        <RouterLink to="/veiculos">Listagem de Veículos</RouterLink>

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