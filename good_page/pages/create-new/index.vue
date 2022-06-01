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
export default {
    name: 'IndexPage',
    layout: 'main_layout',
    methods: {
      onSubmitted(postData) {
        this.$store.dispatch('addPost', postData)
          .then(() => {
            this.$router.push('/complete');
          });
      }
    },
}
</script>
