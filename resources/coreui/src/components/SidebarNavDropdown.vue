<template>
  <router-link tag="li" class="nav-item nav-dropdown" :to="url" disabled :hidden="auth && !this.auth.roles.includes($auth.user().roles[0].name)">
    <div class="nav-link nav-dropdown-toggle" @click="handleClick"><i :class="icon"></i> {{name}}</div>
    <ul class="nav-dropdown-items">
      <slot></slot>
    </ul>
  </router-link>
</template>

<script>
export default {
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
    auth: {
      type: Object
    }
  },
  methods: {
    handleClick (e) {
      e.preventDefault()
      e.target.parentElement.classList.toggle('open')
    }
  }
}
</script>
