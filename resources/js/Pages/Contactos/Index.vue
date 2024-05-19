<template>
  <div>
    <Head title="Contactos" />
    <h1 class="mb-8 text-3xl font-bold">Contactos</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <Link class="btn-rose" href="/contactos/create">
        <span>Crear</span>
        <span class="hidden md:inline">&nbsp;Contacto</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Nombres</th>
          <th class="pb-4 pt-6 px-6">Apellidos</th>
          <th class="pb-4 pt-6 px-6">Cliente</th>
          <th class="pb-4 pt-6 px-6">Email</th>
          <th class="pb-4 pt-6 px-6">Teléfono</th>
          <th class="pb-4 pt-6 px-6">Dirección</th>
          <th class="pb-4 pt-6 px-6" colspan="2">Ciudad</th>
        </tr>
        <tr v-for="contacto in contactos.data" :key="contacto.idcontacto" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              {{ contacto.nombres }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              {{ contacto.apellidos }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contactos/${contacto.idcontacto}/edit`" tabindex="-1">
              <div v-if="contacto.cliente">
                {{ contacto.cliente.clientes }}
              </div>
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
        <tr v-if="contactos.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No se encuentran contactos</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="contactos.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    contactos: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/contactos', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
