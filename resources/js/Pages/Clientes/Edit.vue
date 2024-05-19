<template>
  <div>
    <Head :title="form.cliente" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/clientes">Clientes</Link>
      <span class="text-rose-400 font-medium">/</span>
      {{ form.cliente }}
    </h1>
    <trashed-message v-if="cliente.deleted_at" class="mb-6" @restore="restore"> Este Cliente ha sido eliminado. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.cliente" :error="form.errors.cliente" class="pb-8 pr-6 w-full lg:w-1/2" label="Nombre" />
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
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!cliente.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Cliente</button>
          <loading-button :loading="form.processing" class="btn-rose ml-auto" type="submit">Actualizar Cliente</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 text-2xl font-bold">Contactos</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Nombres</th>
          <th class="pb-4 pt-6 px-6">Apellidos</th>
          <th class="pb-4 pt-6 px-6">Email</th>
          <th class="pb-4 pt-6 px-6">Teléfono</th>
          <th class="pb-4 pt-6 px-6">Dirección</th>
          <th class="pb-4 pt-6 px-6">Ciudad</th>
        </tr>
        <tr v-for="contacto in cliente.contactos" :key="contacto.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              {{ contacto.nombres }}
              <icon v-if="contacto.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              {{ contacto.apellidos }}
              <icon v-if="contacto.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              {{ contacto.email }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              {{ contacto.telefono }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              {{ contacto.direccion }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              {{ contacto.ciudad }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="cliente.contactos.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No contactos found.</td>
        </tr>
      </table>
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
    cliente: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        cliente: this.cliente.cliente,
        email: this.cliente.email,
        identificacion: this.cliente.identificacion,
        dv: this.cliente.dv,
        telefono: this.cliente.telefono,
        direccion: this.cliente.direccion,
        ciudad: this.cliente.city,
        zipcode: this.cliente.zipcode,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/clientes/${this.cliente.idcliente}`)
    },
    destroy() {
      if (confirm('Está seguri que desea eliminar este cliente?')) {
        this.$inertia.delete(`/clientes/${this.cliente.idcliente}`)
      }
    },
    restore() {
      if (confirm('Está seguri que desea restaurar este cliente?')) {
        this.$inertia.put(`/clientes/${this.cliente.idcliente}/restore`)
      }
    },
  },
}
</script>
