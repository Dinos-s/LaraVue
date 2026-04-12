<script setup lang="ts">
  import AlertMessage from '@/components/AlertMessage.vue';
import DeleteButton from '@/components/DeleteButton.vue';
import axios from 'axios';
  import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

  const route = useRoute()
  const users = ref<any[]>([])
  const loading = ref(false)
  const page = ref(1) // Current page, default to 1 for the first page
  const lastPage = ref(1)
  const errorMsg = ref('')
  const successMsg = ref((Array.isArray(route.query.success) ? route.query.success[0] : route.query.success) || '')

  const loadUsers = async () => {
    loading.value = true

    try {
      const response = await axios.get(`http://localhost:8000/api/users?page${page.value}`)

      console.log(response.data.users.data);
      users.value = response.data.users.data

      // atualiza a quantidade de páginas
      lastPage.value = response.data.users.last_page
    } catch (error) {
      console.error("Falha ao listar os usuários: ", error)
    } finally {
      loading.value = false
    }
  }

  const nextPage = () => {
    if (page.value < lastPage.value) {
      page.value++
      loadUsers()
    }
  }

  const prevPage = () => {
    if (page.value > 1) {
      page.value--
      loadUsers()
    }
  }

  onMounted(
    loadUsers
  )
</script>

<template>
  <main class="p-6">
    <h1>Listagem de Usuários</h1>

    <RouterLink :to="{ name: 'user.create' }">Criar novo usuário</RouterLink>

    <div v-if="loading">
      Carregando...
    </div>

    <AlertMessage :message="errorMsg" type="danger" />
    <AlertMessage :message="successMsg" type="success" />

    <div v-if="!loading">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td colspan="3">
              <RouterLink :to="{ name: 'user.show', params: { id: user.id }}">Visualizar</RouterLink>
              <RouterLink :to="{ name: 'user.edit', params: { id: user.id } }">Editar</RouterLink>
              <DeleteButton 
              :id="user.id" 
              endpoint="http://localhost:8000/api/users"
              @deleted="successMsg = $event; errorMsg = '';
              loadUsers()" @error="errorMsg = $event; successMsg = ''" />
            </td>
          </tr>
        </tbody>
      </table>

      <div>
        <button @click="prevPage" :disabled="page === 1">Anterior</button>

        <span>{{ page }} de {{ lastPage }}</span>

        <button @click="nextPage" :disabled="page === lastPage">Próximo</button>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
