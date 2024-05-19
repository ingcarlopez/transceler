<template>
  <div>
    <Head title="Inicio" />
    <h1 class="mb-8 text-3xl font-bold">Inicio</h1>
    <p class="mb-8 leading-normal">¡Hola a todos! Bienvenidos a nuestro Sistema de Información</p>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Head,
  },
  layout: Layout,
}
</script>
