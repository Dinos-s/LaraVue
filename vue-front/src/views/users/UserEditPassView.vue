<script setup lang="ts">
    import axios from 'axios';
    import { onMounted, ref } from 'vue';
    import { useRoute, useRouter } from 'vue-router';

    const route = useRoute()
    const router = useRouter()
    const password = ref('')
    const password_confirmation = ref('')
    const errors = ref<any>({})
    const successMsg = ref('')
    const loading = ref(true)

    const submitForm = async () => {
        loading.value = true
        successMsg.value = ''
        errors.value = {}

        try {
            const response = await axios.put(`http://localhost:8000/api/users/${route.params.id}/password`, {
                password: password.value,
                password_confirmation: password_confirmation.value
            })

            if (response.data.status === true) {
                router.push(
                    { 
                        name: 'user.show', 
                        params: { id: response.data.user.id },
                        query: { success: response.data.message }
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

    const loadUser = async () => {        
        loading.value = true
        successMsg.value = ''
        errors.value = {}

        try {
            const response = await axios.get(`http://localhost:8000/api/users/${route.params.id}`)

            if (response.data.status === true) {}        
        } catch (error: any) {
            if (error.response && error.response.status === 404) {
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
        loadUser()
    })
</script>

<template>
    <main class="p-6">
        <h1>Trocar Senha do Usuário</h1>

        <RouterLink to="/users">Listagem de Usuários</RouterLink>
        <RouterLink :to="{ name: 'user.show', params: { id: route.params.id } }">Visualizar</RouterLink>

        <form @submit.prevent="submitForm">

            <div>
                <label>Senha:</label>
                <input type="password" v-model="password" class="w-full border rounded px-3 py-2 focus:outline-none" placeholder="O nome completo">

                <div v-if="errors.password" class="text-red-700">
                    {{ errors.password[0] }}
                </div>
            </div>

            <div>
                <label>Confirme a Senha:</label>
                <input type="password" placeholder="E-mail do usuário" v-model="password_confirmation" class="w-full border rounded px-3 py-2 focus:outline-none">

                <div v-if="errors.password_confirmation" class="text-red-700">
                    {{ errors.password_confirmation[0] }}
                </div>
            </div>
           
            <button type="submit" :disabled="loading" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition disabled:bg-gray-400">
                {{loading ? 'Carregando...' : 'Salvar'}}
            </button>
        </form>
    </main>
</template>