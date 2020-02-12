import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios';
import VueAxios from 'vue-axios';

// Containers
import Full from '../containers/Full'

// Views
import Dashboard from '../views/Dashboard'
import Charts from '../views/Charts'
import Widgets from '../views/Widgets'

// Views - Components
import Buttons from '../views/components/Buttons'
import SocialButtons from '../views/components/SocialButtons'
import Cards from '../views/components/Cards'
import Forms from '../views/components/Forms'
import Modals from '../views/components/Modals'
import Switches from '../views/components/Switches'
import Tables from '../views/components/Tables'

// Views - Icons
import FontAwesome from '../views/icons/FontAwesome'
import SimpleLineIcons from '../views/icons/SimpleLineIcons'

// Views - Pages
import Page403 from '../views/pages/Page403'
import Page404 from '../views/pages/Page404'
import Page500 from '../views/pages/Page500'
import Login from '../views/pages/Login'
import Register from '../views/pages/Register'

// Admin Entities
import Users from '../views/users/Users'
import Roles from '../views/roles/Roles'

Vue.use(Router)
Vue.use(VueAxios, axios)
axios.defaults.baseURL = '/api'

export default new Router({
  mode: "history",
  linkActiveClass: "open active",
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      path: "/",
      redirect: "/login",
      name: "Home",
      component: Full,
      children: [
        {
          path: "dashboard",
          name: "Dashboard",
          component: Dashboard,
          meta: {
            auth: true
          }
        },
        {
          path: "users",
          name: "Users",
          component: Users,
          meta: {
            auth: {
              roles: ["SuperAdmin", "Admin"]
            }
          }
        }, 
        {
          path: 'roles',
          name: 'Roles',
          component: Roles,
          meta: {
            auth: {
              roles: ['SuperAdmin']
            }
          }
        },
        {
          path: "charts",
          name: "Charts",
          component: Charts
        },
        {
          path: "widgets",
          name: "Widgets",
          component: Widgets
        },
        {
          path: "components",
          redirect: "/components/buttons",
          name: "Components",
          component: {
            render(c) {
              return c("router-view");
            }
          },
          children: [
            {
              path: "buttons",
              name: "Buttons",
              component: Buttons
            },
            {
              path: "social-buttons",
              name: "Social Buttons",
              component: SocialButtons
            },
            {
              path: "cards",
              name: "Cards",
              component: Cards
            },
            {
              path: "forms",
              name: "Forms",
              component: Forms
            },
            {
              path: "modals",
              name: "Modals",
              component: Modals
            },
            {
              path: "switches",
              name: "Switches",
              component: Switches
            },
            {
              path: "tables",
              name: "Tables",
              component: Tables
            }
          ]
        },
        {
          path: "icons",
          redirect: "/icons/font-awesome",
          name: "Icons",
          component: {
            render(c) {
              return c("router-view");
            }
          },
          children: [
            {
              path: "font-awesome",
              name: "Font Awesome",
              component: FontAwesome
            },
            {
              path: "simple-line-icons",
              name: "Simple Line Icons",
              component: SimpleLineIcons
            }
          ]
        }
      ]
    },
    {
      path: "/pages",
      redirect: "/pages/404",
      name: "Pages",
      component: {
        render(c) {
          return c("router-view");
        }
      },
      children: [
        {
          path: "404",
          name: "Page404",
          component: Page404
        },
        {
          path: "500",
          name: "Page500",
          component: Page500
        },
        {
          path: "login",
          name: "Signin",
          component: Login
        },
        {
          path: "register",
          name: "Signup",
          component: Register
        }
      ]
    },
    {
      path: "/login",
      name: "Login",
      component: Login,
      meta: {
        auth: false
      }
    },
    {
      path: "/register",
      name: "Register",
      component: Register,
      meta: {
        auth: false
      }
    },
    {
      path: "/404",
      name: "404",
      component: Page404
    },
    {
      path: "/403",
      name: "403",
      component: Page403
    },
    {
      path: "*",
      redirect: "/404"
    }
  ]
});
