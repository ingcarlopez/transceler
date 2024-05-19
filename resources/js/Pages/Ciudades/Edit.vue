<template>
  <div>
    <Head :title="form.ciudad" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/ciudades">Ciudades</Link>
      <span class="text-rose-400 font-medium">/</span>
      {{ form.ciudad }}
    </h1>
    <trashed-message v-if="ciudad.deleted_at" class="mb-6" @restore="restore"> Este Ciudad ha sido eliminado. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.idciudad" :error="form.errors.idciudad" class="pb-8 pr-6 w-full lg:w-1/2" label="Id Ciudad" />
          <text-input v-model="form.ciudad" :error="form.errors.ciudad" class="pb-8 pr-6 w-full lg:w-1/2" label="Ciudad" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!ciudad.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Ciudad</button>
          <loading-button :loading="form.processing" class="btn-rose ml-auto" type="submit">Actualizar Ciudad</loading-button>
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
    ciudad: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        idciudad: this.ciudad.idciudad,
        ciudad: this.ciudad.ciudad,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/ciudades/${this.ciudad.idciudad}`)
    },
    destroy() {
      if (confirm('Está seguri que desea eliminar este ciudad?')) {
        this.$inertia.delete(`/ciudades/${this.ciudad.idciudad}`)
      }
    },
    restore() {
      if (confirm('Está seguri que desea restaurar este ciudad?')) {
        this.$inertia.put(`/ciudades/${this.ciudad.idciudad}/restore`)
      }
    },
  },
}
</script>
