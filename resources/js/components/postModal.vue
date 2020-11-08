<template>
<div>
  <b-modal v-model="modal" :title="post.title" hide-footer>
    <b-img :src="post.image_url" fluid :alt="post.title"></b-img>
    <p class="my-4">{{post.thinks}}</p>

    <b-card bg-variant="light" style='margin-top: 30px' header="Комментарии" class="text-center">
        <b-card-text>
            <b-card style="margin-top: 20px" v-for="comment in comments" :key="comment.id" class="text-left" :sub-title="comment.user.login"> 
                {{ comment.text }}
            </b-card>

            <b-input-group style='margin-top: 30px'>
                <b-form-input :disabled="busy" v-model="comment"></b-form-input>
                <b-input-group-append>
                    <b-button :disabled="busy" @click="sendComment" variant="outline-info">Отправить</b-button>
                </b-input-group-append>
            </b-input-group>
        </b-card-text>
    </b-card>
    
  </b-modal>
</div>
</template>

<script>
import Axios from 'axios';
import { bus } from '../app'

  export default {
    data() {
      return {
          modal: false,
          post: {},
          comments: [],
          comment: '',
          busy: false
      }
    },
    created() {
      bus.$on('showPost', post=>{
        this.post = post
        this.modal = true
        this.busy = true
        window.axios.post('/api/comments', {
          'post_id': this.post.id
        }).then((v)=>{
          this.comments = v.data.comments
          this.busy = false
        })
      })
    },
    methods: {
      sendComment() {
        window.axios.put('/api/comments', {
          'text': this.comment,
          'post_id': this.post.id
        }).then((v)=>{
          bus.$emit('showPost', this.post)
        })
      }
    }
  };
</script>