<script setup lang="ts">

import {ref} from "vue";
import axios from "axios";

const form = ref({
  email: '',
  text: ''
})

function send() {
  axios.post('/api/support/create', form.value)
    .then(() => {
      alert('Ваше обращение отправлено')
      form.value.email = ''
      form.value.text = ''
    })
    .catch(() => alert('Ошибка отправки'))
}

</script>

<template>
  <div>
    <h3 class="text-center py-2">Поддержка</h3>
    <form class="w-50 m-auto">
      <div class="form-group">
        <label for="emailInput" class="mb-1">Email</label>
        <input
          v-model="form.email"
          type="email"
          class="form-control"
          id="emailInput"
          aria-describedby="emailHelp"
          placeholder="example@mail.ru"
        >
        <small id="emailHelp" class="form-text text-muted">На эту почту мы отправим ответ</small>
      </div>
      <div class="form-group mt-2">
        <label for="textInput" class="mb-1">Обращение</label>
        <textarea
          v-model="form.text"
          class="form-control"
          id="textInput"
          rows="5"
          placeholder="Текст обращения"
        ></textarea>
      </div>
      <button type="button" @click="send()" class="btn btn-primary mt-2">Отправить</button>
    </form>
  </div>
</template>

<style scoped>

</style>
