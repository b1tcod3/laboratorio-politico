<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key" class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded" v-html="link.label" />
        <Link v-else :key="`link-${key}`" class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-white border focus:border-indigo-500 rounded" :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
  <span class="text-sm text-gray-700 dark:text-gray-400">
      Monstrando <span class="font-semibold text-gray-900 dark:text-white">{{from}}</span> to <span class="font-semibold text-gray-900 dark:text-white">{{to}}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{total}}</span> registros
  </span>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  components: {
    Link,
  },
  props: {
    links: Array,
    total: Number,
    from: Number,
    to: Number
  },
}
</script>