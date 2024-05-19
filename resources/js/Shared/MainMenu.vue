<template>
  <div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Inicio</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/monedas">
        <icon name="money" class="mr-2 w-4 h-4" :class="isUrl('monedas') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('monedas') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Monedas</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/paises">
        <icon name="country" class="mr-2 w-4 h-4" :class="isUrl('paises') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('paises') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Paises</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/ciudades">
        <icon name="city" class="mr-2 w-4 h-4" :class="isUrl('ciudades') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('ciudades') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Ciudades</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/clientes">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('clientes') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('clientes') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Clientes</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/contactos">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('contactos') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('contactos') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Contactos</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/conceptos">
        <icon name="product" class="mr-2 w-4 h-4" :class="isUrl('conceptos') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('conceptos') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Conceptos</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/tarifas">
        <icon name="dollar" class="mr-2 w-4 h-4" :class="isUrl('tarifas') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('tarifas') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Tarifas</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/reports">
        <icon name="printer" class="mr-2 w-4 h-4" :class="isUrl('reports') ? 'fill-white' : 'fill-rose-400 group-hover:fill-white'" />
        <div :class="isUrl('reports') ? 'text-white' : 'text-rose-300 group-hover:text-white'">Reports</div>
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
