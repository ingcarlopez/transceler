<template>
  <div>
    <Head :title="form.tarifa" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/tarifas">Tarifas</Link>
      <span class="text-rose-400 font-medium">/</span>
      {{ form.tarifa }}
    </h1>
    <trashed-message v-if="tarifa.deleted_at" class="mb-6" @restore="restore"> Este Tarifa ha sido eliminado. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.idconcepto" :error="form.errors.idconcepto" class="pb-8 pr-6 w-full lg:w-1/2" label="Concepto" />
          <text-input v-model="form.vigencia" :error="form.errors.vigencia" class="pb-8 pr-6 w-full lg:w-1/2" label="Vigencia" />
          <text-input v-model="form.valor_neto" :error="form.errors.valor_neto" class="pb-8 pr-6 w-full lg:w-1/2" label="Valor Neto/Mínimo" />
          <text-input v-model="form.valor_venta" :error="form.errors.valor_venta" class="pb-8 pr-6 w-full lg:w-1/2" label="Valor Venta" />
          <text-input v-model="form.idmoneda" :error="form.errors.idmoneda" class="pb-8 pr-6 w-full lg:w-1/2" label="Moneda" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!tarifa.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Tarifa</button>
          <loading-button :loading="form.processing" class="btn-rose ml-auto" type="submit">Actualizar Tarifa</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    tarifa: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        vigencia: this.tarifa.vigencia,
        valor_neto: this.tarifa.valor_neto,
        valor_venta: this.tarifa.valor_venta,
        idmoneda: this.tarifa.idmoneda,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/tarifas/${this.tarifa.idtarifa}`)
    },
    destroy() {
      if (confirm('Está seguro que desea eliminar esta tarifa?')) {
        this.$inertia.delete(`/tarifas/${this.tarifa.idtarifa}`)
      }
    },
    restore() {
      if (confirm('Está seguro que desea restaurar esta tarifa?')) {
        this.$inertia.put(`/tarifas/${this.tarifa.idtarifa}/restore`)
      }
    },
  },
}
</script>
