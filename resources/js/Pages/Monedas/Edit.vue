<template>
  <div>
    <Head :title="form.moneda" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/monedas">Monedas</Link>
      <span class="text-rose-400 font-medium">/</span>
      {{ form.moneda }}
    </h1>
    <trashed-message v-if="moneda.deleted_at" class="mb-6" @restore="restore"> Este Moneda ha sido eliminado. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.idmoneda" :error="form.errors.idmoneda" class="pb-8 pr-6 w-full lg:w-1/2" label="Id Moneda" />
          <text-input v-model="form.moneda" :error="form.errors.moneda" class="pb-8 pr-6 w-full lg:w-1/2" label="Moneda" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!moneda.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Moneda</button>
          <loading-button :loading="form.processing" class="btn-rose ml-auto" type="submit">Actualizar Moneda</loading-button>
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
    moneda: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        idmoneda: this.moneda.idmoneda,
        moneda: this.moneda.moneda,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/monedas/${this.moneda.idmoneda}`)
    },
    destroy() {
      if (confirm('Está seguri que desea eliminar este moneda?')) {
        this.$inertia.delete(`/monedas/${this.moneda.idmoneda}`)
      }
    },
    restore() {
      if (confirm('Está seguri que desea restaurar este moneda?')) {
        this.$inertia.put(`/monedas/${this.moneda.idmoneda}/restore`)
      }
    },
  },
}
</script>
