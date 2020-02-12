<template>
    <div class="user-filter-bar">
      <form>
        <div class="col-md-5 pull-right">
          <b-form-fieldset>
            <b-input-group>
              <b-form-input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder=""></b-form-input>
              <!-- Attach Left button -->
              <b-input-group-button slot="right">
                <b-button variant="primary"  @click.prevent="doFilter" >
                  <i class="fa fa-search"></i> Search
                </b-button>
                <b-button variant="default" @click.prevent="resetFilter" >
                   Reset
                </b-button>
              </b-input-group-button>
            </b-input-group>
          </b-form-fieldset>
        </div>
      </form>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        filterText: ''
      }
    },
    methods: {
      doFilter () {
        this.$events.fire('filter-set', this.filterText)
      },
      resetFilter () {
        this.filterText = ''
        this.$events.fire('filter-reset')
      }
    }
  }
</script>
<style>
.user-filter-bar {
  padding: 10px;
  float: none !important;
}
</style>
