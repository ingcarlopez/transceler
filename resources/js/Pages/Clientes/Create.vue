<template>
  <div>
    <Head title="Create Cliente" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/clientes">Clientes</Link>
      <span class="text-rose-400 font-medium">/</span> Nuevo Cliente
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.nombre" :error="form.errors.nombre" class="pb-8 pr-6 w-full lg:w-1/2" label="Nombre" />
          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.identificacion" :error="form.errors.identificacion" class="pb-8 pr-6 w-full lg:w-1/2" label="Identificación" />
          <text-input v-model="form.dv" :error="form.errors.dv" class="pb-8 pr-6 w-full lg:w-1/2" label="Dígito/Verificación" />
          <text-input v-model="form.telefono" :error="form.errors.telefono" class="pb-8 pr-6 w-full lg:w-1/2" label="Telefono" />
          <text-input v-model="form.direccion" :error="form.errors.direccion" class="pb-8 pr-6 w-full lg:w-1/2" label="Direccion" />
          <text-input v-model="form.ciudad" :error="form.errors.ciudad" class="pb-8 pr-6 w-full lg:w-1/2" label="Ciudad" />
          <text-input v-model="form.zipcode" :error="form.errors.zipcode" class="pb-8 pr-6 w-full lg:w-1/2" label="Código Postal" />
<!--           <select-input v-model="form.country" :error="form.errors.country" class="pb-8 pr-6 w-full lg:w-1/2" label="Country">
            <option :value="null" />
            <option value="CA">Canada</option>
            <option value="US">United States</option>
          </select-input>
 -->          
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-rose" type="submit">Crear Cliente</loading-button>
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
        nombre: null,
        email: null,
        identificacion: null,
        dv: null,
        telefono: null,
        direccion: null,
        ciudad: null,
        zipcode: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/clientes')
    },
  },
}
</script>
