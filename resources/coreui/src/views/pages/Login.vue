<template>
  <div>
    <loading :active.sync="isLoading"
             :can-cancel="false"
             :is-full-page="true"></loading>
    <div class="app flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <div class="card-group mb-0">
              <div class="card p-4 round">
                <div class="card-body">
                  <img class="logo" src="/static/img/logo.png">
                  <br>
                  <p class="text-muted">Login to continue</p>
                  <form autocomplete="off" @submit.prevent="login">
                    <div class="input-group mb-3">
                      <span class="input-group-addon"><i class="icon-user"></i></span>
                      <input v-model="name" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="input-group mb-4">
                      <span class="input-group-addon"><i class="icon-lock"></i></span>
                      <input v-model="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="input-group mb-4" v-if="this.error">
                      <span class="danger">Invalid username or password.</span>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4 pull-right">Login</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/vue-loading.min.css';

  export default {
    data(){
      return {
        name: null,
        password: null,
        error: false,
        isLoading: false
      }
    },
    components: {
      Loading
    },
    methods: {
      login(){
        var app = this
        this.isLoading = true;
        this.$auth.login({
            method :'POST',
            data: {
              name: app.name,
              password: app.password
            },
            success: function () {
              this.error = false
            },
            error: function () {
              this.isLoading = false,
              this.error = true
            },
            rememberMe: true,
            redirect:'/dashboard',
            fetchUser: true,

            
        });
      },
    }
  }
</script>