<template>
  <div>
    <Head :title="form.concepto" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-rose-400 hover:text-rose-600" href="/conceptos">Conceptos</Link>
      <span class="text-rose-400 font-medium">/</span>
      {{ form.concepto }}
    </h1>
    <trashed-message v-if="concepto.deleted_at" class="mb-6" @restore="restore"> Este Concepto ha sido eliminado. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.concepto_esp" :error="form.errors.concepto_esp" class="pb-8 pr-6 w-full lg:w-1/2" label="Concepto en Español" />
          <text-input v-model="form.concepto_eng" :error="form.errors.concepto_eng" class="pb-8 pr-6 w-full lg:w-1/2" label="Concepto en Inglés" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!concepto.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Concepto</button>
          <loading-button :loading="form.processing" class="btn-rose ml-auto" type="submit">Actualizar Concepto</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 text-2xl font-bold">Tarifas</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Vigencia</th>
          <th class="pb-4 pt-6 px-6">Valor Neto/Mínimo</th>
          <th class="pb-4 pt-6 px-6">Valor Venta</th>
          <th class="pb-4 pt-6 px-6">Moneda</th>
        </tr>
        <tr v-for="tarifa in concepto.tarifas" :key="tarifa.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/tarifas/${tarifa.idtarifa}/edit`" tabindex="-1">
              {{ tarifa.vigencia }}
              <icon v-if="tarifa.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/tarifas/${tarifa.idtarifa}/edit`" tabindex="-1">
              {{ tarifa.valor_neto }}
              <icon v-if="tarifa.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/tarifas/${tarifa.idtarifa}/edit`" tabindex="-1">
              {{ tarifa.valor_venta }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/tarifas/${tarifa.idtarifa}/edit`" tabindex="-1">
              {{ tarifa.idmoneda }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/tarifas/${tarifa.idtarifa}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="concepto.tarifas.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No tarifas found.</td>
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
    concepto: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        concepto_esp: this.concepto.concepto_esp,
        concepto_eng: this.concepto.concepto_eng,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/conceptos/${this.concepto.idconcepto}`)
    },
    destroy() {
      if (confirm('Está seguri que desea eliminar este concepto?')) {
        this.$inertia.delete(`/conceptos/${this.concepto.idconcepto}`)
      }
    },
    restore() {
      if (confirm('Está seguri que desea restaurar este concepto?')) {
        this.$inertia.put(`/conceptos/${this.concepto.idconcepto}/restore`)
      }
    },
  },
}
</script>
