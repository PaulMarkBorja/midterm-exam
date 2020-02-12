<template>
  <div class="app">
    <AppHeader/>
    <div class="app-body">
      <Sidebar :navItems="nav"/>

      <main :class="'main'">

        <div class="container-fluid mt-2">
          <router-view></router-view>
        </div>
      </main>
      <AppAside/>
    </div>
    <AppFooter :class="'main'"/>
  </div>
</template>

<script>
import nav from '../_nav'

import { aHeader as AppHeader, Sidebar, aAside as AppAside, aFooter as AppFooter, Breadcrumb} from '../components/'
export default {
  name: 'full',
  components: {
    AppHeader,
    Sidebar,
    AppAside,
    AppFooter,
    Breadcrumb,
  },
  data () {
    return {
      nav: nav.items,
      user:this.$auth.user(),
    }
  },
   created(){

  },
  methods:{
    
  },
  computed: {
    name () {
      return this.$route.name
    },
    list () {
      return this.$route.matched
    },
    program_id()
    {
      return this.$route.params.program_id;
    },
    department_id()
    {
      return this.$route.params.department_id;
    },
  },
  watch:{
  
  }
}
</script>
