<template>
<div style="margin: 15px">
    <b-card-group deck>
        <b-card
            v-for="post in posts"
            :key="post.id"
            :img-src="post.image_url"
            :img-alt="post.title"
            :title="post.title"
            style="max-width: 20rem"
        >
            <b-card-text>
                {{post.thinks}}
            </b-card-text>

            <b-button variant="outline-info" style="margin-bottom: 7px;" @click="postOpen(post)">Комментарии</b-button>
        </b-card>
    </b-card-group>
</div>
</template>

<script>
import { bus } from '../app'

  export default {
    props: ['posts'],
    data() {
      return {
      }
    },
    methods: {
      postOpen(post) {
        bus.$emit('showPost', post)
      }
    }
  };
</script>