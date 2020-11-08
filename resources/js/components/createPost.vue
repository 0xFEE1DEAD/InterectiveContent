<template>
<div>
  <b-modal v-model="modal" title="Создать пост" hide-footer>
    <b-input-group
      prepend="Название"
      
    >
      <b-form-input :disabled="sending" v-model='title'></b-form-input>
    </b-input-group>

    <b-form-group style="margin-top: 14px"  label="Картинка:" label-for="file-image" label-cols-sm="2">
        <b-form-file :disabled="sending" v-model="image" accept=".jpg, .png, .gif"></b-form-file>
    </b-form-group>

    <b-form-textarea
      v-model="text"
      placeholder="Введите свои мысли"
      rows="3"
      no-resize
      :disabled="sending"
    ></b-form-textarea>

    <b-form-tags
      style="margin-top: 14px"
      v-model="tags"
      tag-variant="primary"
      tag-pills
      separator=" "
      placeholder="Введите тэги через пробел"
      :disabled="sending"
    ></b-form-tags>

    <b-button :disabled="sending" class="mt-3" variant="info" block @click="createPost">Создать</b-button>
  </b-modal>
</div>
</template>

<script>
import { bus } from '../app'

  export default {
    data() {
      return {
          modal: false,
          text: '',
          sending: false,
          tags: [],
          title: '',
          image: null
      }
    },
    created() {
      bus.$on('createPostStatus', status=>{
        this.modal = status
      })
    },
    methods: {
      
      createPost() {
        let bodyFormData = new FormData();
        bodyFormData.append('json', JSON.stringify({
          'thinks': this.text,
          'tags': this.tags,
          'title': this.title
        }));
        bodyFormData.append('image', this.image);

        this.sending = true

        window.axios({
          method: 'post',
          url: '/api/posts',
          data: bodyFormData,
          headers: {'Content-Type': 'multipart/form-data' },
          withCredentials: true
        }).then((response) => {
          this.sending = false;
          if(response.data.created) {
            bus.$emit('posts_update');
            this.title = ''
            this.text = ''
            this.tags = []
            this.image = null
            this.modal = false
          }
        });
      }
    }
  };
</script>