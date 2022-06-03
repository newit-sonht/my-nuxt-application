<template>
  <div class="container authen">
    <Signup @submit="onSubmit"/>
  </div>
</template>

<style scoped>
  .authen {
    width: 570px;
  }
</style>


<script>
export default {
    name: 'SignupPage',
    layout: 'authen_layout',
    methods: {
      onSubmit(MyData) {
        this.$store.dispatch('signUp',MyData)
        .then(res => {
          console.log(res);
          window.location.href = '/';
        })
        .catch(e => console.log(e));
      }
    },
}
</script>

