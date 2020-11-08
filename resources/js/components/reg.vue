<template>
<div>
  <b-modal v-model="modal" title="Регистрация" hide-footer>
    <b-input-group
      prepend="Логин"
    >
      <b-form-input :disabled="sending" :state='login_valid' v-model='login'></b-form-input>
      <b-form-invalid-feedback>
        Должен быть хотя бы 1 символ или не больше 255
      </b-form-invalid-feedback>
    </b-input-group>
    <b-input-group
      style="margin-top: 20px"
      prepend="Пароль"
      
    >
      <b-form-input :disabled="sending" :state='password_valid' v-model='password'></b-form-input>
      <b-form-invalid-feedback id="login-feedback">
        Пароли должны совпадать и иметь не менее 4 символов или не больше 255
      </b-form-invalid-feedback>
    </b-input-group>

    <b-input-group
      style="margin-top: 20px"
      prepend="Пароль"
    >
      <b-form-input :disabled="sending" :state='password_valid' v-model='password_repeat'></b-form-input>
      <b-form-invalid-feedback id="login-feedback">
        Пароли должны совпадать и иметь не менее 4 символов или не больше 255
      </b-form-invalid-feedback>
    </b-input-group>

    <b-button :disabled="sending" variant="info" class="mt-3" block @click="registration">Зарегистироваться</b-button>
  </b-modal>
</div>
</template>

<script>
import { bus } from '../app'

  export default {
    data() {
      return {
          modal: false,
          login: '',
          password: '',
          password_repeat: '',
          password_valid: null,
          login_valid: null,
          sending: false
      }
    },
    created() {
      console.log('[reg.vue] created')

      bus.$on('changeStatusRegistration', status => {
        console.log('[reg.vue] changeStatusRegistration ' + status)
        this.modal = status
      })
    },
    methods: {
      registration() {
        console.log('[reg.vue] registration clicked')

        if(this.form_validate()) {
          console.log('[reg.vue] call registartion')
          this.sending = true
          bus.$emit('loading', true)
          window.axios.post('/api/users', {
            'login': this.login,
            'password': this.password
          }).then(() => {
            this.login = ''
            this.password = ''
            this.password_repeat = ''
            this.password_valid = null
            this.login_valid = null
            this.sending = false
            this.modal = false
            bus.$emit('loading', false)
          })
        }
      },
      form_validate() {
        let login_validator = this.login.length > 1 && this.login.length < 255

        if(!login_validator) {
          console.log('[reg.vue] login invalid')
          this.login_valid = false
        } else {
          this.login_valid = true
        }

        let password_repeat_validator = this.password_repeat.length > 4 && this.password_repeat.length < 255
        let password_validator = this.password.length > 4 && this.password.length < 255

        let password_validator_all = (this.password === this.password_repeat) &&  password_repeat_validator && password_repeat_validator
        if(!password_validator_all) {
          console.log('[reg.vue] password invalid')
          this.password_valid = false
        } else {
          this.password_valid = true
        }

        return password_validator_all && login_validator
      }
    }
  };
</script>