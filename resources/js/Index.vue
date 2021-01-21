<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
          <router-link :to="{name: 'home'}" class="navbar-brand" >
            Polling System
          </router-link>
          <navigationMenu></navigationMenu>
      </div>
    </nav>
    <main class="py-4">
      <router-view></router-view>
    </main>
  </div>
</template>
<script>
  import navigationMenu from './components/Menu.vue'
  export default {
    data() {
      return {
        //
      }
    },
    components: {
      navigationMenu
    }
  }
</script>