<template>
<div class="container">
  <EditForm :my_data="my_data" @submit="updatePost" />
</div>
</template>

<style scoped>
  .container {
    align-items: center;
    align-content: center;
    width: 50vw;
    margin: auto;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    box-sizing: border-box;
    padding: 35px;
  }
</style>

<script>
import axios from 'axios'

export default {
  name: "CardDetailEdit",
  layout: 'main_layout',
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
          window.location.href = '/card/' + this.$route.params.id;
        })
        .catch(e => {console.log(e)})
    }
  },
}
</script>
