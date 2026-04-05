<script setup lang="ts">
    import axios from 'axios';
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';

    const router = useRouter()
    const name = ref('')
    const email = ref('')
    const password = ref('')
    const password_confirmation = ref('')
    const errors = ref<any>({})
    const successMsg = ref('')
    const loading = ref(false)

    const submitForm = async () => {
        loading.value = true
        successMsg.value = ''
        errors.value = {}

        try {
            const response = await axios.post('http://localhost:8000/api/users', {
                name: name.value,
                email: email.value,
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
</script>

<template>
    <main class="p-6">
        <h1>Criando Usuário</h1>

        <RouterLink to="/users">Listagem de Usuários</RouterLink>

        <form @submit.prevent="submitForm">

            <div>
                <label>Name:</label>
                <input type="text" v-model="name" class="w-full border rounded px-3 py-2 focus:outline-none" placeholder="O nome completo">

                <div v-if="errors.name" class="text-red-700">
                    {{ errors.name[0] }}
                </div>
            </div>

            <div>
                <label>E-mail:</label>
                <input type="email" placeholder="E-mail do usuário" v-model="email" class="w-full border rounded px-3 py-2 focus:outline-none">

                <div v-if="errors.email" class="text-red-700">
                    {{ errors.email[0] }}
                </div>
            </div>

            <div>
                <label>Senha:</label>
                <input type="password" placeholder="Senha" v-model="password" class="w-full border rounded px-3 py-2 focus:outline-none">

                <div v-if="errors.password" class="text-red-700">
                    {{ errors.password[0] }}
                </div>
            </div>

            <div>
                <label>Confirme a Senha</label>
                <input type="password" placeholder="Confirma Senha" v-model="password_confirmation" class="w-full border rounded px-3 py-2 focus:outline-none">

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