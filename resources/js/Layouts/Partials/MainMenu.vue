<script setup>
      import { ref } from 'vue';
      import Icon from '@/Components/Icon/Icon.vue'

      const showMenu = ref(false);
      const show = ref(false);
      const toggleNav = () => (showMenu.value = !showMenu.value);
</script>

<script>
import { Link } from '@inertiajs/vue3';


export default {
  components: {
    Link
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

<template>
  <div>

    <div class="mb-4">
      <div class="relative">
            <!-- Dropdown toggle button -->
            <button
              @click="show = !show"
              class="
                flex
                items-center
                rounded-md
                focus:outline-none
                group flex items-center py-3
              "
              :class="isUrl('resumen') ? 'text-white' : 'text-indigo-300 group-hover:text-white'"
            > 
            <icon name="resumen" class="mr-2 w-4 h-4" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
              <span class="mr-4">Resumen</span>
              <svg
                class="w-5 h-5 text-indigo-100"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>

            <div
              v-show="show"
              class="
                mt-2
                ml-3
              "
            >
              <Link class="group flex items-center py-3" :href="route('resumen.index')">
                <icon name="resumen" class="mr-2 w-4 h-4" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('resumen') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">General</div>
              </Link>
            </div>
      </div>  
    </div>

    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/organizations">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Organizations</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/contacts">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/reports">
        <icon name="printer" class="mr-2 w-4 h-4" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Reports</div>
      </Link>
    </div>

  </div>
</template>

