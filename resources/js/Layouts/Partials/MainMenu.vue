<script setup>
      import { ref } from 'vue';
      import Icon from '@/Components/Icon/Icon.vue'
      import { Link } from '@inertiajs/vue3';
      import MenuItem from '@/Components/Menu/MenuItem.vue';
      import MenuSubItem from '@/Components/Menu/MenuSubItem.vue';
      import {items} from '@/Data/Menu/items-menu'

</script>

<template>
  <div>

    <div class="mb-4" v-for="item in items">
        <menu-sub-item v-if="item.is_sub_menu" :icon="item.icon" :active="$page.url === item.name_route" :name="item.name"
          :items="item.items"
        />
        <menu-item :url="route('dashboard')" icon="resumen" :active="$page.url === item.name_route" :name="item.name" v-else/>
    </div>
  </div>
</template>

