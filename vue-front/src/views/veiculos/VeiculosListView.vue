<script setup lang="ts">
    import axios from 'axios';
import { onMounted, ref } from 'vue';

    const veiculos = ref<any[]>([])
    const loading = ref(false)
    const page = ref(1) // Current page, default to 1 for the first page
    const lastPage = ref(1)

    const loadVeiculos = async () => {
        loading.value = true

        try {
            const response = await axios.get(`http://localhost:8000/api/veiculos?page=${page.value}`)

            console.log(response.data.veiculos.data);
            veiculos.value = response.data.veiculos.data 
            
            // atualiza a quantidade de páginas
            lastPage.value = response.data.veiculos.last_page
        } catch (error) {
            console.error("Falha ao listar os veículos: ",error)
        } finally {
            loading.value = false
        }
    }

    const nextPage = () => {
        if (page.value < lastPage.value) {
            page.value++
            loadVeiculos()
        }
    }

    const prevPage = () => {
        if (page.value > 1) {
            page.value--
            loadVeiculos()
        }
    }

    onMounted(
        loadVeiculos
    )
</script>

<template>
    <main class="p-6">
        <h1>Listagem de Veículos</h1>

        <div v-if="loading">
            Carregando...
        </div>

        <div v-else>
            <table>
                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="veiculo in veiculos" :key="veiculo.id">
                        <td>{{ veiculo.model }}</td>
                        <td>{{ veiculo.year }}</td>
                        <td colspan="3">
                            <RouterLink :to="{ name: 'veiculo.show', params: { id: veiculo.id }}">Visualizar</RouterLink>
                            <RouterLink :to="{ name: 'veiculo.create' }">Criar novo Veiculo</RouterLink>
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