<template>
  <div>
    <Head title="Create Pais" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/paises">Paises</Link>
      <span class="text-rose-400 font-medium">/</span> Nuevo Pais
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.idpais" :error="form.errors.idpais" class="pb-8 pr-6 w-full lg:w-1/2" label="ID Pais" />
          <text-input v-model="form.pais" :error="form.errors.pais" class="pb-8 pr-6 w-full lg:w-1/2" label="Pais" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-rose" type="submit">Crear Pais</loading-button>
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
        idpais: null,
        pais: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/paises')
    },
  },
}
</script>
