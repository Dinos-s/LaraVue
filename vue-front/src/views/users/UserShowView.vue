<script setup lang="ts">
    import axios from 'axios';
    import { onMounted, ref } from 'vue';
    import { useRoute } from 'vue-router';

    const route = useRoute()
    const user = ref<any>(null)
    const loading = ref(true)
    const errorMsg = ref('')
    const successMsg = ref( route.query.success || '')

    const loadUser = async () => {
        loading.value = true
        errorMsg.value = ''
        user.value = null

        try {
            const response = await axios.get(`http://localhost:8000/api/users/${route.params.id}`)
            
            if (response.data.status === true) {
                user.value = response.data.user
            }
            
        } catch (error: any) {
            if (error.response && error.response.status === 404) {
                errorMsg.value = error.response.data.message
            } else {
                errorMsg.value = "Erro ao caregar as informações do usuário"
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
        <h1>Detalhes do Usuário</h1>

        <RouterLink to="/users">Listagem de Usuários</RouterLink>
        <RouterLink v-if="user" :to="{ name: 'user.edit', params: { id: user.id }}">Editar</RouterLink>
        <RouterLink v-if="user" :to="{ name: 'user.edit-password', params: { id: user.id }}">Editar Senha</RouterLink>

        <div v-if="loading">
            Carregando...
        </div>

        <div v-if="errorMsg" class="text-red-700">
            {{ errorMsg }}
        </div>

        <div v-if="successMsg" class="text-green-700">
            {{ successMsg }}
        </div>

        <div v-if="user">
            <p><strong>Nome: </strong>{{ user.name }}</p>
            <p><strong>E-mail: </strong>{{ user.email }}</p>
            <p><strong>Criado em: </strong>{{ user.created_at }}</p>
        </div>
    </main>
</template>