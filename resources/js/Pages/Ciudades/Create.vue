<template>
  <div>
    <Head title="Create Ciudad" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/ciudades">Ciudades</Link>
      <span class="text-rose-400 font-medium">/</span> Nuevo Ciudad
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.idciudad" :error="form.errors.idciudad" class="pb-8 pr-6 w-full lg:w-1/2" label="ID Ciudad" />
          <text-input v-model="form.ciudad" :error="form.errors.ciudad" class="pb-8 pr-6 w-full lg:w-1/2" label="Ciudad" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-rose" type="submit">Crear Ciudad</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        idciudad: null,
        ciudad: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/ciudades')
    },
  },
}
</script>
