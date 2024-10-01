<script setup>
  import { Link, usePage } from '@inertiajs/vue3';
  import { computed } from 'vue'

  const page = usePage()
  const isAdmin = computed(() => page.props.auth.can.admin)
  const municipio = computed(() => page.props.auth.id)
</script>

<template>
  <template v-if="isAdmin">
    <aside class="aside is-placed-left is-expanded">
    <div class="aside-tools">
    <div>
      Laboratorio <b class="font-black">Politico</b>
    </div>
    </div>
    <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="active">
        <Link :href="route('dashboard')">
          <span class="icon"><i class="mdi mdi-math-integral"></i></span>
          <span class="menu-item-label">Resumen Municipios</span>
        </Link>
      </li>
    </ul>
    <p class="menu-label">Examples</p>
    <ul class="menu-list">
      <li class="--set-active-tables-html">
        <a href="tables.html">
          <span class="icon"><i class="mdi mdi-table"></i></span>
          <span class="menu-item-label">Tables</span>
        </a>
      </li>
      <li class="--set-active-forms-html">
        <a href="forms.html">
          <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
          <span class="menu-item-label">Forms</span>
        </a>
      </li>
      <li class="--set-active-profile-html">
        <a href="profile.html">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Profile</span>
        </a>
      </li>
      <li>
        <a href="login.html">
          <span class="icon"><i class="mdi mdi-lock"></i></span>
          <span class="menu-item-label">Login</span>
        </a>
      </li>
      <li>
        <a class="dropdown">
          <span class="icon"><i class="mdi mdi-view-list"></i></span>
          <span class="menu-item-label">Submenus</span>
          <span class="icon"><i class="mdi mdi-plus"></i></span>
        </a>
        <ul>
          <li>
            <a href="#void">
              <span>Sub-item One</span>
            </a>
          </li>
          <li>
            <a href="#void">
              <span>Sub-item Two</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    <p class="menu-label">About</p>
    <ul class="menu-list">
      <li>
        <a href="https://justboil.me/tailwind-admin-templates/free-dashboard/" class="has-icon">
          <span class="icon"><i class="mdi mdi-help-circle"></i></span>
          <span class="menu-item-label">About</span>
        </a>
      </li>
      <li>
        <a href="https://github.com/justboil/admin-one-tailwind" class="has-icon">
          <span class="icon"><i class="mdi mdi-github-circle"></i></span>
          <span class="menu-item-label">GitHub</span>
        </a>
      </li>
    </ul>
    </div>
    </aside>
  </template>

  <template v-if="municipio">
    <aside class="aside is-placed-left is-expanded">
    <div class="aside-tools">
    <div>
      Laboratorio <b class="font-black">Politico</b>
    </div>
    </div>
    <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="active">
        <Link :href="route('dashboard')">
          <span class="icon"><i class="mdi mdi-math-integral"></i></span>
          <span class="menu-item-label">Resumen</span>
        </Link>
      </li>
    </ul>
    
    </div>
    </aside>
  </template>

</template>
