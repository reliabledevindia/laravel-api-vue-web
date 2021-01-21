import VueRouter from 'vue-router'

// Pages
import Home from './pages/Home'
import Login from './pages/Login'
import Dashboard from './pages/user/Dashboard'

// Routes
const routes = [
  {
    path: '',
    name: 'home',
    component: Home,
    meta: {
      auth: undefined
    }
  },
  {
    path: 'login',
    name: 'login',
    component: Login,
    meta: {
      auth: false
    }
  },
  // USER ROUTES
  {
    path: 'dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      auth: true
    }
  },
]

const router = new VueRouter({  
  mode: 'history',
  routes,
})

export default router