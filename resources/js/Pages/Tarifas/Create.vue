<template>
  <div>
    <Head title="Create Tarifa" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/tarifas">Tarifas</Link>
      <span class="text-rose-400 font-medium">/</span> Nuevo Tarifa
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.idconcepto" :error="form.errors.idconcepto" class="pb-8 pr-6 w-full lg:w-1/2" label="Concepto" />
          <text-input v-model="form.vigencia" :error="form.errors.vigencia" class="pb-8 pr-6 w-full lg:w-1/2" label="Vigencia" />
          <text-input v-model="form.valor_neto" :error="form.errors.valor_neto" class="pb-8 pr-6 w-full lg:w-1/2" label="Valor Neto/Mínimo" />
          <text-input v-model="form.valor_venta" :error="form.errors.valor_venta" class="pb-8 pr-6 w-full lg:w-1/2" label="Valor Venta" />
          <text-input v-model="form.idmoneda" :error="form.errors.idmoneda" class="pb-8 pr-6 w-full lg:w-1/2" label="Moneda" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-rose" type="submit">Crear Tarifa</loading-button>
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
        idconcepto: null,
        vigencia: null,
        valor_neto: null,
        valor_venta: null,
        idmoneda: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/tarifas')
    },
  },
}
</script>
