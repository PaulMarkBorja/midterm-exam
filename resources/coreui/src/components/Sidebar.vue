<template>
  <div class="sidebar">
    <SidebarHeader/>
    <SidebarForm/>
    <nav class="sidebar-nav">
      <div slot="header"></div>
      <ul class="nav">
        <template v-for="(item, index) in navItems">
          <template v-if="item.title">
            <template v-if="item.auth">
              <SidebarNavTitle :name="item.name" :classes="item.class" :wrapper="item.wrapper" :auth="item.auth"/>
            </template>
            <template v-else>
              <SidebarNavTitle :name="item.name" :classes="item.class" :wrapper="item.wrapper"/>
            </template>
          </template>
          <template v-else-if="item.divider">
            <li class="divider"></li>
          </template>
          <template v-else>
            <template v-if="item.children">
              <!-- First level dropdown -->
              <SidebarNavDropdown :name="item.name" :url="item.url" :auth="item.auth" :icon="item.icon">
                <template v-for="(childL1, index) in item.children">
                  <template v-if="childL1.children">
                    <!-- Second level dropdown -->
                    <SidebarNavDropdown :name="childL1.name" :url="childL1.url" :icon="childL1.icon">
                      <li class="nav-item" v-for="(childL2, index) in childL1.children">
                        <template v-if="childL2.auth">
                          <SidebarNavLink :name="childL2.name" :url="childL2.url" :icon="childL2.icon" :badge="childL2.badge" :auth="child2.auth"/>
                        </template>
                        <template v-else>
                          <SidebarNavLink :name="childL2.name" :url="childL2.url" :icon="childL2.icon" :badge="childL2.badge"/>
                        </template>
                      </li>
                    </SidebarNavDropdown>
                  </template>
                  <template v-else>
                    <li class="nav-item">
                      <template v-if="childL1.auth">
                        <SidebarNavLink :name="childL1.name" :url="childL1.url" :icon="childL1.icon" :badge="childL1.badge" :auth="childL1.auth"/>
                      </template>
                      <template v-else>
                        <SidebarNavLink :name="childL1.name" :url="childL1.url" :icon="childL1.icon" :badge="childL1.badge"/>
                      </template>
                    </li>
                  </template>
                </template>
              </SidebarNavDropdown>
            </template>
            <template v-else>
              <li class="nav-item">
                <template v-if="item.auth">
                  <SidebarNavLink :name="item.name" :url="item.url" :icon="item.icon" :badge="item.badge" :auth="item.auth"/>
                </template>
                <template v-else>
                  <SidebarNavLink :name="item.name" :url="item.url" :icon="item.icon" :badge="item.badge"/>
                </template>
              </li>
            </template>
          </template>
        </template>
      </ul>
      <slot></slot>
    </nav>
    <SidebarFooter/>
  </div>
</template>
<script>
import SidebarFooter from './SidebarFooter'
import SidebarForm from './SidebarForm'
import SidebarHeader from './SidebarHeader'
import SidebarNavDropdown from './SidebarNavDropdown'
import SidebarNavLink from './SidebarNavLink'
import SidebarNavTitle from './SidebarNavTitle'
export default {
  name: 'sidebar',
  props: {
    navItems: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  components: {
    SidebarFooter,
    SidebarForm,
    SidebarHeader,
    SidebarNavDropdown,
    SidebarNavLink,
    SidebarNavTitle
  },
  methods: {
    handleClick (e) {
      e.preventDefault()
      e.target.parentElement.classList.toggle('open')
    }
  }
}
</script>

<style lang="css">
  .nav-link {
    cursor:pointer;
  }
</style>
