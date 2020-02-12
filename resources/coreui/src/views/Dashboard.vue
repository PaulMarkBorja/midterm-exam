<template>
  <div class="animated fadeIn">
    <template  v-if="this.$auth.user().role ==='SuperAdmin'">

        <div class="title-page">
          <h3>SuperAdmin Dashboard</h3>
        </div>

    </template>

    <template v-if="this.$auth.user().role ==='Admin'">
        <!-- <AdminLanding /> -->
        <div class="title-page">
          <h3>Restaurant Admin Dashboard</h3>
        </div>
    </template>
  </div>
</template>


<script>

  export default {
    name: 'dashboard',
    components: {
      
    },
    data: function () {
      return {
      }
    },
    created()
    {

    },
    methods: {

    }
  }
</script>
