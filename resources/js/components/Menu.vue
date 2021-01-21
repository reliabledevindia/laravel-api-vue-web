<template>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item" v-if="!$auth.check()" v-for="(route, key) in routes.unlogged" v-bind:key="route.path">
          <router-link  :to="{ name : route.path }" :key="key" class="nav-link">
            {{route.name}}
          </router-link>
        </li>
        <!--LOGGED USER-->
        <li class="nav-item" v-if="$auth.check(1)" v-for="(route, key) in routes.user" v-bind:key="route.path">
          <router-link  :to="{ name : route.path }" :key="key" class="nav-link">
            {{route.name}}
          </router-link>
        </li>
        <!--LOGGED ADMIN-->
        <li class="nav-item" v-if="$auth.check(2)" v-for="(route, key) in routes.admin" v-bind:key="route.path">
          <router-link  :to="{ name : route.path }" :key="key" class="nav-link">
            {{route.name}}
          </router-link>
        </li>
        <!--LOGOUT-->
        <li class="nav-item" v-if="$auth.check()">
          <a href="#" @click.prevent="$auth.logout()" class="nav-link">Logout</a>
        </li>
      </ul>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        routes: {
          // UNLOGGED
          unlogged: [
            {
              name: 'Login',
              path: 'login'
            }
          ],
          // LOGGED USER
          user: [
            {
              name: 'Dashboard',
              path: 'dashboard'
            }
          ],
          // LOGGED ADMIN
          admin: [
            {
              name: 'Dashboard',
              path: 'admin.dashboard'
            }
          ]
        }
      }
    },
    mounted() {
      //
    }
  }
</script>