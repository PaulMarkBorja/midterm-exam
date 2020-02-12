<template src="../../templates/rolesmanagement/users.html"></template>

<script>

import Form from '../../helper/form.js';
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import UserDetailRow from './UserDetailRow'
import UserFilterBar from './UserFilterBar'
import Simplert from 'vue2-simplert'
import moment from 'moment'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.min.css';


Vue.use(VueEvents)
Vue.component('user-detail-row', UserDetailRow)
Vue.component('user-filter-bar', UserFilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
    Simplert,
    Loading,
  },
  data () {
    return {
      isLoading:false,
      page: 'view_list',
      roles: [],
      user: this.$auth.user(),
      users: [],
      stores:[],
      form: new Form({
        id: '',
        name: '',
        email: '',
        password: '',
        roles: 1,
      }),

      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'text-right',
          dataClass: 'text-right'
        },
        {
          	name: 'name',
          	title: 'Username',
          	sortField: 'name',
        },
        {
        	name: 'created_at',
        	title: 'Created At',
        	callback: 'formatDate|D/MM/Y',
          sortField: 'created_at'
        },

        '__slot:actions'
      ],

      css: {

        tableClass: 'ui blue selectable celled stackable attached table',
        loadingClass: 'loading',
        ascendingIcon: 'pull-left glyphicon glyphicon-chevron-up',
        descendingIcon: 'pull-left glyphicon glyphicon-chevron-down',

        pagination: {
          wrapperClass: 'pagination pull-right',
          activeClass: 'btn-primary',
          disabledClass: 'disabled',
          pageClass: 'btn btn-border',
          linkClass: 'btn btn-border',
          icons: {
            first: '',
            prev: '',
            next: '',
            last: '',
          }
        }
      },

      sortOrder: [
        { field: 'id', sortField: 'id', direction: 'asc'}
      ],
      moreParams: {}
    }
  },
  created(){
    this.fetchStores();
    this.isLoading = true
    setTimeout(()=>{
         this.isLoading = false
    },1000);
  },
  mounted: function(){
    this.fetchRoles();
    
  },
  methods: {
  	getRole(value){
  		return value[0].name;
  	},
  	formatDate: function(value, fmt) {
        if (value == null) return ''
        fmt = (typeof fmt == 'undefined') ? 'D MMM YYYY' : fmt
        return moment(String(value)).format('MMMM DD, YYYY')
    },

    fetchUsers(){
      this.form.get('users').then(response => {
        this.users = response.users;
      });
    },

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
      });
    },

    showAddUserModal() {
      $("#add-user").modal('show');
    },

    resetForm(){
      this.form.reset();
    },

    // CREATE USER
    addNewUser(){
       this.form.roles = 1;
      this.form.post('users')
        .then(response => {
          toastr.success('User Created Successfully', 'Success Alert', {timeOut: 2000});
          this.page = 'view_list';
          this.form.reset();
          this.$refs.vuetable.refresh();
          $("#add-user").modal('hide');
        }).catch( e => {
          setTimeout(()=>{
            this.form.errors.clear();
            console.log(this.form.errors);
          },2000);
      });
    },

     // UPDATE USER DETAILS
    updateUser(id){
        this.form.pass = this.form.password;
        this.form.patch('users/'+id).then(response=>{
        toastr.success('User Updated Successfully', 'Success Alert', {timeOut: 2000});
        this.$refs.vuetable.refresh();
        this.form.reset();
        $("#edit-user").modal('hide');
      }).catch( e => {
        setTimeout(()=>{
          this.form.errors.clear();
        },2000);
      });
    },

    // DELETE A USER
    deleteUser(id){
        let confirmFn = () =>  {
          this.form.delete('users/'+id).then(response => {
            // if(response.fail)
            //   toastr.success(response.fail, 'Success Alert', {timeOut: 2000});
            // else{
            //   toastr.error('Role with id ' + response.id + ' note found.', 'Error Alert', {timeOut: 2000});
            //   this.$refs.vuetable.refresh();
            // }
            toastr.success('User Deleted Successfully', 'Success Alert', {timeOut: 2000});
            this.$refs.vuetable.refresh();
          });
        }

        let obj = {
            title: 'Warning',
            message: 'Are you sure you want to delete this user?',
            type: 'warning',
            useConfirmBtn: true,
            onConfirm: confirmFn
        }

        this.$refs.deleteconfirmation.openSimplert(obj)
    },

    onPaginationData (paginationData) {
      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },

    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },

    onCellClicked (data, field, event) {
      console.log('cellClicked: ', field.name)
      this.$refs.vuetable.toggleDetailRow(data.id)
    },
  },
  events: {
    'filter-set' (filterText) {
      this.moreParams = {
        filter: filterText
      }
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    },
    'filter-reset' () {
      this.moreParams = {}
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    }
  },
  computed:{
  }
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
