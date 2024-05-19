<template>
  <div>
    <Head :title="form.pais" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/paises">Paises</Link>
      <span class="text-rose-400 font-medium">/</span>
      {{ form.pais }}
    </h1>
    <trashed-message v-if="pais.deleted_at" class="mb-6" @restore="restore"> Este Pais ha sido eliminado. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.idpais" :error="form.errors.idpais" class="pb-8 pr-6 w-full lg:w-1/2" label="Id Pais" />
          <text-input v-model="form.pais" :error="form.errors.pais" class="pb-8 pr-6 w-full lg:w-1/2" label="Pais" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!pais.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Pais</button>
          <loading-button :loading="form.processing" class="btn-rose ml-auto" type="submit">Actualizar Pais</loading-button>
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
    pais: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        idpais: this.pais.idpais,
        pais: this.pais.pais,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/paises/${this.pais.idpais}`)
    },
    destroy() {
      if (confirm('Está seguri que desea eliminar este pais?')) {
        this.$inertia.delete(`/paises/${this.pais.idpais}`)
      }
    },
    restore() {
      if (confirm('Está seguri que desea restaurar este pais?')) {
        this.$inertia.put(`/paises/${this.pais.idpais}/restore`)
      }
    },
  },
}
</script>
