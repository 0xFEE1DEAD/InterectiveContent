<template>
<div>
  <b-modal v-model="modal" title="Вход" hide-footer>
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
        Пароль жолжен иметь не менее 4 символов или не больше 255
      </b-form-invalid-feedback>
    </b-input-group>
    <b-form-checkbox
      v-model="remember"
    >
      Запомнить
    </b-form-checkbox>
    <b-button :disabled="sending" class="mt-3" variant="info" block @click="loginAtion">Войти</b-button>
    <b-button :disabled="sending" class="mt-3" block @click="openRegistration">Зарегистироваться</b-button>
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
          sending: false,
          remember: false,
          password_valid: null,
          login_valid: null,
      }
    },
    created() {
      console.log('[login.vue] created')

      bus.$on('changeStatusLogin', status => {
        console.log('[login.vue] changeStatusLogin ' + status)
        this.modal = status
      })
    },
    methods: {
      openRegistration() {
        console.log('[login.vue] open registartion')

        this.modal = false
        bus.$emit('changeStatusRegistration', true)
      },
      form_validate() {
        let login_validator = this.login.length > 1 && this.login.length < 255

        if(!login_validator) {
          console.log('[login.vue] login invalid')
          this.login_valid = false
        } else {
          this.login_valid = true
        }

        let password_validator = this.password.length > 4 && this.password.length < 255

        if(!password_validator) {
          console.log('[login.vue] password invalid')
          this.password_valid = false
        } else {
          this.password_valid = true
        }

        return password_validator && login_validator
      },
      loginAtion() {
        console.log('[login.vue] login')

        if(this.form_validate()) {
          console.log('[login.vue] call login')
          this.sending = true
          bus.$emit('loading', true)
          window.axios.post('/api/users/login', {
            'login': this.login,
            'password': this.password,
            'remember': this.remember
          }).then((v) => {
            this.login = ''
            this.password = ''
            this.password_valid = null
            this.login_valid = null
            this.sending = false
            this.modal = false
            bus.$emit('loading', false)
            if(!v.data.login) {
              bus.$emit('showError', "Пользователь не найден")
            }
            bus.$emit('changeUser', v.data.user)
          })
        }

      }
    }
  };
</script>