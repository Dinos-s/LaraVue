<script setup lang="ts">
  import axios from 'axios';
  import { onMounted, ref } from 'vue';

  const users = ref<any[]>([])
  const loading = ref(false)
  const page = ref(1) // Current page, default to 1 for the first page
  const lastPage = ref(1)

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

    <div v-if="loading">
      Carregando...
    </div>

    <div v-else>
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
              <RouterLink :to="{ name: 'user.create' }">Criar novo usuário</RouterLink>
              <RouterLink :to="{ name: 'user.edit', params: { id: user.id } }">Editarr</RouterLink>
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
