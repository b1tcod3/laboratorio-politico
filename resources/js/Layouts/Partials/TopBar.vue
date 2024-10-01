<script setup>
  import { Link } from '@inertiajs/vue3';
</script>

<template>
   <nav id="navbar-main" class="navbar is-fixed-top">
      <div class="navbar-brand">
        <a class="navbar-item mobile-aside-button">
          <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
      </a>
      <div class="navbar-item">
          <div class="control"><input placeholder="Buscar" class="input"></div>
      </div>
  </div>
  <div class="navbar-brand is-right">
    <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
      <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
  </a>
</div>
<div class="navbar-menu" id="navbar-menu">
    <div class="navbar-end">
<div class="navbar-item dropdown has-divider has-user-avatar">
    <div class="navbar-link cursor-pointer">
      <div class="user-avatar">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"/></svg>
      </div>
      <div class="is-user-name"><span>{{$page.props.auth.user.name}}</span></div>
      <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
  </div>
  <div class="navbar-dropdown">
      <a href="profile.html" class="navbar-item">
        <span class="icon"><i class="mdi mdi-account"></i></span>
        <span>My Profile</span>
    </a>
    <a class="navbar-item">
        <span class="icon"><i class="mdi mdi-settings"></i></span>
        <span>Settings</span>
    </a>
    <a class="navbar-item">
        <span class="icon"><i class="mdi mdi-email"></i></span>
        <span>Messages</span>
    </a>
    <hr class="navbar-divider">
    <Link class="navbar-item" :href="route('logout')" method="post" as="button">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Log Out</span>
    </Link>
</div>
</div>
<!-- <a href="https://justboil.me/tailwind-admin-templates/free-dashboard/" class="navbar-item has-divider desktop-icon-only">
    <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
    <span>About</span>
</a>
<a href="https://github.com/justboil/admin-one-tailwind" class="navbar-item has-divider desktop-icon-only">
    <span class="icon"><i class="mdi mdi-github-circle"></i></span>
    <span>GitHub</span>
</a>
<a title="Log out" class="navbar-item desktop-icon-only">
    <span class="icon"><i class="mdi mdi-logout"></i></span>
    <span>Log out</span>
</a> -->
</div>
</div>
</nav>
</template>
