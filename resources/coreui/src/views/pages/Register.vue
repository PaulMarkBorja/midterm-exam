<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
              <h1>Register</h1>

              <div class="alert alert-danger" v-if="error && !success">
                  <p>There was an error, unable to complete registration.</p>
              </div>
              <div class="alert alert-success" v-if="success">
                <p>Registration completed. You can now <router-link :to="{name:'Login'}">sign in.</router-link></p>
              </div>


              <form autocomplete="off" @submit.prevent="register" v-if="!success">
                <p class="text-muted">Create your account</p>
                <div class="input-group mb-3">
                    <span class="input-group-addon"><i class="icon-user"></i></span>
                    <input v-model="name" type="text" :class="errors.name ? 'form-control is-invalid' : 'form-control' "   placeholder="Username">
                    <!-- <div v-if="error && errors.name" class="invalid-feedback">
                        {{errors.name[0]}}
                    </div> -->
                </div>

                <div class="input-group mb-3">
                  <span class="input-group-addon">@</span>
                  <input v-model="email" type="text" :class="errors.email ? 'form-control is-invalid' : 'form-control' "  placeholder="Email">
                </div>

                <div class="input-group mb-3">
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input v-model="password" type="password" :class="errors.password ? 'form-control is-invalid' : 'form-control' "  placeholder="Password">
                </div>

                <div class="input-group mb-4">
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input v-model="confirmPassword" type="password" :class="errors.confirmPassword ? 'form-control is-invalid' : 'form-control' "  placeholder="Confirm Password">
                </div>

                <button type="submit" class="btn btn-block btn-success">Create Account</button>
              </form>
            </div>
            <!-- <div class="card-footer p-4">
              <div class="row">
                <div class="col-6">
                  <button class="btn btn-block btn-facebook" type="button"><span>facebook</span></button>
                </div>
                <div class="col-6">
                  <button class="btn btn-block btn-twitter" type="button"><span>twitter</span></button>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from '../../helper/form.js';
export default {
     data(){
         return {
             form: new Form({
               name: '',
               email: '',
               password: ''
             }),
             name: '',
             email: '',
             password: '',
             confirmPassword: '',
             error: false,
             errors: {},
             success: false
         };
     },
     methods: {
         register(){
             var app = this
             this.$auth.register({
                 params: {
                     name: app.name,
                     email: app.email,
                     password: app.password,
                     confirmPassword: app.confirmPassword
                 },
                 success: function () {
                     app.success = true
                 },
                 error: function (resp) {
                     app.error = true;
                     app.errors = resp.response.data.errors;
                 },
                 redirect: null
             });
         }
     }
 }
</script>
