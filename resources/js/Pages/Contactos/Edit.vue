<template>
  <div>
    <Head :title="`${form.nombres} ${form.apellidos}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/contactos">Contactos</Link>
      <span class="text-rose-400 font-medium">/</span>
      {{ form.nombres }} {{ form.apellidos }}
    </h1>
    <trashed-message v-if="contacto.deleted_at" class="mb-6" @restore="restore"> This contacto has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.nombres" :error="form.errors.nombres" class="pb-8 pr-6 w-full lg:w-1/2" label="Nombres" />
          <text-input v-model="form.apellidos" :error="form.errors.apellidos" class="pb-8 pr-6 w-full lg:w-1/2" label="Apellidos" />
          <select-input v-model="form.idcliente" :error="form.errors.idcliente" class="pb-8 pr-6 w-full lg:w-1/2" label="Cliente">
            <option :value="null" />
            <option v-for="cliente in clientes" :key="cliente.idcliente" :value="cliente.idcliente">{{ cliente.cliente }}</option>
          </select-input>
          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.telefono" :error="form.errors.telefono" class="pb-8 pr-6 w-full lg:w-1/2" label="Telefono" />
          <text-input v-model="form.direccion" :error="form.errors.direccion" class="pb-8 pr-6 w-full lg:w-1/2" label="Direccion" />
          <text-input v-model="form.ciudad" :error="form.errors.ciudad" class="pb-8 pr-6 w-full lg:w-1/2" label="Ciudad" />
          <text-input v-model="form.zipcode" :error="form.errors.zipcode" class="pb-8 pr-6 w-full lg:w-1/2" label="Código Postal" />

<!--           <text-input v-model="form.region" :error="form.errors.region" class="pb-8 pr-6 w-full lg:w-1/2" label="Province/State" />
          <select-input v-model="form.country" :error="form.errors.country" class="pb-8 pr-6 w-full lg:w-1/2" label="Country">
            <option :value="null" />
            <option value="CA">Canada</option>
            <option value="US">United States</option>
          </select-input>
 -->          
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!contacto.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Contacto</button>
          <loading-button :loading="form.processing" class="btn-rose ml-auto" type="submit">Actualizar Contacto</loading-button>
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
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    contacto: Object,
    clientes: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        nombres: this.contacto.nombres,
        apellidos: this.contacto.apellidos,
        idcliente: this.contacto.idcliente,
        email: this.contacto.email,
        telefono: this.contacto.telefono,
        direccion: this.contacto.direccion,
        ciudad: this.contacto.ciudad,
        zipcode: this.contacto.zipcode,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/contactos/${this.contacto.idcontacto}`)
    },
    destroy() {
      if (confirm('Está seguri que desea eliminar este contacto?')) {
        this.$inertia.delete(`/contactos/${this.contacto.idcontacto}`)
      }
    },
    restore() {
      if (confirm('Está seguri que desea restaurar este contacto?')) {
        this.$inertia.put(`/contactos/${this.contacto.idcontacto}/restore`)
      }
    },
  },
}
</script>
