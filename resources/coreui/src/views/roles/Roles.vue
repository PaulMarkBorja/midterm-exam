<template src="../../templates/rolesmanagement/roles.html"></template>

<script>

import Form from '../../helper/form.js';
import Vue from 'vue'
import Simplert from 'vue2-simplert'
import moment from 'moment'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.min.css';

export default {
  components: {
    Simplert,
    Loading
  },
  data () {
    return {
      checkRole: false,
      isLoading: false,
      permissions: [],
      roleHasPermission: [],
      roles: [],
      user: this.$auth.user(),
      form: new Form({
        name: '',
        rolePermissions: [],
      }),
    }
  },
  mounted: function(){
    this.isLoading = true;
    this.fetchRoles();
    this.fetchPermissions();
  },
  methods: {
    fetchUser: function(id){
      this.form.get('users/'+id).then(response => {
        console.log(response)
        this.form.originalData = response;
        this.form.sync();
        this.form.roles = this.form.roles[0].id;
      });

      $("#edit-user").modal('show');
    },

    fetchRoles(){
      this.form.get('roles').then(response => {
        this.roles = response;
        this.checkRole = true;
      });
    },

    fetchPermissions(){
      this.form.get('permissions').then(response => {
        this.permissions = response;
        this.checkPermissions();
      });
    },

    checkPermissions(){
      this.form.get('role_permissions').then(response => {
        this.roleHasPermission = response;
        this.selected = this.roleHasPermission[0];
        this.isLoading = false;
      });
    },

    resetForm(){
      this.form.reset();
    },

    addRole(){
      $("#add-role").modal('show');
    },

    // CREATE ROLE
    addNewRole(){
      this.form.post('roles')
        .then(response => {
          toastr.success('Role Added Successfully', 'Success Alert', {timeOut: 5000});
          this.fetchRoles();
          this.fetchPermissions();
          $("#add-role").modal('hide');
        }).catch( e => {
          setTimeout(()=>{
            this.form.errors.clear();
          },5000);
      });
    },

     // UPDATE ROLE PERMISSIONS
    updateRole(id, index){
      this.form.rolePermissions = this.roleHasPermission[index];
        this.form.patch('roles/'+id).then(response=>{
          if(response.role){
            toastr.success(response.role.bold() + ' permissions was successfully updated',  'Success Alert', {timeOut: 5000});
            this.fetchRoles();
          }else{
            toastr.error('Role with id ' + response.id.bold() + ' note found.', 'Error Alert', {timeOut: 5000});
          }
      }).catch( e => {
        setTimeout(()=>{
          this.form.errors.clear();
        },5000);
      });;
    },

    // DELETE A ROLE
    deleteRole(id){
        let confirmFn = () =>  {
          this.form.delete('roles/'+id).then(response => {
            if(response.fail)
              toastr.error(response.fail.bold(), 'Error Alert', {timeOut: 5000});
            else{
              this.fetchRoles();
              toastr.success('Role Deleted Successfully', 'Success Alert', {timeOut: 5000});
            }
          });
        }

        let obj = {
            title: 'Warning',
            message: 'Are you sure you want to delete this role (includes the permissions)?',
            type: 'warning',
            useConfirmBtn: true,
            onConfirm: confirmFn
        }

        this.$refs.deleteconfirmation.openSimplert(obj)
    },
  },
}
</script>
<style>
.sort-icon {
    float: left !important;
    padding-right: 10px;
    margin-top: 4px;
    color:#dd4b39;
}
</style>
