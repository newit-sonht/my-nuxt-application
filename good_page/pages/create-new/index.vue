<template>
  <div>
    <div class="container">
      <CreateForm @submit="onSubmitted" />
    </div>
  </div>
</template>

<style scoped>
  .container {
    width: 100%;
    box-shadow: black;

  }
  .container form {
    max-width: 800px;
    width: 90vw;
    margin: auto;
  }
</style>

<script>
import axios from "axios"
import CreateForm from "@/components/create-new/CreateForm.vue";

export default {
    name: 'IndexPage',
    layout: 'main_layout',
    component: CreateForm,
    methods: {
      onSubmitted(postData) {
        axios.post('https://my-nuxt-project-3148e-default-rtdb.asia-southeast1.firebasedatabase.app/laydy.json', postData)
          .then(result => console.log(result))
          .catch(e => console.log(e));
      }
    },
}
</script>
