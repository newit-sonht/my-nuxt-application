<template>
<div class="container">
  <EditForm :my_data="my_data" @submit="updatePost" />
</div>
</template>

<script>
import axios from 'axios'

export default {
  name: "CardDetailEdit",
  layout: 'main_layout',
  middleware: ['check-auth','auth'],
  asyncData(context) {
    return axios.get('https://my-nuxt-project-3148e-default-rtdb.asia-southeast1.firebasedatabase.app/laydy/' + context.params.id + '.json')
      .then(res => {
        return {
          my_data: { ...res.data, id: context.params.id }
        }
      })
      .catch(e => console.log(e));
  },
  methods: {
    updatePost(MyData) {
      this.$store.dispatch('editPost',MyData)
        .then(() => {
          // window.location.href = '/card/' + this.$route.params.id;
        })
        .catch()
    }
  },
}
</script>
