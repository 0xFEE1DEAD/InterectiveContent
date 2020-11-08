<template>
<div>
  
  <b-spinner v-show="loading" label="Busy" style="position: absolute; z-index: 2;" variant="primary"></b-spinner>
  <b-alert style="position: absolute; z-index: 2;" variant="danger" :show="showError">{{textError}}</b-alert>
  <b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="#">HW</b-navbar-brand>
    <b-navbar-nav class="ml-auto">
      <b-button v-show="user.id == 0 && !start" @click='openLogin' size="sm" type="input" variant="info">ВОЙТИ</b-button>
      <b-dropdown v-if="user.id > 0 && !start" split :text="user.login">
        <b-dropdown-item href="#" @click="createPostAct">Создать пост</b-dropdown-item>
        <b-dropdown-item href="#">Создать тэг</b-dropdown-item>
        <b-dropdown-item href="#" @click="userBB">Выход</b-dropdown-item>
      </b-dropdown>
      <b-spinner v-show="user.id == 0 && start" v-else></b-spinner>
    </b-navbar-nav>
  </b-navbar>
  <tagFilter/>
  <posts :posts="postsList"/>
  <modal/>
  <createmodal/>
  <login/>
  <registration/>
</div>
</template>

<script>
import posts from './posts'
import modal from './postModal'
import createmodal from './createPost'
import login from './login'
import registration from './reg'
import { bus } from '../app'
import tagFilter from './tagFilter'

  export default {
    data() {
      return {
        user: {id:0},
        registration: false,
        loading: false,
        textError: "",
        showError: false,
        start: true,
        postsList: [],
        selected_tags: []
      }
    },
    mounted() {
      window.axios.get('/api/users/authorized').then((v)=>{
        if(v.data.user) {
          this.user = v.data.user
        }
        this.start = false
      })
      bus.$emit('posts_update')
    },
    created() {
      

      bus.$on('loading', status => {
        console.log('[main] loading status ' + status)
        this.loading = status
      })
      bus.$on('showError', text => {
        console.log('[main] show error ' + text)
        this.textError = text
        this.showError = true
        setTimeout(()=>{
          this.showError = false
        }, 3000)
      })
      bus.$on('changeUser', user => {
        console.log('[main] change user', user)
        this.user = user
      })
      bus.$on('posts_update', () => {
        this.loading = true
        window.axios.post('/api/posts/get', {
          tags: this.selected_tags
        }).then((v) => {
          this.loading = false
          this.postsList = v.data['posts']
        })
      })
      bus.$on('change_tags', (tags) => {
        console.log('[main] change tags ', tags)
        this.selected_tags = tags
      })
    },
    methods: {
      openLogin() {
        console.log('[main] open registartion')
        bus.$emit('changeStatusLogin', true)
      },
      userBB() {
        this.start = true
        this.user={id:0}
        window.axios.post('/api/users/logout').then((v) => {
          this.start = false
        })
      },
      createPostAct() {
        console.log('[main] open registartion')
        bus.$emit('createPostStatus', true)
      }
    },
    components: {
      posts,
      modal,
      createmodal,
      login,
      registration,
      tagFilter
    }
  };
</script>