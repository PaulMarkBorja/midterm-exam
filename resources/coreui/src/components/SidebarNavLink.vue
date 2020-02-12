<template>
  <router-link :to="url" class="nav-link" :hidden="auth && !this.auth.roles.includes($auth.user().roles[0].name)">
    <i :class="icon"></i>  {{name}}
    <b-badge v-if="badge.text" :variant="badge.variant">{{badge.text}}</b-badge>
  </router-link>
</template>

<script>
export default {
  name: 'sidebar-nav-link',
  props: {
    name: {
      type: String,
      default: ''
    },
    url: {
      type: String,
      default: ''
    },
    icon: {
      type: String,
      default: ''
    },
    badge: {
      default: ''
    },
    auth: {
      type: Object
    }
  },
}
</script>
