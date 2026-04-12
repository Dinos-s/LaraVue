<script setup lang="ts">
    import { ref, watch } from 'vue';

    const props = defineProps<{
        message: string | null
        type?: 'primary' | 'info' | 'success' | 'warning' | 'danger'
        duration?: number
    }>()

    const visible = ref(false)

    watch(
        () => props.message,

        (msg) => {

            if(msg) {
                visible.value = true
            }

            if(props.duration !== 0) {
                setTimeout(() => (visible.value = false), 
                    props.duration ?? 4000
                )
            }
        },

        {immediate: true}
    )
</script>

<template>
    <Transition name="fade">
        <div v-if="visible && message" :class="[
            type === 'primary' && 'alert-primary',
            type === 'info' && 'alert-info',
            type === 'success' && 'alert-success',
            type === 'warning' && 'alert-warning',
            type === 'danger' && 'alert-danger',
        ]">
            {{ message }}
        </div>
    </Transition>
</template>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.3s;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
</style>