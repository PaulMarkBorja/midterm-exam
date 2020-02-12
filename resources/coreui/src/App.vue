<template>
  <div>
    <div v-if="$auth.ready()">
      <router-view></router-view>
      <vue-progress-bar></vue-progress-bar>
    </div>
     <!-- <div v-if="!$auth.ready()">
         Loading ...
     </div> -->

  </div>

</template>

<script>
export default {
  name: 'app',
  mounted () {
   //  [App.vue specific] When App.vue is finish loading finish the progress bar
   this.$Progress.finish()
 },
 created () {
   //  [App.vue specific] When App.vue is first loaded start the progress bar
   this.$Progress.start()
   //  hook the progress bar to start before we move router-view
   this.$router.beforeEach((to, from, next) => {
     //  does the page we want to go to have a meta.progress object
     if (to.meta.progress !== undefined) {
       let meta = to.meta.progress
       // parse meta tags
       this.$Progress.parseMeta(meta)
     }
     //  start the progress bar
     this.$Progress.start()
     //  continue to next page
     next()
   })
   //  hook the progress bar to finish after we've finished moving router-view
   this.$router.afterEach((to, from) => {
     //  finish the progress bar
     this.$Progress.finish()
   })
 }
}
</script>

<style>
  /* Import Font Awesome Icons Set */
  $fa-font-path: '~font-awesome/fonts/';
  @import '~font-awesome/css/font-awesome.min.css';
  /* Import Simple Line Icons Set */
  $simple-line-font-path: '~simple-line-icons/fonts/';
  @import '~simple-line-icons/css/simple-line-icons.css';
  /* Import Bootstrap Vue Styles */
  @import '~bootstrap-vue/dist/bootstrap-vue.css';
</style>
<style lang="scss">
  // Import Main styles for this application
  @import '../scss/style';
</style>
