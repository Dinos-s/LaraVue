<script setup lang="ts">
    import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

    const props = defineProps<{
        id: number | string
        endpoint: string
        redirectAfterDelete?: boolean
        redirectRoute?: string
    }>()

    const emit = defineEmits(['deleted', 'error'])

    const loading = ref(false)
    const router = useRouter()
    const deleteItem = async () => {
        const comfirmation = confirm('Tem certeza que deseja excluir?')

        if (!comfirmation) return

        loading.value = true

        try {
            await axios.delete(`${props.endpoint}/${props.id}`)

            emit('deleted', 'Registro excluido com sucesso')

            if (props.redirectAfterDelete) {
                router.push({ 
                    name: props.redirectRoute ?? "home",
                    query: {
                        success: 'Registro excluido com sucesso'
                    }
                })
            } else {
                emit('deleted', 'Falha ao apagar registro')
            }
        } catch (error) {
            console.error(error)
            emit('error', "Erro ao apagar registro")
        } finally {
            loading.value = false
        }
    }
</script>

<template>
    <button @click="deleteItem" :disabled="loading">
        {{ loading ? 'Apagando...' : 'Excluir'}}
    </button>
</template>