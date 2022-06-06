<template>
  <div class="container authen">
    <Signin @submit="onSubmit"/>
  </div>
</template>

<style scoped>
  .authen {
    width: 570px;
  }
</style>

<script>
export default {
    name: 'SigninPage',
    layout: 'authen_layout',
    methods: {
      onSubmit(MyData) {
        this.$store.dispatch('signIn',MyData)
        .then(res => {
          console.log('Welcome back, you had logined successfully !!!!');
          console.log(res);
          this.$router.push({ path: '/' })
        })
        .catch(e => {
          console.log('Your gmail is not registed yet, so that you login failed !!! :((')
          console.log(e);
        });
      }
    },
}
</script>
